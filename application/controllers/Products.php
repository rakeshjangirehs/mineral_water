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
        	// print_r($_FILES);
        	// die;
        	$productData = array(
        		'product_name'		=> $this->input->post('product_name'),
        		'product_code'		=> $this->input->post('product_code'),
        		'description'		=> $this->input->post('description'),
        		'weight'			=> $this->input->post('weight'),
        		'dimension'			=> $this->input->post('dimension'),
        		'cost_price'		=> $this->input->post('cost_price'),
        		'sale_price'		=> $this->input->post('sale_price')
        	);

        	$productImageData = array();
        	if(isset($_FILES['product_image']['name']) && $_FILES['product_image']['name']!=""){
	        	$imageData = $this->store('product_image');
	        	if(!empty($imageData['file_name'])){
	        		if($this->do_resize($imageData)){        			
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
        		$type = 'success';
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
    	// var_dump($_FILES['product_image']['type']);die;
        $allowed_mime_type_arr = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = $_FILES['product_image']['type'];
        if(isset($_FILES['product_image']['name']) && $_FILES['product_image']['name']!=""){
        	if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Please select only pdf/gif/jpg/png file.');
                return false;
            }
        }
        return true;
    }

    public function store($str){
    	$config['upload_path'] = FCPATH. 'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.'originals'.DIRECTORY_SEPARATOR;
        $config['allowed_types'] = 'gif|jpg|png';
        // $config['max_size'] = 2000;
        // $config['max_width'] = 1500;
        // $config['max_height'] = 1500;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($str)) {
            $error = array('error' => $this->upload->display_errors());
            echo "<pre>"; print_r($error);die;
        } else {
            $image_data = $this->upload->data();
            return $image_data;
        }
    }

    public function do_resize($image_data = array()){
    	$this->load->library('image_lib');
        $configer =  array(
          'image_library'   => 'gd2',
          'source_image'    =>  $image_data['full_path'],
          'new_image'		=>	FCPATH. 'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.'thumbnails'.DIRECTORY_SEPARATOR,
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
}