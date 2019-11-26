<?php  
 defined('BASEPATH') OR exit('No direct script access allowed'); 
 /** Developer: Milan Soni 
  * Created Date: 2019-08-26 16:57:31 
  * Created By : CLI 
 */ 
 
class Products extends MY_Controller {
 
 	public function __construct() {

		parent::__construct();

		$this->load->model('product_model');
		  
		$this->product_validation_config = array(
			array(
				'field' => 'product_name',
				'label' => 'Product Name',
				'rules' => 'trim|required|max_length[300]'
			),
			array(
				'field' => 'product_code',
				'label' => 'Product Code',
				'rules' => 'trim|required|max_length[50]|callback_check_duplicate_product_code'
			),
			array(
				'field' => 'weight',
				'label' => 'Weight',
				'rules' => 'trim|required|decimal'
			),
			array(
				'field' => 'cost_price',
				'label' => 'Cost Price',
				'rules' => 'trim|decimal'
			),
			array(
				'field' => 'sale_price',
				'label' => 'Sale Price',
				'rules' => 'trim|required|decimal'
			),
			array(
				'field' => 'brand_id',
				'label' => 'Brand',
				'rules' => 'trim|required|integer'
			),
			array(
				'field' => 'product_image',
				'label' => 'Product Image',
				'rules' => 'callback_validate_file'
			),
		);
 	}

 	public function index(){

 		if($this->input->is_ajax_request()){
			$this->product_model->getAllProducts();
		}

 		$this->data['page_title'] = "Product List";
		 $this->load_content('product/product_list', $this->data);
		 
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
 			'brand_id'			=>	'',
		 );
		 
 		$this->data['page_title'] = 'Add Product';
 		if($id){
 			$productsArr = $this->model->get("products", $id, 'id');
 			$this->data['page_title'] = 'Update Product';
 		}

		$this->form_validation->set_rules($this->product_validation_config);
 		if ($this->form_validation->run() == TRUE)
	    {
        	$productData = array(
        		'product_name'		=> $this->input->post('product_name'),
        		'product_code'		=> $this->input->post('product_code'),
        		'description'		=> $this->input->post('description'),
        		'weight'			=> $this->input->post('weight'),
        		'dimension'			=> $this->input->post('dimension'),
        		'cost_price'		=> $this->input->post('cost_price'),
        		'sale_price'		=> $this->input->post('sale_price'),
        		'brand_id'			=> $this->input->post('brand_id')
        	);

        	// upload product image if selected
        	$productImageData = array();
        	if(isset($_FILES['product_image']['name']) && $_FILES['product_image']['name']!=""){
	        	$imageData = $this->store('product_image');		// generate original image upload
	        	if(!empty($imageData['file_name'])){
	        		if($this->do_resize($imageData)){        	// resize image and generate thumbnail
	        			$thumbImageName = explode('.', $imageData['file_name']);
	        			$thumb = $thumbImageName[0].'_thumb'.'.'.$thumbImageName[1];
	        		}
	        	}

	        	$productImageData = array(
	        		'original_image_name'	=> $imageData['file_name'],
	        		'thumb'					=> $thumb,
	        		'is_primary'			=> 1
	        	);
        	}

        	if($this->product_model->add_update($productData, $productImageData, $id)){
        		$msg = '';
        		$type = 'message';
        		if($id){
        			$msg = 'Product updated successfully.';
        		}else{
        			$msg = 'Product inserted successfully.';
        		}
        	}else{
        		$msg = 'Some error occured. Please try again later.';
        		$type = 'error';
        	}
        	$this->flash($type, $msg);
        	redirect('products', 'location');
	    }

 		$this->data['products'] = $productsArr;
		$this->data['brands'] = $this->db->get_where("brands","is_deleted = 0")->result_array();
 		$this->data['id'] = $id;
 		$this->load_content('product/add_update', $this->data);
 	}

	public function delete($product_id){
		
		//remove client product price
		
		if($this->db->update("products",array('is_deleted'=>1),array('id'=>$product_id))){
			$this->flash("success","Product Deleted Successfully");
		}else{
			$this->flash("error","Product not Deleted");
		}
		redirect("products/index");
	}

	public function check_duplicate_product_code($new_code){

        $product_id = $this->uri->segment(3);

        if($new_code && !$this->product_model->check_duplicate("products","product_code", $new_code, $product_id)){
            $this->form_validation->set_message('check_duplicate_product_code',"{$new_code} already exist.");
            return false;
        }else{
            return true;
        }
	}

	public function validate_file($str){

		$allowed_mime_type_arr = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
		$mime = $_FILES['product_image']['type'];
		
		if(isset($_FILES['product_image']['name']) && $_FILES['product_image']['name']!=""){
			if(in_array($mime, $allowed_mime_type_arr)){
				return true;
			}else{
				$this->form_validation->set_message('validate_file', 'Please select only gif/jpg/png file.');
				return false;
			}
		}
		return true;
	}

	public function store($str){
		$config['upload_path'] = FCPATH.'files'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.'originals'.DIRECTORY_SEPARATOR;
		$config['allowed_types'] = 'gif|jpg|png';
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload($str)) {
		$error = array('error' => $this->upload->display_errors());
		echo "<pre>"; print_r($error);die;
		} else {
		$image_data = $this->upload->data();
		return $image_data;
		}
	}

  // generate image thumbnails
	public function do_resize($image_data = array()){
		$this->load->library('image_lib');
		$configer =  array(
		'image_library'   => 'gd2',
		'source_image'    =>  $image_data['full_path'],
		'new_image'		=>	FCPATH.'files'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.'thumbnails'.DIRECTORY_SEPARATOR,
		'maintain_ratio'  =>  TRUE,
		'create_thumb'	=> 	TRUE,
		'thumb_marker' 	=> '_thumb',
		'width'           =>  250,
		'height'          =>  250,
		);
		$this->image_lib->clear();
		$this->image_lib->initialize($configer);
		return $this->image_lib->resize();
	}

  // export all products in xlsx
  	public function product_export(){
		  $query = $this->model
                    ->common_select('product_code, products.product_name, products.weight, dimension, cost_price, sale_price')
                    ->common_where('products.is_deleted = 0')
                    ->common_get('products');

		  $resultData = $this->db->query($query)->result_array();
		  $headerColumns = implode(',', array_keys($resultData[0]));
		  $filename = 'products-'.time().'.xlsx';
		  $title = 'Product List';
		  $sheetTitle = 'Product List';
		  $this->export( $filename, $title, $sheetTitle, $headerColumns,  $resultData );
	}
}