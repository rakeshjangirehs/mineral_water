<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Zipcodegroup extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        // Load the database library
        $this->load->database();
        
        $this->userTbl = 'group_to_zip_code';
    }
    
    /*
     * Insert user data
     */
    public function insert_update($group_name, $new_zip_code = [],$zipcode_group_id = NULL){

        $old_zip_codes = ($zipcode_group_id) ? array_column($this->model->get("group_to_zip_code",$zipcode_group_id,"zip_code_group_id",true),'zip_code_id') : [];
        $removable_zip_codes = array_diff($old_zip_codes,$new_zip_code);
        $insertable_zip_codes = array_diff($new_zip_code,$old_zip_codes);
        $data = array('group_name' => $group_name);

        $this->db->trans_start();

        if($zipcode_group_id){
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['updated_by'] = USER_ID;

            $this->db->where("id", $zipcode_group_id);
            $this->db->update("zip_code_groups", $data);

        }else{
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = USER_ID;
            $this->db->insert("zip_code_groups", $data);
            $zipcode_group_id = $this->db->insert_id();
        }

        if($removable_zip_codes){
            $removable_zip_codes_str = implode(",",$removable_zip_codes);
            $delete_query = "DELETE FROM `group_to_zip_code` WHERE `group_to_zip_code`.`zip_code_id` IN ({$removable_zip_codes_str}) AND `group_to_zip_code`.`zip_code_group_id` = {$zipcode_group_id}";
            $this->db->query($delete_query);
        }

        if($insertable_zip_codes){
            $insertable_zip_codes_arr = [];
            foreach($insertable_zip_codes as $k=>$zip_code){
                $insertable_zip_codes_arr[] = array(
                    'zip_code_group_id' => $zipcode_group_id,
                    'zip_code_id'  => $zip_code,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => USER_ID,
                );
            }
            $this->db->insert_batch("group_to_zip_code",$insertable_zip_codes_arr);
        }

        $this->db->trans_complete();
        if($this->db->trans_status()){
            return $zipcode_group_id;
        }else{
            return false;
        }
    }

}