<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schemes extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('scheme');
	}

	public function index(){
		
	}

	public function add_update( $id = NULL ){
		
		if($id){
			
			$this->data['page_title'] = "Update Schemes";
			// $scheme_data = 

		}else{
			
			$this->data['page_title'] = "Create Schemes";
			
			$scheme_data = array(
				'name'			=>	null,
				'description'	=>	null,
				'start_date'	=>	null,
				'end_date'		=>	null,
				'type'			=>	null,
				'order_value'	=>	null,
				'gift_mode'		=>	null,
				'discount_mode'	=>	null,
				'discount_value'=>	null,
				'match_mode'=>	null,
			);
		}
		
		if($this->input->server("REQUEST_METHOD") == "POST"){
			echo "<pre>";print_r($_POST);die;
		}
		
		
        $this->data['id'] = $id;        
		$this->data['scheme_data'] = $scheme_data;
		$this->data['products'] = $this->db->get("products")->result_array();
		// echo "<pre>";print_r($this->data['products']);die;
		$this->load_content('schemes/add_update', $this->data);
	}

}