<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property vehilcle $vehilcle
 */

class Warehouses extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('warehouse');

        //validation config
        $this->brands_validation_config = array(
            array(
                'field' => 'name',
                'label' => 'Warehouse Name',
                'rules' => 'required'
            ),
        );
	}

	public function index($vehicle_id=null){

	    $this->data['vehicle_id'] = $vehicle_id;

	    if($vehicle_id){
            $this->data['form_title'] = "Update Warehouse";
            $this->data['vehicle_details'] = $this->model->get("warehouses",$vehicle_id,"id");
        }else{
            $this->data['form_title'] = "Add Warehouse";
            $this->data['vehicle_details'] = array('name'=>'');
        }


		if($this->input->is_ajax_request()){
			$colsArr = array(
                'name',
				'action'
			);

            $query = $this
                ->model
                ->common_select('`warehouses`.*')
                ->common_get('`warehouses`');

			echo $this->model->common_datatable($colsArr, $query, "warehouses.is_deleted = 0");die;
		}

        if($this->input->server("REQUEST_METHOD") == "POST"){

            $this->form_validation->set_rules($this->brands_validation_config);

            if ($this->form_validation->run() == TRUE) {

                $data = array(
                    'name' => ($this->input->post('name')) ? $this->input->post('name') : null,
                );

                if ($this->warehouse->insert_update($data, $vehicle_id)) {
                    $msg = 'Warehouse created successfully.';
                    $type = 'success';
                    if ($vehicle_id) {
                        $msg = "Warehouse updated successfully.";
                        $this->flash($type, $msg);
                    } else {
                        $this->flash($type, $msg);
                    }
                } else {
                    $this->flash('error', 'Some error ocurred. Please try again later.');
                }
                redirect("warehouses", 'location');
            }
        }

		$this->data['page_title'] = 'Warehouses';
		$this->load_content('warehouses/warehouse_list', $this->data);
	}

    public function delete($vehicle_id){
        if($this->db->update("warehouses",array('is_deleted'=>1),array('id'=>$vehicle_id))){
            $this->flash("success","Warehouse Deleted Successfully");
        }else{
            $this->flash("error","Warehouse not Deleted");
        }
        redirect("warehouses");
    }

    public function brands_export(){
        $query = $this
            ->model
            ->common_select('`warehouses`.`name`')
            ->common_get('`warehouses`');

        $resultData = $this->db->query($query)->result_array();
        $headerColumns = implode(',', array_keys($resultData[0]));
        $filename = 'warehouses-'.time().'.xlsx';
        $title = 'Warehouse List';
        $sheetTitle = 'Warehouse List';
        $this->export( $filename, $title, $sheetTitle, $headerColumns,  $resultData );
    }

}