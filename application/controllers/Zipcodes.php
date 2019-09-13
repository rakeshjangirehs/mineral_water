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
                'link'
			);

			$query = $this->model->common_select('zip_codes.*')->common_get('zip_codes');
			echo $this->model->common_datatable($colsArr, $query);die;
		}
		$this->data['page_title'] = 'Zipcodes';
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
					'zip_code'			=> $this->input->post('zipcode')
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
 }