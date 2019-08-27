<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function add_update($product = array(), $product_image = array(), $id = NULL){
    	$this->db->trans_start();
    	if($id){
    		// update
    	}else{
    		// insert
    		$product['created_by'] = USER_ID;
    		$product['created_at'] = date('Y-m-d H:i:s');

    		$this->db->insert('products', $product);
    		$id = $this->db->insert_id();

    		if(!empty($product_image)){
    			$product_image['product_id'] = $id;
    			$product_image['created_by'] = USER_ID;

    			$this->db->insert('product_images', $product_image);
    		}
    	}
    	$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
	        return false;
		}
		return $id;
    }
}