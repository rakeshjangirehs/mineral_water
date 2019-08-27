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

    public function insert_update_client_contact($data,$client_id,$contact_id=null){

        $this->db->trans_start();

        if($data['is_primary']=='Yes'){
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['updated_by'] = USER_ID;

            $this->db->where("client_id", $client_id);
            $this->db->update("client_contacts", array('is_primary'=>'No'));
        }

        if($contact_id){
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['updated_by'] = USER_ID;

            $this->db->where("id", $contact_id);
            $this->db->update("client_contacts", $data);

        }else{
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = USER_ID;
            $this->db->insert("client_contacts", $data);
            $contact_id = $this->db->insert_id();
        }

        $this->db->trans_complete();
        if($this->db->trans_status()){
            return $contact_id;
        }else{
            return false;
        }
    }

    public function get_client($id){
        // echo "<pre>"; var_dump($id);die;

        return $this->db->select('clients.*,`zip_codes`.`zip_code`')
                        ->from("clients")
                        ->join("zip_codes", "zip_codes.id = clients.zip_code_id", "left")
                        ->where("clients.id", $id)
                        ->get()
                        ->row_array();
    }

    public function check_exist( $whereKey, $whereVal, $id = NULL ){
        if($id){
            $res = $this->db->select("*")
                            ->from("clients")
                            ->where("$whereKey", $whereVal)
                            ->where_not_in("clients.id", array($id))
                            ->get();
        }else{
            $res = $this->db->select("*")
                            ->from("clients")
                            ->where("$whereKey", $whereVal)
                            ->get();
        }
        return $res->row_array();
    }

    public function check_contact_exist( $whereKey, $whereVal, $id = NULL ){
        if($id){
            $res = $this->db->select("*")
                ->from("client_contacts")
                ->where("$whereKey", $whereVal)
                ->where_not_in("client_contacts.id", array($id))
                ->get();
        }else{
            $res = $this->db->select("*")
                ->from("client_contacts")
                ->where("$whereKey", $whereVal)
                ->get();
        }
        return $res->row_array();
    }
}