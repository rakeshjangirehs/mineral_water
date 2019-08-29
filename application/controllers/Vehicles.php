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
                'rules' => 'required'
            ),
            array(
                'field' => 'number',
                'label' => 'Vehicle Number',
                'rules' => 'required'
            ),
            array(
                'field' => 'capacity_in_ton',
                'label' => 'Vehicle Capacity',
                'rules' => 'required'
            ),
        );
	}

	public function index($vehicle_id=null){

	    $this->data['vehicle_id'] = $vehicle_id;

	    if($vehicle_id){
            $this->data['form_title'] = "Update Vehicle";
            $this->data['vehicle_details'] = $this->model->get("vehicle",$vehicle_id,"id");
//            echo "<pre>";print_r($this->data['vehicle_details']);die;
        }else{
            $this->data['form_title'] = "Add Vehicle";
            $this->data['vehicle_details'] = array('name'=>'','number'=>'','capacity_in_ton'=>'');
        }


		if($this->input->is_ajax_request()){
			$colsArr = array(
				'`vehicle`.`number`',
				'`vehicle`.`capacity_in_ton`',
				'action'
			);

            $query = $this
                ->model
                ->common_select('`vehicle`.*')
                ->common_get('`vehicle`');

			echo $this->model->common_datatable($colsArr, $query, "vehicle.status = 'Active'");die;
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

		$this->data['page_title'] = 'Vehilcles';
		$this->load_content('vehicle/vehicle_list', $this->data);
	}

}