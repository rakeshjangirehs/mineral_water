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
    public function insert_update($data,$client_id = NULL,$salesmen_ids=NULL,$create_by=NULL,$visit_note=NULL){
        
        $this->db->trans_start();
        if($client_id){
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['updated_by'] = ($create_by) ? $create_by : USER_ID;

            $this->db->where("id", $client_id);
            $this->db->update("clients", $data);

        }else{
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = ($create_by) ? $create_by : USER_ID;
            $this->db->insert("clients", $data);
            $client_id = $this->db->insert_id();
        }

        if($salesmen_ids !== NULL){
            $this->db->delete("client_selesmans",array("client_id"=> $client_id));
            $insert_array = array();
            foreach($salesmen_ids as $salesman_id){
                $insert_array[] = array(
                    'client_id'     =>  $client_id,
                    'salesman_id'   =>  $salesman_id,
                    'created_at'    =>  date('Y-m-d H:i:s'),
                    'created_by'    =>  ($create_by) ? $create_by : USER_ID,
                );
            }
            if($insert_array){
                $this->db->insert_batch("client_selesmans",$insert_array);
            }
        }

        if(!empty($visit_note)){
            $visit_data = array(
                'visit_notes'=> $visit_note,
                'client_id' => $client_id,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => ($create_by) ? $create_by : USER_ID,
            );

            $this->db->insert("client_visits",$visit_data);
        }

        $this->db->trans_complete();
        if($this->db->trans_status()){
            return $client_id;
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

    public function get_client($where=null,$mode='multiple'){

        $db = ($where) ? $this->db->where($where) : $this->db;

        $db->select('clients.*,`zip_codes`.`zip_code`')
            ->from("clients")
            ->join("zip_codes", "zip_codes.id = clients.zip_code_id", "left");

        if($mode != 'multiple'){

            $client =  $db->get()->row_array();
            if($client){
                $client['salesmans'] = array_column($this->db
                    ->select("salesman_id")
                    ->where("client_selesmans.client_id = {$client['id']}")
                    ->get("client_selesmans")
                    ->result_array(),'salesman_id');
            }
            return $client;
        }else{
            $clients =  $db->get()->result_array();
            if($clients){
                foreach($clients as $k=>$client){
                    $clients[$k]['salesmans'] = $this->db
                        ->where("client_selesmans.client_id = {$client['id']}")
                        ->get("client_selesmans")
                        ->result_array();
                }
            }
            return $clients;
        }
    }

    public function get_client_by_id($id){
        $where = "clients.id = {$id}";
        return $this->get_client($where,'single');
    }

    public function get_client_full($id){
        $sql = "SELECT 
                    `clients`.*,
                    SUM(`payable_amount`) AS `payment_due`,
                    CAST((`clients`.`credit_limit`-(SUM(`payable_amount`))) AS DECIMAL(14,2)) AS `available_credit`
                FROM `clients`
                LEFT JOIN `orders` ON `orders`.`client_id` = `clients`.`id`
                LEFT JOIN `payments` ON `payments`.`order_id` = `orders`.`id`
                WHERE `clients`.`id` = $id
                AND ( `payments`.`status` IS NULL OR `payments`.`status` = 'PARTIAL' OR `payments`.`status` = 'PENDING')
                GROUP BY `clients`.`id`
                ";

        return $this->db->query($sql)->row_array();
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