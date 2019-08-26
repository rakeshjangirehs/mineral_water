<?php  
 defined('BASEPATH') OR exit('No direct script access allowed'); 
 /** Developer: Milan Soni 
  * Created Date: 2019-08-26 16:57:31 
  * Created By : CLI 
 */ 
 
 class Products extends MY_Controller {
 
 	public function __construct() {
 	 	parent::__construct();
 	}

 	public function index(){

 	}

 	public function add_update( $id = NULL ){
 		$productsArr = array(
 			'product_name'			=>	'',
 			'product_code'			=>	'',
 			'description'			=>	'',
 			'weight'				=> 	'',
 			'dimension'				=> 	'',
 			'cost_price'			=>	'',
 			'sale_price'			=>	'',
 		);
 		$this->data['page_title'] = 'Add Product';
 		if($id){
 			$productsArr = $this->model->get("products");
 			$this->data['page_title'] = 'Update Product';
 		}

 		$this->load->library('form_validation');
 		$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
 		$this->form_validation->set_rules('product_code', 'Product Code', 'trim|required|callback_check_duplicate');
 		$this->form_validation->set_rules('weight', 'Weight', 'trim|required');
 		$this->form_validation->set_rules('dimension', 'Dimension', 'trim|required');
 		$this->form_validation->set_rules('cost_price', 'Cost Price', 'trim|required');
 		$this->form_validation->set_rules('sale_price', 'Sale Price', 'trim|required');
 		$this->form_validation->set_rules('description', 'Description', 'trim');
 		$this->form_validation->set_rules('product_image', '', 'callback_file_check');

 		if ($this->form_validation->run() == TRUE)
	    {
        	echo "<pre>"; print_r($_POST);
        	print_r($_FILES);
        	die;
	    }

 		$this->data['products'] = $productsArr;
 		$this->load_content('product/add_update', $this->data);
 	}

 	public function check_duplicate(){
 		$id = $this->uri->segment(3);
		$where = " WHERE 1=1";
		if($id){
			$where .= " AND `id` NOT IN('{$id}')";
		}
 		$code = $this->input->post('product_code');

 		if(!empty($code)){
 			$where .= " AND `product_code` = '{$code}'";
 			$checkDuplicate = $this->db->query("SELECT 
								*
							FROM `products`
							$where
							")->num_rows();
			if($checkDuplicate > 0){
				$this->form_validation->set_message('check_duplicate','Entered code is already exist in the system.');
				return false;
			}
 		}
 		return true;
 	}

 	/*
     * file value and type check during validation
     */
    public function file_check($str){
        $allowed_mime_type_arr = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = $_FILES['product_image']['type'];
        if(isset($_FILES['product_image']['name']) && $_FILES['product_image']['name']!=""){
        	if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Please select only pdf/gif/jpg/png file.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check', 'Please choose a file to upload.');
            return false;
        }
    }
}