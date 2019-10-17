<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property vehilcle $vehilcle
 */

class Brands extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('brand');

        //validation config
        $this->brands_validation_config = array(
            array(
                'field' => 'brand_name',
                'label' => 'Brand Name',
                'rules' => 'required'
            ),
        );
	}

	public function index($vehicle_id=null){

	    $this->data['vehicle_id'] = $vehicle_id;

	    if($vehicle_id){
            $this->data['form_title'] = "Update Brand";
            $this->data['vehicle_details'] = $this->model->get("brands",$vehicle_id,"id");
        }else{
            $this->data['form_title'] = "Add Brand";
            $this->data['vehicle_details'] = array('brand_name'=>'');
        }


		if($this->input->is_ajax_request()){
			$colsArr = array(
                'brand_name',
				'action'
			);

            $query = $this
                ->model
                ->common_select('`brands`.*')
                ->common_get('`brands`');

			echo $this->model->common_datatable($colsArr, $query, "brands.is_deleted = 0");die;
		}

        if($this->input->server("REQUEST_METHOD") == "POST"){

            $this->form_validation->set_rules($this->brands_validation_config);

            if ($this->form_validation->run() == TRUE) {

                $data = array(
                    'brand_name' => ($this->input->post('brand_name')) ? $this->input->post('brand_name') : null,
                );

                if ($this->brand->insert_update($data, $vehicle_id)) {
                    $msg = 'Brand created successfully.';
                    $type = 'success';
                    if ($vehicle_id) {
                        $msg = "Brand updated successfully.";
                        $this->flash($type, $msg);
                    } else {
                        $this->flash($type, $msg);
                    }
                } else {
                    $this->flash('error', 'Some error ocurred. Please try again later.');
                }
                redirect("brands", 'location');
            }
        }

		$this->data['page_title'] = 'Brands';
		$this->load_content('brands/brand_list', $this->data);
	}

    public function delete($vehicle_id){
        if($this->db->update("brands",array('is_deleted'=>1),array('id'=>$vehicle_id))){
            $this->flash("success","Brand Deleted Successfully");
        }else{
            $this->flash("error","Brand not Deleted");
        }
        redirect("brands");
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