<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function index(){

		$total_pending_orders = $this->db->query("SELECT
							count(*) as `total_pending_orders`
						FROM `orders`
						WHERE `delivery_id` IS NULL")->row_array();

		$total_on_the_way_orders = $this->db->query("SELECT
														count(*) as `total_on_the_way_orders`
													FROM `orders`
													LEFT JOIN `delivery_config_orders` ON `delivery_config_orders`.`order_id` = `orders`.`id`
													WHERE `orders`.`delivery_id` IS NOT NULL AND `delivery_config_orders`.`delivery_datetime` IS NULL")->row_array();

		$total_pending_leads = $this->db->query("SELECT
														count(*) as `total_pending_leads`
													FROM `leads`
													WHERE `leads`.`is_converted` = 0 AND `leads`.`is_deleted` = 0")->row_array();
		
		$total_clients = $this->db->query("SELECT
												count(*) as `total_clients`
											FROM `clients`
											WHERE `clients`.`is_deleted` = 0")->row_array();

		$this->data['total_pending_orders'] = $total_pending_orders['total_pending_orders'];
		$this->data['total_on_the_way_orders'] = $total_on_the_way_orders['total_on_the_way_orders'];
		$this->data['total_pending_leads'] = $total_pending_leads['total_pending_leads'];
		$this->data['total_clients'] = $total_clients['total_clients'];
		$this->data['page_title'] = 'Dashboard';
		//$this->data['sub_page_title'] = 'Overview &amp; stats';
		$this->load_content('dashboard', $this->data);
	}
}