<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property vehilcle $vehilcle
 */

class Vehicles extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('vehicle');

        //validation config
        $this->vehicle_validation_config = array(
            array(
                'field' => 'name',
                'label' => 'Vehicle Name',
                'rules' => 'required|max_length[200]'
            ),
            array(
                'field' => 'number',
                'label' => 'Vehicle Number',
                'rules' => 'required|alpha_numeric_spaces'
            ),
            array(
                'field' => 'capacity_in_ton',
                'label' => 'Vehicle Capacity',
                'rules' => 'required|numeric|less_than[100000]'
            ),
        );
	}

	public function index($vehicle_id=null){

	    $this->data['vehicle_id'] = $vehicle_id;

	    if($vehicle_id){
            $this->data['form_title'] = "Update Vehicle";
            $this->data['vehicle_details'] = $this->model->get("vehicle",$vehicle_id,"id");
        }else{
            $this->data['form_title'] = "Add Vehicle";
            $this->data['vehicle_details'] = array('name'=>'','number'=>'','capacity_in_ton'=>'');
        }


		if($this->input->is_ajax_request()){
			$colsArr = array(
                '`vehicle`.`name`',
				'`vehicle`.`number`',
				'`vehicle`.`capacity_in_ton`',
				'action'
			);

            $query = $this
                ->model
                ->common_select('`vehicle`.*')
                ->common_get('`vehicle`');

			echo $this->model->common_datatable($colsArr, $query, "vehicle.is_deleted = 0");die;
		}

        if($this->input->server("REQUEST_METHOD") == "POST"){

            $this->form_validation->set_rules($this->vehicle_validation_config);

            if ($this->form_validation->run() == TRUE) {

                $zip_code = $this->input->post('zip_code');
                $group_name = $this->input->post('group_name');
                $data = array(
                    'name' => ($this->input->post('name')) ? $this->input->post('name') : null,
                    'number' => ($this->input->post('number')) ? $this->input->post('number') : null,
                    'capacity_in_ton' => ($this->input->post('capacity_in_ton')) ? $this->input->post('capacity_in_ton') : null,
                );

                if ($this->vehicle->insert_update($data, $vehicle_id)) {
                    $msg = 'Vehicle created successfully.';
                    $type = 'success';
                    if ($vehicle_id) {
                        $msg = "Vehicle updated successfully.";
                        $this->flash($type, $msg);
                    } else {
                        $this->flash($type, $msg);
                    }
                } else {
                    $this->flash('error', 'Some error ocurred. Please try again later.');
                }
                redirect("vehicles/index/{$vehicle_id}", 'location');
            }
        }

		$this->data['page_title'] = 'Vehicles';
		$this->load_content('vehicle/vehicle_list', $this->data);
	}

    public function delete($vehicle_id){
        if($this->db->update("vehicle",array('is_deleted'=>1),array('id'=>$vehicle_id))){
            $this->flash("success","Vehicle Deleted Successfully");
        }else{
            $this->flash("error","Vehicle not Deleted");
        }
        redirect("vehicles/index");
    }

    public function vehicle_export(){

        $query = $this
            ->model
            ->common_select('`vehicle`.`name` AS `vehicle_name`,`vehicle`.`number`,`vehicle`.`capacity_in_ton` AS `capacity(KG)`')
            ->common_where('vehicle.is_deleted = 0')
            ->common_get('vehicle');

        $resultData = $this->db->query($query)->result_array();
        $headerColumns = implode(',', array_keys($resultData[0]));
        $filename = 'vehicles-'.time().'.xlsx';
        $title = 'Vehicle List';
        $sheetTitle = 'Vehicle List';
        $this->export( $filename, $title, $sheetTitle, $headerColumns,  $resultData );
    }

}