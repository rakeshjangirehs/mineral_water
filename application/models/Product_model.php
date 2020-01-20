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
            $product['updated_by'] = USER_ID;
            $product['updated_at'] = date('Y-m-d H:i:s');
            $this->db->where('id', $id);
            $this->db->update('products', $product);

            if(!empty($product_image)){
                // delete product images
                $this->db->where('product_id', $id);
                $this->db->delete('product_images');
                
                $product_image['product_id'] = $id;
                $product_image['created_by'] = USER_ID;
                $product_image['created_at'] = date('Y-m-d H:i:s');

                $this->db->insert('product_images', $product_image);
            }
    	}else{
    		// insert
    		$product['created_by'] = USER_ID;
    		$product['created_at'] = date('Y-m-d H:i:s');

    		$this->db->insert('products', $product);
    		$id = $this->db->insert_id();

    		if(!empty($product_image)){
    			$product_image['product_id'] = $id;
    			$product_image['created_by'] = USER_ID;
    			$product_image['created_at'] = date('Y-m-d H:i:s');

    			$this->db->insert('product_images', $product_image);
            }
            
            //Insert product price for this product in client_product_price table for all clients.
            if($clients=$this->db->get("clients")->result_array()){
                $clients = array_map(function($client) use($id,$product){
                    return array(
                        'product_id'    =>  $id,
                        'sale_price'    =>  $product['sale_price'],
                        'client_id'     =>  $client['id'],
                        'created_at'    =>  date('Y-m-d H:i:s'),
                        'created_by'    =>  USER_ID,
                        'status'        =>  'Active'
                    );
                },$clients);

                $this->db->insert_batch("client_product_price",$clients);
            }
    	}
    	$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
	        return false;
		}
		return $id;
    }

    public function getAllProducts(){
        $colsArr = array(
            '',            
            'products.product_code',
            'products.product_name',
            'brands.brand_name',
            'products.weight',
            'products.cost_price',
            'products.sale_price',
            '(
                CASE 
                    WHEN products.manage_stock_needed = 1
                    THEN "Yes"
                    ELSE "No"
                END
            )',
            'action',
        );

        $query = $this->model
                    ->common_select('
                                        products.*,
                                        brands.brand_name,
                                        product_images.thumb,
                                        (
                                            CASE 
                                                WHEN products.manage_stock_needed = 1
                                                THEN "Yes"
                                                ELSE "No"
                                            END
                                        ) AS manage_stock
                                    ')
                    ->common_join("brands","brands.id = products.brand_id","left")
                    ->common_join("product_images","product_images.product_id = products.id","left")
                    ->common_get('products');
        echo $this->model->common_datatable($colsArr, $query,"products.is_deleted = 0","products.id",false,array(
            'path'  =>  'files'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.'thumbnails'.DIRECTORY_SEPARATOR,
            'no_image' => 'files'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'product_image_unavailable.png',
        ));die;
    }
}