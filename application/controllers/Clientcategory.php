<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property vehilcle $vehilcle
 */

class Clientcategory extends MY_Controller {

	public function __construct(){

        parent::__construct();
        
		$this->load->model('Clientcategory_model');

        //validation config
        $this->brands_validation_config = array(
            array(
                'field' => 'name',
                'label' => 'Category Name',
                'rules' => 'required'
            ),
        );
	}

	public function index($vehicle_id=null){

	    $this->data['vehicle_id'] = $vehicle_id;

	    if($vehicle_id){
            $this->data['form_title'] = "Update Category";
            $this->data['vehicle_details'] = $this->model->get("client_categories",$vehicle_id,"id");
        }else{
            $this->data['form_title'] = "Add Category";
            $this->data['vehicle_details'] = array('name'=>'');
        }


		if($this->input->is_ajax_request()){
			$colsArr = array(
                'name',
				'action'
			);

            $query = $this
                ->model
                ->common_select('`client_categories`.*')
                ->common_get('`client_categories`');

			echo $this->model->common_datatable($colsArr, $query, "client_categories.is_deleted = 0");die;
		}

        if($this->input->server("REQUEST_METHOD") == "POST"){

            $this->form_validation->set_rules($this->brands_validation_config);

            if ($this->form_validation->run() == TRUE) {

                $data = array(
                    'name' => ($this->input->post('name')) ? $this->input->post('name') : null,
                );

                if ($this->Clientcategory_model->insert_update($data, $vehicle_id)) {
                    $msg = 'Category created successfully.';
                    $type = 'success';
                    if ($vehicle_id) {
                        $msg = "Category updated successfully.";
                        $this->flash($type, $msg);
                    } else {
                        $this->flash($type, $msg);
                    }
                } else {
                    $this->flash('error', 'Some error ocurred. Please try again later.');
                }
                redirect("clientcategory", 'location');
            }
        }

		$this->data['page_title'] = 'Client Categies';
		$this->load_content('client_category/client_category_list', $this->data);
	}

    public function delete($vehicle_id){
        if($this->db->update("client_categories",array('is_deleted'=>1),array('id'=>$vehicle_id))){
            $this->flash("success","Category Deleted Successfully");
        }else{
            $this->flash("error","Category not Deleted");
        }
        redirect("clientcategory");
    }

    public function brands_export(){
        $query = $this
            ->model
            ->common_select('`brands`.`brand_name`')
            ->common_get('`brands`');

        $resultData = $this->db->query($query)->result_array();
        $headerColumns = implode(',', array_keys($resultData[0]));
        $filename = 'brands-'.time().'.xlsx';
        $title = 'Brand List';
        $sheetTitle = 'Brand List';
        $this->export( $filename, $title, $sheetTitle, $headerColumns,  $resultData );
    }

}