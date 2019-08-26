<?php  
 defined('BASEPATH') OR exit('No direct script access allowed'); 
 /** Developer: Milan Soni 
  * Created Date: 2019-08-02 11:10:30 
  * Created By : CLI 
 */ 
 
 class Equipment_tags extends MY_Controller {
 	
 	public function __construct() {
 		parent::__construct();
 	}

 	public function index(){
									
		if($this->input->is_ajax_request()){
			$colsArr = array(
				'`equipments`.`name`',
				'`plants`.`name`',
				'`tag_no`',
				'`equipment_use`',
				'action'
			);

			$query = $this
						->model
						->common_select('equipment_tags.*, equipments.name AS `equipment_name`, `plants`.`name` AS 	`plant_name`')
						->common_join('equipments','equipments.id = equipment_tags.equipment_id','LEFT')
						->common_join('plants','plants.id = equipment_tags.plant_id','LEFT')
						->common_get('equipment_tags');
			echo $this->model->common_datatable($colsArr, $query, "equipment_tags.status = 1");die;
		} 		

 		$this->data['page_title'] = "Equipment Tag";
 		$this->load_content('equipment_tag/tag_list', $this->data);
 	}

 	public function add_update( $id = NULL ){
 		$method = 'Add';
 		$msg = '';
 		$equipmentArr = array(
 			'equipment_id'		=> '',
 			'plant_id'			=> '',
 			'tag_no'			=> '',
 			'equipment_use'		=> '',
 			'qr'				=> '',
 		);
 		if($id){
 			$method = 'Update';
 			$equipmentArr = $this->model->get('equipment_tags', $id, 'id');
 		}

 		// form validation
 		$this->load->helper('form');
 		$this->load->library('form_validation');
 		$this->form_validation->set_rules('equipment_id', 'Equipment', 'trim|required');
 		$this->form_validation->set_rules('plant_id', 'Plant', 'trim|required|callback_check_duplication');
 		$this->form_validation->set_rules('tag_no', 'Tag No', 'trim|required');
 		$this->form_validation->set_rules('equipment_use', 'Use of equipment', 'trim');

 		if($this->form_validation->run() == TRUE){
 			$tagNo = $this->input->post('tag_no');

 			$dataArr = array(
 				'equipment_id'			=> $this->input->post('equipment_id'),
 				'plant_id'				=> $this->input->post('plant_id'),
 				'tag_no'				=> $this->input->post('tag_no'),
 				'equipment_use'			=> $this->input->post('equipment_use'),
 			);

 			$fileName = $dataArr['equipment_id']."-".$dataArr['plant_id']."-".$dataArr['tag_no'];
 			$file = $this->libQr($dataArr, $fileName);

 			$dataArr['qr'] = $file;

 			if($id = $this->model->insert_update($dataArr, 'equipment_tags', $id, 'id')){
				$type = 'message';
				if($id){
					$msg = 'Equipment Tag updated successfully.';
				}else{
					$msg = 'Equipment Tag inserted successfully.';
				}
			}else{
				$type = 'error';
				$msg = 'Some error occured. Try again later.';
			}
			$this->flash($type, $msg);
			redirect('equipment_tags/index', 'location');
 		}

 		$this->data['equipment_tags'] = $equipmentArr;
 		$this->data['id'] = $id;
 		$this->data['equipments'] = $this->model->get('equipments');
 		$this->data['plants'] = $this->model->get('plants');

 		// form helper elements start
		$this->data['tag_no'] = array(
			'name'		=>'tag_no',
			'id'		=>'tag_no',
			'type'		=>'text',
			'class'		=>'form-control',
			'value'		=>(isset($_POST['tag_no'])) ? set_value('tag_no') : $equipmentArr['tag_no']
		);

		$this->data['equipment_use'] = array(
			'name'          => 'equipment_use',
			'value'         => (isset($_POST['equipment_use'])) ? set_value('equipment_use') : $equipmentArr['equipment_use'],
			'class'         => 'form-control',
			'rows'        	=> '3',
			'cols'        	=> '10',
		);
		// form helper elements end

 		$this->data['page_title'] = $method.' Equipment Tags';
 		$this->load_content('equipment_tag/add_update_tag', $this->data);
 	}

 	public function eq_tag_export(){
		$query = $this
						->model
						->common_select('equipment_tags.tag_no, equipments.name AS `equipment_name`, equipment_use,`plants`.`name` AS 	`plant_name`')
						->common_join('equipments','equipments.id = equipment_tags.equipment_id','LEFT')
						->common_join('plants','plants.id = equipment_tags.plant_id','LEFT')
						->common_get('equipment_tags');

		$resultData = $this->db->query($query)->result_array();
		$headerColumns = implode(',', array_keys($resultData[0]));
		$filename = 'equipment_tag-'.time().'.xlsx';
		$title = 'Equipment Tag List';
		$sheetTitle = 'Equipment Tag List';
		$this->export( $filename, $title, $sheetTitle, $headerColumns,  $resultData );
	}

	public function generate_tag_qr(){

		$data = json_encode($_POST);

		// check equipment already exist or not
		$plantId = $this->db->get_where('plants', array('name'=>$_POST['plant']))->row_array()['id'];
		$equipmentId = $this->db->get_where('equipments', array('name'=>$_POST['equipment']))->row_array()['id'];

		$arData = array(
			'plant_id'		=>$plantId,
			'equipment_id'	=>$equipmentId,
			'tag_no'		=>$_POST['tag_no'],
		);

		$res = $this->db->get_where("equipment_tags", $arData);
		$result = true;
		if($res->num_rows() > 0){
			$result = false;
		}

		if($result){
			// tagno_plantid_equipment_id is the file name
			$fileName = $arData['tag_no']."_".$arData['plant_id']."_".$arData['equipment_id'];
			echo base64_encode($this->libQr($data, $fileName));
		}else{

		}
	}

	public function check_duplication(){
		$id = $this->uri->segment(3);
		$where = " WHERE 1=1";
		if($id){
			$where .= " AND `id` NOT IN('{$id}')";
		}
		$plantId = $this->input->post('plant_id');
		$tagNo = $this->input->post('tag_no');

		if(!empty($plantId) && !empty($tagNo)){
			$where .= " AND `plant_id` = '{$plantId}'";
			$where .= " AND `tag_no` = '{$tagNo}'";
			$checkDuplicate = $this->db->query("SELECT 
								*
							FROM `equipment_tags`
							$where
							")->num_rows();
			if($checkDuplicate > 0){
				$this->form_validation->set_message('check_duplication','Entered plant and tag_no already exist in the system.');
				return false;
			}
		}
		return true;
	}

	public function create_pdf()
    {
        $this->data['qr_data'] = $this->db->query("SELECT * FROM `equipment_tags` WHERE `qr` IS NOT NULL")->result_array();
        $this->load->view('equipment_tag/print', $this->data);
    }
 }