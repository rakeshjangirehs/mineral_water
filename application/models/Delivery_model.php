<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Delivery_model extends CI_Model {

	public function __construct() {
        parent::__construct();
    }

    public function insert_update($delivery_data,$delivery_routes,$deliveries,$delivery_id=null){
	
		$expected_delivery_date = date('d-m-Y',strtotime($delivery_data['expected_delivey_datetime']));
		$action = ($delivery_id) ? 'updated' : 'created';

		$this->db->trans_start();		

		if($delivery_id){
			
			//Deliver Data
			$delivery_data['updated_at'] = date('Y-m-d H:i:s');
			$delivery_data['updated_by'] = USER_ID;			
			
			//Update Delivery Data
			$this->db->update("delivery", $delivery_data,['id'=>$delivery_id]);

		}else{

			//Deliver Data
			$delivery_data['created_at'] = date('Y-m-d H:i:s');
			$delivery_data['created_by'] = USER_ID;
			
			//Insert Delivery Data
			$this->db->insert("delivery", $delivery_data);
			$delivery_id = $this->db->insert_id();
		}


		//Delete old routes
		$this->db->delete("delivery_routes",['delivery_id'=>$delivery_id]);
		//Make Route Data
		$route_data = [];
		foreach($delivery_routes as $k=>$route){
			$route_data[] = array(
				'delivery_id'		=>	$delivery_id,
				'zip_code_group_id'	=>	$route,
				'created_at'		=>	date('Y-m-d H:i:s'),
				'created_by'		=>	USER_ID,
				'status'			=>	'Active'
			);
		}
		
		//Insert Routes
		if($route_data){
			$this->db->insert_batch("delivery_routes",$route_data);
		}

		//Update delivery_id to null
		$this->db->update("orders",["delivery_id"=> null],["delivery_id"=>$delivery_id]);
		
		$new_orders = [];
		
		$this->db->delete("delivery_config",['delivery_id'=>$delivery_id]);
		$this->db->delete("delivery_config_orders",['delivery_id'=>$delivery_id]);
		
		$notifiable_user_arr = [];	//delivery boy & salesman

		foreach($deliveries as $k=>$delivery){
			
			if(isset($delivery['orders']) && count($delivery['orders']) > 0){

				$delivery_config = array(
					'delivery_id'		=>	$delivery_id,
					'vehicle_id'		=>	$delivery['vehicles'],
					'driver_id'			=>	$delivery['drivers'],
					'delivery_boy_id'	=>	($delivery['delivery_boys']) ? $delivery['delivery_boys'] : null,
					'created_at'		=>	date('Y-m-d H:i:s'),
					'created_by'		=>	USER_ID,
					'status'			=>	'Active'
				);

				if($this->db->insert("delivery_config",$delivery_config)){
					
					$delivery_config_id	 = $this->db->insert_id();

					foreach($delivery['orders'] as $k=>$order_id){

						$new_orders[] = $order_id;
						$delivery_config_orders = array(
							'delivery_id'			=>	$delivery_id,
							'delivery_config_id	'	=>	$delivery_config_id	,
							'order_id'				=>	$order_id,
							'created_at'		=>	date('Y-m-d H:i:s'),
							'created_by'		=>	USER_ID,
							'status'			=>	'Active'
						);

						$this->db->insert("delivery_config_orders",$delivery_config_orders);

						$order_data_qry = "SELECT
												clients.client_name,
												client_delivery_addresses.address,
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

						$notifiable_user_arr[] = array(
							'user_id'	=>	$delivery_config['driver_id'],							
							'message'	=>	"Delivery {$action} for {$order_data_get['client_name']} at {$order_data_get['address']} with expected delivery on {$expected_delivery_date} having order amount Rs. {$order_data_get['effective_price']} with Order Id {$order_id}",
						);

						if($delivery_config['delivery_boy_id']){
							$notifiable_user_arr[] = array(
								'user_id'	=>	$delivery_config['delivery_boy_id'],							
								'message'	=>	"Delivery {$action} for {$order_data_get['client_name']} at {$order_data_get['address']} with expected delivery on {$expected_delivery_date} having order amount Rs. {$order_data_get['effective_price']} with Order Id {$order_id}",
							);
						}
					}
				}
			}
		}

		//Send Notification
		if($notifiable_user_arr){
			
			foreach($notifiable_user_arr AS $notifiable_user){
				$users = $this->db->where("users.id",$notifiable_user['user_id'])
							->where("user_devices.device_id IS NOT NULL")
							->select("users.id as user_id, user_devices.device_id")
							->join("user_devices","user_devices.user_id = users.id","left")
							->group_by("users.id")
							->get("users")->result_array();
							
				$this->fcm->send($users,"Order Delivery", $notifiable_user['message']);
			}
		}

		if($new_orders){
			$this->db->where_in("id",$new_orders)->update("orders",["delivery_id"=> $delivery_id]);
		}
		
		$this->db->trans_complete();
		
		if($this->db->trans_status()){
            return $delivery_id;
        }else{
            return false;
        }
	}
	
	public function get_orders_by_zip_code_group($zip_code_group_ids,$where=null){

		$zip_code_group_ids_str = implode(",",$zip_code_group_ids);
		$whr = ($where) ? " AND ".$where : '';
		
		$query = "SELECT
						orders.*,
						clients.client_name,
						zip_codes.zip_code,
						SUM(IFNULL(products.weight, 0)*IFNULL(order_items.quantity, 0)) as `order_weight`
					FROM orders
					LEFT JOIN clients on clients.id = orders.client_id
					LEFT JOIN order_items on order_items.order_id = orders.id
					LEFT JOIN products on products.id = order_items.product_id
					LEFT JOIN client_delivery_addresses on client_delivery_addresses.id = orders.delivery_address_id
					LEFT JOIN zip_codes on client_delivery_addresses.zip_code_id = zip_codes.id
					WHERE client_delivery_addresses.zip_code_id IN (
						SELECT
							DISTINCT(group_to_zip_code.zip_code_id) as zip_code_id
						FROM zip_code_groups
						LEFT JOIN group_to_zip_code ON group_to_zip_code.zip_code_group_id = zip_code_groups.id
						WHERE zip_code_groups.id IN ({$zip_code_group_ids_str})
					)
					$whr
					GROUP BY orders.id";
						
		$data = $this->db->query($query)->result_array();
		// echo "<pre>".$this->db->last_query();die;
		return $data;
	}
}