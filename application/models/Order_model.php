<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order_model extends CI_Model {
	public function __construct() {
        parent::__construct();
    }

    public function insert_order($orders = array(), $order_items = array()){
    	$this->db->trans_start();
		$this->db->insert('orders', $orders);
		$order_id = $this->db->insert_id();

		// order items insert
		if(!empty($order_items)){
			foreach($order_items as &$item){
				$item['order_id'] = $order_id;
				$item['created_by'] = $orders['client_id'];
			}
		}
		$this->db->insert_batch('order_items', $order_items);
		$this->db->trans_complete();
		return $this->db->trans_status();
    }
}