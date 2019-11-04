<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property vehilcle $vehilcle
 */

class Delivery extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('delivery_model');
		$this->load->model('order_model');

        //validation config
        $this->delivery_validation_config = array(
            // array(
            //     'field' => 'expected_delivey_datetime',
            //     'label' => 'Expected Delivery Date',
            //     'rules' => 'required'
            // ),
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
            
            $delivery_config = $this->db->get_where("delivery_config",["delivery_id"=>$delivery_id])->result_array();

            foreach($delivery_config as $k=>$conf){
                $delivery_config[$k]['selected_orders'] = array_column($this->db->get_where("delivery_config_orders",['delivery_config_id'=>$conf['id']])->result_array(),'order_id');                
            }
            $this->data['delivery_config'] = $delivery_config;

            $whr = "orders.created_at <= '{$this->data['delivery_data']['created_at']}'"; 
            $this->data['config_orders'] = $this->order_model->get_orders_by_zip_code_group($this->data['delivery_routes'],$whr,true);

            // echo "<pre>";print_r($this->data['config_orders']);die;
            // echo "<pre>".$this->db->last_query()."</pre>";
            // echo "<pre>";print_r($delivery_config);die;

        }else{
            
            $this->data['page_title'] = "Create Delivery";

            $this->data['delivery_data'] = array(
                'expected_delivey_datetime' =>  null,
                'pickup_location'           =>  "office",
                'warehouse'                 =>  null,
            );

            $this->data['delivery_routes'] = [];
            $this->data['config_orders'] = [];
            $this->data['delivery_config'] = [];
        }

        if($this->input->server("REQUEST_METHOD") == "POST"){

            $this->data['is_post'] =true;
            $this->form_validation->set_rules($this->delivery_validation_config);

            if (TRUE) {    //if ($this->form_validation->run() == TRUE) {   //remove server side validation

                // echo "<pre>";print_r($_POST);die;

                $delivery_data  =   array(
                    'expected_delivey_datetime' =>  ($this->input->post('expected_delivey_datetime')) ? $this->input->post('expected_delivey_datetime') : null,
                    'pickup_location'           =>  ($this->input->post('pickup_location')) ? $this->input->post('pickup_location') : null,
                    'warehouse'                 =>  ($this->input->post('warehouse') && $this->input->post('pickup_location') =='warehouse') ? $this->input->post('warehouse') : null,
                    'status'			        =>	'Active'
                );

                $deliveries = ($this->input->post('deliveries')) ? $this->input->post('deliveries') : [];
                $delivery_routes = ($this->input->post('zip_code_group')) ? $this->input->post('zip_code_group') : [];                

                if ($this->delivery_model->insert_update($delivery_data,$delivery_routes,$deliveries,$delivery_id)) {
                    $msg = 'Delivery created successfully.';
                    $type = 'success';
                    if ($delivery_id) {
                        $msg = "Delivery updated successfully.";
                        $this->flash($type, $msg);
                    } else {
                        $this->flash($type, $msg);
                    }
                } else {
                    $this->flash('error', 'Some error ocurred. Please try again later.');
                }
                echo 'done';die;
                redirect('deliver/add_update', 'location');
                
            }else{
                echo "Validation Failed"; die;
            }
        }

        $this->data['zip_code_groups'] = array_column($this->model->get('zip_code_groups'),"group_name","id");
        $this->data['drivers'] = $this->db->get_where('users',["is_deleted"=>0,"role_id"=>4])->result_array();    //4 is role id of driver
        $this->data['delivery_boys'] = $this->db->get_where('users',["is_deleted"=>0,"role_id"=>3])->result_array();    //3 is role id of delivery boy
        $this->data['vehicles'] = $this->db->get_where('vehicle',["is_deleted"=>0])->result_array();
        $this->data['warehouses'] = $this->db->get_where('warehouses',["is_deleted"=>0])->result_array();

        // echo "<pre>";print_r($this->data['driver']);die;
        
		$this->load_content('delivery/add_update', $this->data);
	}

}