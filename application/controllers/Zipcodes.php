<?php  
 defined('BASEPATH') OR exit('No direct script access allowed'); 
 /** Developer: Milan Soni 
  * Created Date: 2019-08-26 16:35:48 
  * Created By : CLI 
 */ 
 
 class Zipcodes extends MY_Controller {
 
 	 public function __construct() {
 	 	 parent::__construct();
 	 }

 	 public function index(){
 	 	if($this->input->is_ajax_request()){
			$colsArr = array(
				'zip_code',
				'cities.name',
				'states.name',
                'link'
			);

			$query = $this->model
							->common_select('zip_codes.*,cities.name as city_name,states.name as state_name')
							->common_join('`cities`','`cities`.`id` = `zip_codes`.`city_id`','LEFT')
							->common_join('`states`','`states`.`id` = `zip_codes`.`state_id`','LEFT')
							->common_get('zip_codes');
			echo $this->model->common_datatable($colsArr, $query);die;
		}
		$this->data['page_title'] = 'Zipcodes';
		$this->data['states'] = $this->model->get('states',"0","is_deleted",true);		
		$this->load_content('zipcode/zipcode_list', $this->data);
 	 }

 	public function save(){
		 
		$response = array(
			'error' =>true
		);
		if($this->input->is_ajax_request()){
			if($this->input->server("REQUEST_METHOD") == "POST"){
				$id = $this->input->post('zipcode_id');
				$data = array(
					'zip_code'			=> ($this->input->post('zipcode')) ? $this->input->post('zipcode') : null,
					'area'			=> ($this->input->post('area')) ? $this->input->post('area') : null,
					'state_id'			=> ($this->input->post('state_id')) ? $this->input->post('state_id') : null,
					'city_id'			=> ($this->input->post('city_id')) ? $this->input->post('city_id') : null,
				);
				if($this->model->insert_update($data, 'zip_codes', $id, 'id')){
					$response['error'] = false;
					$type = 'message';
					$msg = '';
					if($id){
						$msg = 'Zipcode updated successfully.';
					}else{
						$msg = 'Zipcode inserted successfully.';
					}
					$response['message'] = $msg;
				}
			}else{
				$msg = 'Some error occured. Try again later.';
				$type = 'error';
				$response['message'] = $msg;
			}
		}else{
			$msg = 'No direct script access allowed.';
			$type = 'error';
			$response['message'] = $msg;
		}
		$this->flash($type, $msg);
		echo json_encode($response);die;
	}

	public function zip_export(){
		$query = $this->model->common_select('zip_codes.zip_code')->common_get('zip_codes');

		$resultData = $this->db->query($query)->result_array();
		$headerColumns = implode(',', array_keys($resultData[0]));
		$filename = 'zipcodes-'.time().'.xlsx';
		$title = 'Zipcode List';
		$sheetTitle = 'Zipcode List';
		$this->export( $filename, $title, $sheetTitle, $headerColumns,  $resultData );
	}

	public function get_cities(){
        // sleep(5);
        $state_id = $this->input->post('state_id');
        $data = $this->db->get_where("cities",['state_id'=>$state_id,'is_deleted'=>0,'status'=>'Active'])->result_array();

        echo json_encode($data);
	}
	
	public function get_zip_codes(){
        // sleep(5);
        
		$where  = [];

		if($state_id = $this->input->post('state_id')){
			$where["state_id"] = $state_id;
		}

		if($city_id = $this->input->post('city_id')){
			$where["city_id"] = $city_id;
		}

        $data = array_column($this->db->get_where("zip_codes",$where)->result_array(),"zip_code","id");

        echo json_encode($data);
    }
 }