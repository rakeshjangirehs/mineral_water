<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Activity extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        // Load the database library
        $this->load->database();
    }

	public function get_activity( $tag_no = NULL, $user_id = NULL ){
		if($tag_no){
			$this->db->where("equipment_tags.tag_no", $tag_no);
		}

		if($user_id){
			if(is_array($user_id)){
				$this->db->where_in("routine_activity.created_by", $user_id);
			}else{
				$this->db->where("routine_activity.created_by", $user_id);
			}
		}

		return $this->db->select("routine_activity.*, 
							equipment_tags.tag_no, 
							equipment_tags.equipment_use, 
							equipments.name AS `equipment_name`, 
							plants.name as plant_name")
                    ->from("routine_activity")
                    ->join("equipment_tags", "equipment_tags.id = routine_activity.tag_id","LEFT")
                    ->join("equipments", "equipments.id = equipment_tags.equipment_id", "LEFT")
                    ->join("plants", "plants.id = equipment_tags.plant_id", "LEFT")
                    ->get()
                    ->result_array();
	}

	public function get_maintenance_history($user_id, $tag_no){
		return $this->db->query("SELECT
									`equipment_notes`.*,
									`equipments`.`name` AS `equipment_name`,
									`plants`.`name` AS `plant_name`,
									(
										CASE
										WHEN `equipment_notes`.`status` = 0 THEN 'Pending' ELSE 'Completed' 
										END
									) AS `equipment_status`
								FROM `equipment_notes`
								LEFT JOIN `equipment_tags` ON `equipment_tags`.`id` = `equipment_notes`.`tag_id`
								LEFT JOIN `equipments` ON `equipments`.`id` = `equipment_tags`.`equipment_id`
								LEFT JOIN `plants` ON `plants`.`id` = `equipment_tags`.`plant_id`
								WHERE `equipment_tags`.`tag_no` = '{$tag_no}'
								AND `equipment_notes`.`created_by` = $user_id
								ORDER BY `equipment_notes`.`id` DESC
								")->result_array();
	}
}