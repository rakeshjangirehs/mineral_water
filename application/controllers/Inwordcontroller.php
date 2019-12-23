<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inwordcontroller extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('inwordmodel');

		//validation config
		$this->zipcodegroup_validation_config = array(
            array(
                'field' => 'date',
                'label' => 'Date',
                'rules' => 'required'
            ),
            array(
                'field' => 'product_id',
                'label' => 'Product',
                'rules' => 'required'
            ),
            array(
                'field' => 'type',
                'label' => 'Type',
                'rules' => 'required'
            ),
            array(
                'field' => 'quantity',
                'label' => 'Quantity',
                'rules' => 'required'
            ),
        );
	}

	public function index($zipcode_group_id=null){

	    $this->data['zipcode_group_id'] = $zipcode_group_id;
        
	    if($zipcode_group_id){
            $this->data['form_title'] = "Update Entry";
            $this->data['group_details'] = $this->model->get("inward_outword",$zipcode_group_id,"id");

        }else{
            $this->data['form_title'] = "Add Entry";
            $this->data['group_details'] = array('id'=>null,'date'=>null,'product_id'=>null,'quantity'=>null,'warehouse_id'=>null,'type'=>'Inword');
            $this->data['group_zip_codes'] = [];
        }


		if($this->input->is_ajax_request()){
			$colsArr = array(
				'inward_outword.date',
				'(CASE WHEN warehouses.name IS NOT NULL THEN warehouses.name ELSE "Office" END)',
                'products.product_name',
                'inward_outword.type',
                'inward_outword.quantity',
                'CONCAT(users.first_name, " ",IFNULL(users.last_name,""))',
				'action'
			);

            $query = $this
                ->model
                ->common_select('inward_outword.*,products.product_name,(CASE WHEN warehouses.name IS NOT NULL THEN warehouses.name ELSE "Office" END) as warehouse_name, CONCAT(users.first_name, " ",IFNULL(users.last_name,"")) AS acted_by')
                ->common_join('products','products.id = inward_outword.product_id','LEFT')
                ->common_join('warehouses','warehouses.id = inward_outword.warehouse_id','LEFT')
                ->common_join('users','users.id = inward_outword.created_by','LEFT')
                ->common_get('inward_outword');

			echo $this->model->common_datatable($colsArr, $query, "",NULL,false);die;
		}

        if($this->input->server("REQUEST_METHOD") == "POST"){

            // echo "<pre>";print_r($_POST);die;

            $this->form_validation->set_rules($this->zipcodegroup_validation_config);

            if ($this->form_validation->run() == TRUE){

                // echo "<pre>";print_r($_POST);die;
                
                $data = array(
                    'date'  =>  ($this->input->post('date')) ? $this->input->post('date') : null,
                    'product_id'  =>  ($this->input->post('product_id')) ? $this->input->post('product_id') : null,
                    'type'  =>  ($this->input->post('type')) ? $this->input->post('type') : null,
                    'quantity'  =>  ($this->input->post('quantity')) ? $this->input->post('quantity') : null,
                    'warehouse_id'  =>  ($this->input->post('warehouse_id')) ? $this->input->post('warehouse_id') : null,
                );

                
                if($this->inwordmodel->insert_update($data, $zipcode_group_id)){
                    $msg = 'Data inserted successfully.';
                    $type = 'success';
                    if($zipcode_group_id){
                        $msg = 'Data updated successfully.';
                        $this->flash($type, $msg);
                    }else{
                        $this->flash($type, $msg);
                    }
                }else{
                    $this->flash('error', 'Some error ocurred. Please try again later.');
                }
                redirect("inwordcontroller/index/{$zipcode_group_id}",'location');
            }
        }

        $this->data['page_title'] = 'Inward Outward';
        $this->data['products'] = $this->db->get("products")->result_array();
        $this->data['warehouses'] = $this->db->get("warehouses")->result_array();
        // echo "<pre>";print_r($this->data['products']);die;
		$this->load_content('inword/inword_list', $this->data);
    }

    public function bulk_inword(){

        if($this->input->server("REQUEST_METHOD") == "POST"){
            $data = array(
                'warehouse_id'  =>  ($this->input->post('warehouse_id')) ? $this->input->post('warehouse_id') : null,
                'date'  =>  ($this->input->post('date')) ? $this->input->post('date') : null,
                'type'  =>  'Inward',
                'created_at' =>     date('Y-m-d'),
                'created_by' => USER_ID
            );

            $products  =  ($this->input->post('products')) ? $this->input->post('products') : null;

            if($products){
                $products = array_map(function($arr) use($data){
                    return array_merge($data,$arr);
                },$products);

                if($this->db->insert_batch("inward_outword",$products)){
                    $this->flash("success", "Bulk Inword success.");
                }else{
                    $this->flash("error", "Bulk Inword failed.");
                }
            }else{
                $this->flash("error", "Invalid Products Data.");
            }
            redirect("inwordcontroller",'location');
        }
        $this->data['page_title'] = 'Bulk Inward';
        $this->data['products'] = $this->db->get("products")->result_array();
        $this->data['warehouses'] = $this->db->get("warehouses")->result_array();
        $this->load_content('inword/bulk_inward', $this->data);
    }
}