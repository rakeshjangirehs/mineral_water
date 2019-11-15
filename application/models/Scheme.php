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
    public function insert_update($data,$scheme_products=null,$scheme_id=NULL){
        
        $this->db->trans_start();
        if($scheme_id){
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['updated_by'] = USER_ID;

            $this->db->where("id", $scheme_id);
            $this->db->update("schemes", $data);

            //Delete Old Data only when update old scheme.
            $this->db->delete("scheme_products",["scheme_id"=>$scheme_id]);

        }else{
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = USER_ID;
            $this->db->insert("schemes", $data);
            $scheme_id = $this->db->insert_id();
        }

        if($scheme_products){

            $products_data = [];

            foreach($scheme_products as $k=>$product){
                $products_data[] = array(
                    'scheme_id'	=>	$scheme_id,
                    'product_id'=>	$product['product_id'],
                    'quantity'	=>	$product['qty'],
                    'created_at'   =>  date('Y-m-d H:i:s'),
                    'created_by'    =>  USER_ID
                );
            }

            $this->db->insert_batch("scheme_products",$products_data);
        }

        $this->db->trans_complete();
        
        if($this->db->trans_status()){
            return $scheme_id;
        }else{
            return false;
        }
    }

}