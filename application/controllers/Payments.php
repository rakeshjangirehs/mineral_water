<?php  
 defined('BASEPATH') OR exit('No direct script access allowed'); 
 /** Developer: Milan Soni 
  * Created Date: 2019-09-11 11:17:03 
  * Created By : CLI 
 */ 
 
class Payments extends MY_Controller {
 
 	public function __construct() {
 		parent::__construct();
 		$this->load->model('order_model');
 		$this->load->model('client');
 	}

 	public function index($client_id = NULL){
 		$this->data['client_detail'] = $this->client->get_client($client_id);
 		$this->data['invoice_list'] = $this->order_model->get_invoice($client_id);
 		$this->data['page_title'] = 'Post Payment';
		$this->load_content('payment/add', $this->data);
 	}
}