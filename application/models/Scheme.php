<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Scheme extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        // Load the database library
        $this->load->database();
        
        $this->userTbl = 'schemes';
    }
    
    /*
     * Insert user data
     */
    public function insert_update($data,$scheme_id=NULL){
        
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

            //Insert product price for each product in client_product_price table for newly created client.
            if($products=$this->db->get("products")->result_array()){
                $products = array_map(function($product) use($client_id,$create_by){
                    return array(
                        'product_id'    =>  $product['id'],
                        'sale_price'    =>  $product['sale_price'],
                        'client_id'     =>  $client_id,
                        'created_at'    =>  date('Y-m-d H:i:s'),
                        'created_by'    =>  ($create_by) ? $create_by : USER_ID,
                        'status'        =>  'Active'
                    );
                },$products);

                $this->db->insert_batch("client_product_price",$products);
            }
        }

        $this->db->trans_complete();
        
        if($this->db->trans_status()){
            return $client_id;
        }else{
            return false;
        }
    }

}