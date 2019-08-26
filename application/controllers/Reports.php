<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		if($this->input->is_ajax_request()){
			$columns = array(
				'plants.name',
				'equipments.name',
				'tag_no',
				'equipment_tags.equipment_use',
				'activity',
				'note',
				'start_date',
				'end_date',
				'equipment_notes.status',
				'users.first_name',
				'created_at'
			);
			$request = $_REQUEST;
			$where = " WHERE 1=1 AND `users`.`reporting_to` = ".USER_ID;
			$sql = "SELECT 
						`equipment_notes`.*,
						`equipment_tags`.`equipment_use`,
						`equipment_tags`.`tag_no`,
						`plants`.`name` AS `plant_name`,
						`equipments`.`name` AS `equipment_name`,
						`users`.`first_name`,
						(
							CASE 
							WHEN `equipment_notes`.`status` = '0' THEN 'Running' ELSE 'Completed'
							END
						) AS `equipment_maintenance_status`
					FROM `equipment_notes`
					LEFT JOIN `equipment_tags` ON `equipment_tags`.`id` = `equipment_notes`.`tag_id`
					LEFT JOIN `plants` ON `plants`.`id` = `equipment_tags`.`plant_id`
					LEFT JOIN `equipments` ON `equipments`.`id` = `equipment_tags`.`equipment_id`
					LEFT JOIN `users` ON `users`.`id` = `equipment_notes`.`created_by`
					";
			$rs = $this->db->query($sql);
			$records_total = $this->db->affected_rows();
			$records_filtered = $records_total;
			
			if( !empty($request['search']['value']) ) {

				$search_value = $this->db->escape_like_str($request['search']['value']);
				$where .= " AND ( ";
				if(is_array($columns)){
					array_pop($columns);	// remove last index from the array
					$intCount = COUNT($columns);
					$intIteration = 1;
					foreach($columns as $col):
						if($intIteration == $intCount){
							$where .="$col LIKE '%".$search_value."%' ";
						}else{
							$where .="$col LIKE '%".$search_value."%' OR ";
						}
						$intIteration += 1;
					endforeach;
				}
	            $where .= " )";
			}
			$sql .= $where;
			if( count($request['order']) > 0 ) {
				
				$temp = array();
				
				foreach($request['order'] as $order){
					$temp[]= "".$columns[$order['column']]." ".$order['dir'];
				}

				$sql .= " ORDER BY ";
				$sql .= implode(",",$temp);
			}
			
			$c = $this->db->query($sql);
			$records_filtered = $this->db->affected_rows();
			if($request['length'] != -1){				
				$sql .= " LIMIT ".$request['start']." ,".$request['length'];
			}

			$rs = $this->db->query($sql);
			$data =  $rs->result_array();

			$json_data = array(
				"draw"            => intval( $request['draw'] ),
				"recordsTotal"    => intval( $records_total ),
				"recordsFiltered" => intval( $records_filtered ),
				"data"            => $data,
			);
			echo json_encode($json_data);die;
		}
		$this->data['page_title'] = "Maintenance Report";
 		$this->load_content('reports/maintenance_list', $this->data);
	}

	public function routine_activity(){
		if($this->input->is_ajax_request()){
			$columns = array(
				'plants.name',
				'equipments.name',
				'tag_no',
				'equipment_tags.equipment_use',
				'comment',
				'users.first_name',
				'created_at'
			);
			$request = $_REQUEST;
			$where = " WHERE 1=1 AND `users`.`reporting_to` = ".USER_ID;
			$sql = "SELECT 
						`routine_activity`.*,
						`equipment_tags`.`equipment_use`,
						`equipment_tags`.`tag_no`,
						`plants`.`name` AS `plant_name`,
						`equipments`.`name` AS `equipment_name`,
						`users`.`first_name`
					FROM `routine_activity`
					LEFT JOIN `equipment_tags` ON `equipment_tags`.`id` = `routine_activity`.`tag_id`
					LEFT JOIN `plants` ON `plants`.`id` = `equipment_tags`.`plant_id`
					LEFT JOIN `equipments` ON `equipments`.`id` = `equipment_tags`.`equipment_id`
					LEFT JOIN `users` ON `users`.`id` = `routine_activity`.`created_by`
					";
			$rs = $this->db->query($sql);
			$records_total = $this->db->affected_rows();
			$records_filtered = $records_total;
			
			if( !empty($request['search']['value']) ) {

				$search_value = $this->db->escape_like_str($request['search']['value']);
				$where .= " AND ( ";
				if(is_array($columns)){
					array_pop($columns);	// remove last index from the array
					$intCount = COUNT($columns);
					$intIteration = 1;
					foreach($columns as $col):
						if($intIteration == $intCount){
							$where .="$col LIKE '%".$search_value."%' ";
						}else{
							$where .="$col LIKE '%".$search_value."%' OR ";
						}
						$intIteration += 1;
					endforeach;
				}
	            $where .= " )";
			}
			$sql .= $where;
			if( count($request['order']) > 0 ) {
				
				$temp = array();
				
				foreach($request['order'] as $order){
					$temp[]= "".$columns[$order['column']]." ".$order['dir'];
				}

				$sql .= " ORDER BY ";
				$sql .= implode(",",$temp);
			}
			
			$c = $this->db->query($sql);
			$records_filtered = $this->db->affected_rows();
			if($request['length'] != -1){				
				$sql .= " LIMIT ".$request['start']." ,".$request['length'];
			}

			$rs = $this->db->query($sql);
			$data =  $rs->result_array();

			$json_data = array(
				"draw"            => intval( $request['draw'] ),
				"recordsTotal"    => intval( $records_total ),
				"recordsFiltered" => intval( $records_filtered ),
				"data"            => $data,
			);
			echo json_encode($json_data);die;
		}
		$this->data['page_title'] = "Routine Activity";
 		$this->load_content('reports/activity_list', $this->data);	
	}

	public function maintenance_export(){
		$query = "SELECT 
					`plants`.`name` AS `plant_name`,
					`equipments`.`name` AS `equipment_name`,
					`equipment_tags`.`tag_no`,
					`equipment_tags`.`equipment_use`,
					`equipment_notes`.`activity`,
					`equipment_notes`.`note`,
					`equipment_notes`.`start_date`,
					`equipment_notes`.`end_date`,
					(
						CASE 
						WHEN `equipment_notes`.`status` = '0' THEN 'Running' ELSE 'Completed'
						END
					) AS `maintenance_status`,
					`users`.`first_name` AS `created_by`,
					`equipment_notes`.`created_at`
				FROM `equipment_notes`
				LEFT JOIN `equipment_tags` ON `equipment_tags`.`id` = `equipment_notes`.`tag_id`
				LEFT JOIN `plants` ON `plants`.`id` = `equipment_tags`.`plant_id`
				LEFT JOIN `equipments` ON `equipments`.`id` = `equipment_tags`.`equipment_id`
				LEFT JOIN `users` ON `users`.`id` = `equipment_notes`.`created_by`
				WHERE `users`.`reporting_to` = ".USER_ID;
		$resultData = $this->db->query($query)->result_array();
		$headerColumns = implode(',', array_keys($resultData[0]));
		$filename = 'maintenance_report-'.time().'.xlsx';
		$title = 'Maintenance List';
		$sheetTitle = 'Maintenance List';
		$this->export( $filename, $title, $sheetTitle, $headerColumns,  $resultData );
	}

	public function activity_export(){
		$query = "SELECT 
					`plants`.`name` AS `plant_name`,
					`equipments`.`name` AS `equipment_name`,
					`equipment_tags`.`tag_no`,
					`equipment_tags`.`equipment_use`,
					`routine_activity`.`comment`,
					`users`.`first_name` AS `created_by`,
					`routine_activity`.`created_at`
				FROM `routine_activity`
				LEFT JOIN `equipment_tags` ON `equipment_tags`.`id` = `routine_activity`.`tag_id`
				LEFT JOIN `plants` ON `plants`.`id` = `equipment_tags`.`plant_id`
				LEFT JOIN `equipments` ON `equipments`.`id` = `equipment_tags`.`equipment_id`
				LEFT JOIN `users` ON `users`.`id` = `routine_activity`.`created_by`
				WHERE `users`.`reporting_to` = ".USER_ID;
		$resultData = $this->db->query($query)->result_array();
		$headerColumns = implode(',', array_keys($resultData[0]));
		$filename = 'activity_report-'.time().'.xlsx';
		$title = 'Activity List';
		$sheetTitle = 'Activity List';
		$this->export( $filename, $title, $sheetTitle, $headerColumns,  $resultData );
	}
}