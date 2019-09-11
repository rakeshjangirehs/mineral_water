<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Client extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        // Load the database library
        $this->load->database();
        
        $this->userTbl = 'clients';
    }
    
    /*
     * Insert user data
     */
    public function insert_update($data,$user_id = NULL,$create_by=NULL,$visit_note=NULL){
        
        $this->db->trans_start();
        if($user_id){
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['updated_by'] = ($create_by) ? $create_by : USER_ID;

            $this->db->where("id", $user_id);
            $this->db->update("clients", $data);

        }else{
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = ($create_by) ? $create_by : USER_ID;
            $this->db->insert("clients", $data);
            $user_id = $this->db->insert_id();
        }

        if($visit_note){
            $visit_data = array(
                'visit_notes'=> $visit_note,
                'client_id' => $user_id,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => ($create_by) ? $create_by : USER_ID,
            );

            $this->db->insert("client_visits",$visit_data);
        }

        $this->db->trans_complete();
        if($this->db->trans_status()){
            return $user_id;
        }else{
            return false;
        }
    }

    public function insert_update_client_contact($data,$client_id,$contact_id=null,$create_by=NULL){

        $this->db->trans_start();

        if($data['is_primary']=='Yes'){
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['updated_by'] = ($create_by) ? $create_by : USER_ID;

            $this->db->where("client_id", $client_id);
            $this->db->update("client_contacts", array('is_primary'=>'No'));
        }

        if($contact_id){
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['updated_by'] = ($create_by) ? $create_by : USER_ID;

            $this->db->where("id", $contact_id);
            $this->db->update("client_contacts", $data);

        }else{
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = ($create_by) ? $create_by : USER_ID;
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

    public function get_client($id = NULL){
        $this->db->select('clients.*,`zip_codes`.`zip_code`')
                        ->from("clients")
                        ->join("zip_codes", "zip_codes.id = clients.zip_code_id", "left");
        if($id){            
            return $this->db->where("clients.id", $id)->get()->row_array();
        }else{
            return $this->db->where("clients.status", 'Active')->get()->result_array();
        }
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