<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Clientcategory_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        // Load the database library
        $this->load->database();
        
        $this->userTbl = 'client_categories';
    }
    
    /*
     * Insert user data
     */
    public function insert_update($data, $vehicle_id = NULL){

        $this->db->trans_start();

        if($vehicle_id){
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['updated_by'] = USER_ID;

            $this->db->where("id", $vehicle_id);
            $this->db->update("client_categories", $data);

        }else{
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = USER_ID;
            $this->db->insert("client_categories", $data);
            $vehicle_id = $this->db->insert_id();
        }

        $this->db->trans_complete();
        if($this->db->trans_status()){
            return $vehicle_id;
        }else{
            return false;
        }
    }

}