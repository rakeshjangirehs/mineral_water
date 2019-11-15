<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schemes extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('scheme');
	}

	public function index(){
		if($this->input->is_ajax_request()){

			$colsArr = array(
				'name',
				'type',
				'action'
			);

			$query = $this
						->model
						->common_select("schemes.*")
						// ->common_join('roles','roles.id = users.role_id','LEFT')
						// ->common_join('user_zip_codes','user_zip_codes.user_id = users.id','LEFT')
						// ->common_join('zip_codes','user_zip_codes.zip_code_id = zip_codes.id','LEFT')
                        // ->common_join('user_zip_code_groups','user_zip_code_groups.user_id = users.id','LEFT')
                        // ->common_join('zip_code_groups','user_zip_code_groups.zip_code_group_id = zip_code_groups.id','LEFT')
                        // ->common_group_by("`schemes`.`id`")
						->common_get('schemes');

            echo $this->model->common_datatable($colsArr, $query, "schemes.is_deleted = 0");die;
		}
		$this->data['page_title'] = 'Scheme List';
		$this->load_content('schemes/scheme_list', $this->data);
	}

	public function add_update( $id = NULL ){
		
		if($id){
			
			$this->data['page_title'] = "Update Schemes";
			$scheme_data = $this->db->get_where("schemes",["id"=>$id])->row_array();
			$scheme_data['scheme_products']	=	$this->db->get_where("scheme_products",["scheme_id"=>$id])->result_array();
			// echo "<pre>";print_r($scheme_data);die;
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
				'match_mode'	=>	null,
				'free_product_id'=>	null,
				'free_product_qty'=>null,
				'scheme_products'=>	[],
			);
		}
		
		if($this->input->server("REQUEST_METHOD") == "POST"){
			
			// echo "<pre>";print_r($_POST);die;

			$scheme_type = ($this->input->post('type')) ? $this->input->post('type') : null;
			$gift_mode = ($this->input->post('gift_mode')) ? $this->input->post('gift_mode') : null;

			$scheme_products = null;

			$scheme_data = array(
				'name'			=>	($this->input->post('name')) ? $this->input->post('name') : null,
				'description'	=>	($this->input->post('description')) ? $this->input->post('description') : null,
				'start_date'	=>	($this->input->post('start_date')) ? $this->input->post('start_date') : null,
				'end_date'		=>	($this->input->post('end_date')) ? $this->input->post('end_date') : null,
				'match_mode'	=>	null,
				'type'			=>	$scheme_type,
				'gift_mode'		=>	$gift_mode,
				'order_value'	=>	null,
				'discount_mode'	=>	null,
				'discount_value'=>	null,
				'free_product_id'=>	null,
				'free_product_qty'=>null,
			);
			

			if($gift_mode=='cash_benifit'){
				$scheme_data['discount_mode'] = ($this->input->post('discount_mode')) ? $this->input->post('discount_mode') : null;
				$scheme_data['discount_value'] = ($this->input->post('discount_value')) ? $this->input->post('discount_value') : null;
			}elseif($gift_mode=='free_product'){
				$scheme_data['free_product_id'] = ($this->input->post('free_product_id')) ? $this->input->post('free_product_id') : null;
				$scheme_data['free_product_qty'] = ($this->input->post('free_product_qty')) ? $this->input->post('free_product_qty') : null;				
			}

			if($scheme_type=='price_scheme'){
				$order_value = ($this->input->post('order_value')) ? $this->input->post('order_value') : null;
				$scheme_data['order_value'] = $order_value;
			}elseif($scheme_type=='product_order_scheme'){				
				$scheme_data['match_mode'] = ($this->input->post('match_mode')) ? $this->input->post('match_mode') : null;
				$scheme_products = ($this->input->post('products')) ? $this->input->post('products') : null;
			}

			if ($this->scheme->insert_update($scheme_data, $scheme_products, $id)) {
				$msg = 'Scheme created successfully.';
				$type = 'success';
				if ($id) {
					$msg = "Scheme updated successfully.";
					$this->flash($type, $msg);
				} else {
					$this->flash($type, $msg);
				}
			} else {
				$this->flash('error', 'Some error ocurred. Please try again later.');
			}
			redirect('schemes', 'location');

		}
		
		
        $this->data['id'] = $id;        
		$this->data['scheme_data'] = $scheme_data;
		$this->data['products'] = $this->db->get("products")->result_array();
		// echo "<pre>";print_r($this->data['products']);die;
		$this->load_content('schemes/add_update', $this->data);
	}

	public function delete($scheme_id){

		$this->db->trans_start();

		$this->db->delete("scheme_products",["scheme_id"=>$scheme_id]);
		$this->db->delete("schemes",["id"=>$scheme_id]);

        $this->db->trans_complete();
		
		if($this->db->trans_status()){
            $this->flash("success","Scheme deleted.");
        }else{
            $this->flash("error","Scheme not deleted.");
        }
        redirect("schemes");
	}

}