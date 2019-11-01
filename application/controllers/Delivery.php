<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property vehilcle $vehilcle
 */

class Delivery extends MY_Controller {

	public function __construct(){
		parent::__construct();
		// $this->load->model('brand');

        //validation config
        $this->delivery_validation_config = array(
            array(
                'field' => 'expected_delivey_datetime',
                'label' => 'Expected Delivery Date',
                'rules' => 'required'
            ),
        );
    }
    
    public function index(){
        echo "Listing goes here";
    }

	public function add_update($delivery_id=null){

	    $this->data['delivery_id'] = $delivery_id;

	    if($delivery_id){
            
            $this->data['page_title'] = "Update Delivery";
            $this->data['delivery_data'] = $this->db->get_where("delivery",["id"=>$delivery_id])->row_array();
            $this->data['delivery_routes'] = array_column($this->db->get_where("delivery_routes",["delivery_id"=>$delivery_id])->result_array(),'zip_code_group_id');


        }else{
            
            $this->data['page_title'] = "Create Delivery";

            $this->data['delivery_data'] = array(
                'expected_delivey_datetime' =>  null
            );

            $this->data['delivery_routes'] = [];
        }

        if($this->input->server("REQUEST_METHOD") == "POST"){

            $this->data['is_post'] =true;
            $this->form_validation->set_rules($this->delivery_validation_config);

            if ($this->form_validation->run() == TRUE) {

                echo "<pre>";print_r($_POST);die;

                $delivery_data  =   array(
                    'expected_delivey_datetime' =>  ($this->input->post('expected_delivey_datetime')) ? $this->input->post('expected_delivey_datetime') : null
                );
                // $delivery_config;
                // $delivery_orders;
                // $delivery_routes;
                
            }else{

            }
        }

        $this->data['zip_code_groups'] = array_column($this->model->get('zip_code_groups'),"group_name","id");
        $this->data['drivers'] = $this->db->get_where('users',["is_deleted"=>0,"role_id"=>4])->result_array();    //4 is role id of driver
        $this->data['delivery_boys'] = $this->db->get_where('users',["is_deleted"=>0,"role_id"=>3])->result_array();    //3 is role id of delivery boy
        $this->data['vehicles'] = $this->db->get_where('vehicle',["is_deleted"=>0])->result_array();    //3 is role id of delivery boy

        // echo "<pre>";print_r($this->data['driver']);die;
        
		$this->load_content('delivery/add_update', $this->data);
	}

}