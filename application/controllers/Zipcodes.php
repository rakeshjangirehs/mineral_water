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
				'area',
				'city_name',
				'state_name',
				'zip_code_groups',
                'link'
			);

			$query = $this->model
							->common_select('zip_codes.*,cities.name as city_name,states.name as state_name,GROUP_CONCAT(zip_code_groups.group_name) AS zip_code_groups, IFNULL(GROUP_CONCAT(zip_code_groups.id),"") AS zip_code_group_ids')
							->common_join('`cities`','`cities`.`id` = `zip_codes`.`city_id`','LEFT')
							->common_join('`states`','`states`.`id` = `zip_codes`.`state_id`','LEFT')
							->common_join('`group_to_zip_code`','`group_to_zip_code`.`zip_code_id` = `zip_codes`.`id`','LEFT')
							->common_join('`zip_code_groups`','`zip_code_groups`.`id` = `group_to_zip_code`.`zip_code_group_id`','LEFT')
							->common_group_by('zip_codes.id')
							->common_get('zip_codes');
			echo $this->model->common_datatable($colsArr, $query,"","",TRUE);die;
		}
		$this->data['page_title'] = 'Zipcodes';
		$this->data['states'] = $this->model->get('states',"0","is_deleted",true);
		$this->data['zip_code_groups'] = array_column($this->model->get('zip_code_groups'),"group_name","id");
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

				$new_zip_code_group = ($this->input->post('zip_code_group')) ? $this->input->post('zip_code_group') : [];
				$previous_zip_code_groups = [];
				if($id){
					$previous_zip_code_groups = array_column($this->db->where("zip_code_id",$id)->get("group_to_zip_code")->result_array(),'zip_code_group_id');
				}

				$removable_zip_code_groups = array_diff($previous_zip_code_groups,$new_zip_code_group);
				$insertable_zip_code_groups = array_diff($new_zip_code_group,$previous_zip_code_groups);

				$this->db->trans_start();
				$insert_id = $this->model->insert_update($data, 'zip_codes', $id, 'id');				
			
				if($removable_zip_code_groups && $id){
					$removable_zip_code_groups_str = implode(",",$removable_zip_code_groups);
					$delete_query = "DELETE FROM `group_to_zip_code` WHERE `group_to_zip_code`.`zip_code_group_id` IN ({$removable_zip_code_groups_str}) AND `group_to_zip_code`.`zip_code_id` = {$id}";
					$this->db->query($delete_query);
				}

				if($insertable_zip_code_groups){
					$insertable_zip_code_groups_arr = [];
					foreach($insertable_zip_code_groups as $k=>$zip_code_group){
						if($zip_code_group){
							$insertable_zip_code_groups_arr[] = array(
								'zip_code_group_id'  => $zip_code_group,
								'zip_code_id'  => $insert_id,
								'created_at' => date('Y-m-d H:i:s'),
								'created_by' => USER_ID,
							);
						}
					}
					if($insertable_zip_code_groups_arr){
						$this->db->insert_batch("group_to_zip_code",$insertable_zip_code_groups_arr);
					}
				}

				$this->db->trans_complete();
				if($this->db->trans_status()){
					$response['error'] = false;
					$type = 'message';
					$msg = '';
					if($id){
						$msg = 'Zipcode updated successfully.';
					}else{
						$msg = 'Zipcode inserted successfully.';
					}
					$response['message'] = $msg;
				}else{
					$msg = 'Some error occured. Try again later.';
					$type = 'error';
					$response['message'] = $msg;
				}
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
		
		$query = $this->model
							->common_select("zip_codes.zip_code,zip_codes.area,
											cities.name as city_name,states.name as state_name")
							->common_join('`cities`','`cities`.`id` = `zip_codes`.`city_id`','LEFT')
							->common_join('`states`','`states`.`id` = `zip_codes`.`state_id`','LEFT')
							->common_get('zip_codes');

		$resultData = $this->db->query($query)->result_array();
		
		// echo "<pre>";print_r($resultData);die;

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