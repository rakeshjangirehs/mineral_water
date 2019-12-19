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
    public function insert_update($data, $new_zip_code = [],$zipcode_group_id = NULL){
        
        $old_zip_codes = ($zipcode_group_id) ? array_column($this->model->get("group_to_zip_code",$zipcode_group_id,"zip_code_group_id",true),'zip_code_id') : [];
        
        $insertable_zip_codes = array_diff($new_zip_code,$old_zip_codes);
        $removable_zip_codes_basic = array_diff($old_zip_codes,$new_zip_code);        

        $this->db->trans_start();
        
        $cant_remove_msg="";
        if($removable_zip_codes_basic){
           
            $removable_zip_codes_str = implode(",",$removable_zip_codes_basic);

            $query = "SELECT
                            group_to_zip_code.zip_code_id
                            ,zip_codes.zip_code
                            #,COUNT(group_to_zip_code.id)
                        FROM group_to_zip_code
                        LEFT JOIN zip_codes ON zip_codes.id = group_to_zip_code.zip_code_id
                        WHERE group_to_zip_code.zip_code_id IN({$removable_zip_codes_str})
                        GROUP BY zip_code_id
                        HAVING COUNT(group_to_zip_code.id) > 1";

            $removables_array = $this->db->query($query)->result_array();

            // echo "<pre>".$query;
            // echo "<pre>";print_r($removables_array);

            $removable_zip_codes = array_column($removables_array,'zip_code_id');
            
            $unremovable_zip_codes = array_diff($removable_zip_codes_basic,$removable_zip_codes);

            if($unremovable_zip_codes){
                $unremovable_zip_codes_str = implode(",",$unremovable_zip_codes);
                $qry = "SELECT
                            GROUP_CONCAT(zip_codes.zip_code) AS unremovable
                        FROM group_to_zip_code
                        LEFT JOIN zip_codes ON zip_codes.id = group_to_zip_code.zip_code_id
                        WHERE group_to_zip_code.zip_code_id IN({$unremovable_zip_codes_str})";
                
                $cant_remove_msg = "<br/>Following Zip Codes can't be removed : ".$this->db->query($qry)->row_array()['unremovable'];
            }
        }else{
            $removable_zip_codes = [];
        }
        
        // echo "<pre>";print_r($removable_zip_codes);die;

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
                if($zip_code) {
                    $insertable_zip_codes_arr[] = array(
                        'zip_code_group_id' => $zipcode_group_id,
                        'zip_code_id' => $zip_code,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => USER_ID,
                    );
                }
            }
            if($insertable_zip_codes_arr) {
                $this->db->insert_batch("group_to_zip_code", $insertable_zip_codes_arr);
            }
        }

        $this->db->trans_complete();
        if($this->db->trans_status()){
            return [
                'status'            =>  true,
                'zipcode_group_id'  =>  $zipcode_group_id,
                'message'           =>  $cant_remove_msg,
            ];
        }else{
            return [
                'status'            =>  false,
                'zipcode_group_id'  =>  null,
                'message'           =>  null,
            ];
        }
    }

}