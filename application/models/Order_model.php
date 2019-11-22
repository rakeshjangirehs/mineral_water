<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order_model extends CI_Model {
	public function __construct() {
        parent::__construct();
    }

    public function insert_order($orders = array(), $order_items = array(),$client = null){	//

		$this->db->trans_start();
		
		if($client){
			if($this->db->insert("clients",$client)){
				$orders['client_id'] = $this->db->insert_id();
				$this->db->where("id = {$client['lead_id']}")->update("leads",["is_converted"=>1]);				
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
                    #CONCAT_WS(' ', `clients`.`first_name`, `clients`.`last_name`) AS `client_name`,
                    `clients`.`credit_balance`,
                    SUM(`payment_details`.`total_payment`) AS `paid_amount`
                FROM `orders`
                LEFT JOIN `clients` ON `clients`.`id` = `orders`.`client_id`
                LEFT JOIN `payment_details` ON `payment_details`.`order_id` = `orders`.`id`
                WHERE `orders`.`client_id` = {$client_id}
                GROUP BY `orders`.`id`
                HAVING (SUM(`payment_details`.`total_payment`) IS NULL OR SUM(`payment_details`.`total_payment`) < `orders`.`payable_amount`)
                ORDER BY `orders`.`created_at` ASC";

	    return $this->db->query($sql)->result_array();
	}
}