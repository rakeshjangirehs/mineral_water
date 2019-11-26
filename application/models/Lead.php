<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lead extends MY_Model {

    public function __construct() {
        parent::__construct();
        
        // Load the database library
        $this->load->database();
        
        $this->userTbl = 'leads';
    }
    
    /*
     * Insert user data
     */
    public function add_update($data, $zipcode_group_id = NULL){

        $this->db->trans_start();

        if($zipcode_group_id){
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['updated_by'] = USER_ID;

            $this->db->where("id", $zipcode_group_id);
            $this->db->update("leads", $data);

        }else{
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = USER_ID;
            $this->db->insert("leads", $data);
            $zipcode_group_id = $this->db->insert_id();
        }

        $this->db->trans_complete();
        if($this->db->trans_status()){
            return $zipcode_group_id;
        }else{
            return false;
        }
    }

}