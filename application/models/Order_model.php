<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order_model extends MY_Model {
	public function __construct() {
        parent::__construct();
    }

    public function add_order($orders = array(), $order_items = array(),$client = null){

		$this->db->trans_start();
		
		if($client){
			
			if($this->db->insert("clients",$client)){

				$client_id = $this->db->insert_id();

				$orders['client_id'] = $client_id;
				
				$this->db->where("id = {$client['lead_id']}")->update("leads",["is_converted"=>1]);

				$client_delivery_addresses_data = array(
					'lead_id'	=>	null,
					'client_id'	=>	$client_id,
					'updated_at'=>	date('Y-m-d'),
					'updated_by'=>	$orders['created_by'],
				);

				$this->db->where("lead_id = {$client['lead_id']}")->update("client_delivery_addresses",$client_delivery_addresses_data);

				//Insert product price for each product in client_product_price table for newly created client.
				if($products=$this->db->where("is_deleted = 0")->get("products")->result_array()){
					$products = array_map(function($product) use($client_id){
						return array(
							'product_id'    =>  $product['id'],
							'sale_price'    =>  $product['sale_price'],
							'client_id'     =>  $client_id,
							'created_at'    =>  date('Y-m-d H:i:s'),
							'status'        =>  'Active'
						);
					},$products);
	
					$this->db->insert_batch("client_product_price",$products);
				}
			}
		}

		$this->db->insert('orders', $orders);
		$order_id = $this->db->insert_id();

		// order items insert
		if(!empty($order_items)){
			foreach($order_items as &$item){
				$item['order_id'] = $order_id;
			}
		}

		$this->db->insert_batch('order_items', $order_items);
		
		$this->db->trans_complete();
		if($this->db->trans_status()){
            return $order_id;
        }else{
            return false;
        }
    }

    public function get_invoice($client_id){

	    /*
    	return $this->db->select('orders.id as order_id, orders.client_id, CONCAT_WS(" ", `first_name`, `last_name`) AS `client_name`, IFNULL(payments.paid_amount,0) AS `paid_amount`, IFNULL(payments.credit_amount, 0) AS `credit_amount`, IFNULL(payments.partial_amount,0) AS `partial_amount`, orders.payable_amount')
    						->from('orders')
    						->join('clients', 'clients.id = orders.client_id', 'LEFT')
    						->join('payments', 'payments.order_id = orders.id', 'LEFT')
    						->where('orders.client_id', $client_id)
    						->where('(payments.paid_amount IS NULL OR payments.paid_amount = 0)', NULL, FALSE)
    						->where('(payments.status IS NULL || payments.status = "PARTIAL" || payments.status = "PENDING")', NULL, FALSE)
    						->get()
    						->result_array();
	    */
	    $sql = "SELECT
                    `orders`.*,
					`clients`.`client_name`,
					`clients`.`contact_person_name_1`,
					`clients`.`contact_person_1_phone_1`,
                    `clients`.`credit_balance`,
                    SUM(`payment_details`.`total_payment`) AS `paid_amount`
					,(CASE
						WHEN schemes.gift_mode='cash_benifit' THEN (CASE
							WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
							ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
						END)
						ELSE orders.payable_amount
					END) AS effective_payment
                FROM `orders`
                LEFT JOIN `clients` ON `clients`.`id` = `orders`.`client_id`
                LEFT JOIN schemes ON schemes.id = orders.scheme_id
                LEFT JOIN `payment_details` ON `payment_details`.`order_id` = `orders`.`id`
                WHERE `orders`.`client_id` = {$client_id}
                GROUP BY `orders`.`id`
                #HAVING (SUM(`payment_details`.`total_payment`) IS NULL OR SUM(`payment_details`.`total_payment`) < `orders`.`payable_amount`)
                HAVING (SUM(`payment_details`.`total_payment`) IS NULL OR SUM(`payment_details`.`total_payment`) < effective_payment)
                ORDER BY `orders`.`created_at` ASC";

	    return $this->db->query($sql)->result_array();
	}

	public function order_approve($order_id,$action,$new_order_value,$quantity_update_product=[],$product_to_remove=null){

		$this->db->trans_start();

		//remove products
		if($product_to_remove){
			$this->db->where("order_id",$order_id)->where_in("product_id",$product_to_remove)->delete("order_items");
		}

		//update sale price in client_product_list
		if($quantity_update_product){

			foreach($quantity_update_product as $prod){
				$order_items_whr = array(
					'order_id'	=>	$order_id,
					'product_id'=>	$prod['product_id'],
				);
				$order_items_dt = array(
					'effective_price'	=>	$prod['sale_price'],
					'actual_price'		=>	$prod['sale_price'],
				);
				$this->db->where($order_items_whr)->update("order_items",$order_items_dt);

				$cpp_whr = array(
					'client_id'	=>	$prod['client_id'],
					'product_id'=>	$prod['product_id'],
				);
				$cpp_dt = array(
					'sale_price'	=>	$prod['sale_price'],
				);
				$this->db->where($cpp_whr)->update("client_product_price",$cpp_dt);
			}
		}

		//change order status
		$data = array(
			'payable_amount'=>	$new_order_value,
			'order_status'	=>	($action=='accept') ? "Approved" : "Rejected"
		);

		//change order payable amount too.
		$this->db->where("id",$order_id)->update("orders",$data);


		$order_data_qry = "SELECT
								clients.client_name,
								client_delivery_addresses.address,
								DATE_FORMAT(orders.expected_delivery_date,'%Y-%m-%d') as expected_delivey_datetime_dt,
								(CASE
									WHEN schemes.gift_mode='cash_benifit' THEN (CASE
										WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
										ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
									END)
									ELSE orders.payable_amount
								END) AS `effective_price`
							FROM orders
							LEFT JOIN schemes ON schemes.id = orders.scheme_id
							LEFT JOIN client_delivery_addresses ON client_delivery_addresses.id = orders.delivery_address_id
							LEFT JOIN clients ON clients.id = orders.client_id
							WHERE orders.id = {$order_id}";
											
		$order_data_get = $this->db->query($order_data_qry)->row_array();


		// Notification Send
		$order_user = $this->db
						->select("users.id as user_id, user_devices.device_id")
						->where("orders.id",$order_id)
						// ->where("user_devices.device_id IS NOT NULL")
						->join("users","users.id = orders.created_by","left")
						->join("user_devices","user_devices.user_id = users.id","left")
						->group_by("users.id,user_devices.device_id")
						->get("orders")->result_array();
		
		if($order_user){
			$message =	($action=='accept') ? "approved" : "rejected";
			$messageTitle =	ucfirst($message);
			$this->fcm->send($order_user,"Order {$messageTitle}", "Order No. {$order_id} for {$order_data_get['client_name']} has been {$message} with final amount {$order_data_get['effective_price']}. Delivery date is {$order_data_get['expected_delivey_datetime_dt']}");
		}else{
			log_message('error',"Order Approval Notification cant be send, because no user found with device_id Order ID: {$order_id} File: Order_model, Line:  ".__LINE__);
		}

		$this->db->trans_complete();
		if($this->db->trans_status()){
            return $order_id;
        }else{
            return false;
        }
	}
}