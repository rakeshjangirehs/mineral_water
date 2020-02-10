<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends MY_Controller {

	public function __construct(){

        parent::__construct();
        
		$this->load->model('client');
		$this->load->model('user');

        //validation config
        $this->client_validation_config = array(
            array(
                'field' => 'client_name',
                'label' => 'Client Name',
                'rules' => 'required|max_length[200]'
            ),
            array(
                'field' => 'credit_limit',
                'label' => 'Credit Limit',
                'rules' => 'numeric|max_length[20]'
            ),
            array(
                'field' => 'address',
                'label' => 'Address',
                'rules' => 'max_length[500]'
            ),
            array(
                'field' => 'state_id',
                'label' => 'State',
                'rules' => 'required|integer'
            ),
            array(
                'field' => 'city_id',
                'label' => 'City',
                'rules' => 'required|integer'
            ),
            array(
                'field' => 'zip_code_id',
                'label' => 'ZIP Code',
                'rules' => 'required|integer'
            ),

            array(
                'field' => 'contact_person_name_1',
                'label' => 'Name',
                'rules' => 'required|max_length[200]'
            ),
            array(
                'field' => 'contact_person_1_phone_1',
                'label' => 'Contact No',
                'rules' => 'required|integer|max_length[12]|min_length[6]|callback_not_equal_phone'
            ),
            array(
                'field' => 'contact_person_1_phone_2',
                'label' => 'Contact No',
                'rules' => 'integer|max_length[12]|min_length[6]|callback_not_equal_phone'
            ),
            array(
                'field' => 'contact_person_1_email',
                'label' => 'Email',
                'rules' => 'required|valid_email|max_length[200]'   //|callback_check_duplicate_email
            ),

            array(
                'field' => 'contact_person_name_2',
                'label' => 'Name',
                'rules' => 'max_length[200]'
            ),
            array(
                'field' => 'contact_person_2_phone_1',
                'label' => 'Contact No',
                'rules' => 'integer|max_length[12]|min_length[6]|callback_not_equal_phone'  //|callback_check_duplicate_phone
            ),
            array(
                'field' => 'contact_person_2_phone_2',
                'label' => 'Contact No',
                'rules' => 'integer|max_length[12]|min_length[6]|callback_not_equal_phone'  //|callback_check_duplicate_phone
            ),
            array(
                'field' => 'contact_person_2_email',
                'label' => 'Email',
                'rules' => 'valid_email|max_length[200]'    //|callback_check_duplicate_email
            ),

        );

        $this->client_address_validation_config = array(
            array(
                'field' => 'title',
                'label' => 'Title',
                'rules' => 'trim|required|max_length[200]'
            ),
            array(
                'field' => 'address',
                'label' => 'Address',
                'rules' => 'trim|required|max_length[500]'
            ),
            array(
                'field' => 'zip_code_id',
                'label' => 'Zip Code',
                'rules' => 'required|integer'
            ),
            array(
                'field' => 'lat',
                'label' => 'Latitude',
                'rules' => 'trim|decimal'
            ),
            array(
                'field' => 'lng',
                'label' => 'Longitude',
                'rules' => 'trim|decimal'
            ),
        );
    }
    
    public function check_duplicate_phone($new_phone){

        $user_id = $this->uri->segment(3);

        if($new_phone && !$this->client->check_duplicate("clients","contact_person_1_phone_1,contact_person_1_phone_2,contact_person_2_phone_1,contact_person_2_phone_2", $new_phone, $user_id)){
            $this->form_validation->set_message('check_duplicate_phone',"{$new_phone} already exist.");
            return false;
        }else{
            return true;
        }
    }

    public function check_duplicate_email($new_email){

        $user_id = $this->uri->segment(3);

        if($new_email && !$this->client->check_duplicate("clients","contact_person_1_email,contact_person_2_email", $new_email, $user_id)){
            $this->form_validation->set_message('check_duplicate_email',"{$new_email} already exist.");
            return false;
        }else{
            return true;
        }
    }

    public function not_equal_phone($new_value){    

        if($new_value){
            
            $contact_person_1_phone_1 =  $this->input->post("contact_person_1_phone_1");
            $contact_person_1_phone_2 =  $this->input->post("contact_person_1_phone_2");
            $contact_person_2_phone_1 =  $this->input->post("contact_person_2_phone_1");
            $contact_person_2_phone_2 =  $this->input->post("contact_person_2_phone_2");

            if(
                ( $contact_person_1_phone_1 != '' && $contact_person_1_phone_2 !='' && ($contact_person_1_phone_1 == $contact_person_1_phone_2) )
                || ( $contact_person_1_phone_1 != '' && $contact_person_2_phone_1 !='' && ($contact_person_1_phone_1 == $contact_person_2_phone_1) )
                || ( $contact_person_1_phone_1 != '' && $contact_person_2_phone_2 !='' && ($contact_person_1_phone_1 == $contact_person_2_phone_2) )
                || ( $contact_person_1_phone_2 != '' && $contact_person_2_phone_1 !='' && ($contact_person_1_phone_2 == $contact_person_2_phone_1) )
                || ( $contact_person_1_phone_2 != '' && $contact_person_2_phone_2 !='' && ($contact_person_1_phone_2 == $contact_person_2_phone_2) )
                || ( $contact_person_2_phone_1 != '' && $contact_person_2_phone_2 !='' && ($contact_person_2_phone_1 == $contact_person_2_phone_2) )
            ){
                $this->form_validation->set_message('not_equal_phone',"Phone No. must be distinct.");
                return false;
            }else{
                return true;
            }

        }else{
            return true;
        }
    }

	public function index(){

		if($this->input->is_ajax_request()){

			$colsArr = array(
				'`clients`.`client_name`',
				'`clients`.`gst_no`',
				'`clients`.`credit_limit`',
				'`clients`.`address`',
				'`zip_codes`.`zip_code`',
				'action'
			);

			$query = $this
						->model
						->common_select('clients.*,`zip_codes`.`zip_code`')
						->common_join('zip_codes','zip_codes.id = clients.zip_code_id','LEFT')
						->common_get('clients');

			echo $this->model->common_datatable($colsArr, $query, "is_deleted = 0");die;
        }
        
		$this->data['page_title'] = 'Client List';
		$this->load_content('client/client_list', $this->data);
    }
    
    public function client_export(){
		$query = $this
                    ->model
                    ->common_select('`clients`.`client_name`,`clients`.`gst_no`, `clients`.`credit_limit`,`clients`.`address`,`zip_codes`.`zip_code`')
                    ->common_join('zip_codes','zip_codes.id = clients.zip_code_id','LEFT')
                    ->common_where('clients.is_deleted = 0')
                    ->common_get('clients');

		$resultData = $this->db->query($query)->result_array();
		$headerColumns = implode(',', array_keys($resultData[0]));
		$filename = 'clients-'.time().'.xlsx';
		$title = 'Client List';
		$sheetTitle = 'Client List';
		$this->export( $filename, $title, $sheetTitle, $headerColumns,  $resultData );
    }

	public function add_update( $id = NULL ){
        
		$userArr = array(
			'client_name'	=> '',
			'gst_no'		=> '',
			'address'		=> '',
			'credit_limit'  => '',
			'zip_code_id'   => '',
			'state_id'	    => '',
            'city_id'	    => '',
            'category_id'   => '',
            
			'contact_person_name_1'	        => '',
			'contact_person_1_phone_1'	    => '',
			'contact_person_1_phone_2'	    => '',
            'contact_person_1_email'	    => '',
            
            'contact_person_name_2'	        => '',
			'contact_person_2_phone_1'	    => '',
			'contact_person_2_phone_2'	    => '',
            'contact_person_2_email'	    => '',
        );
        
        $this->data['cities'] = [];
        $all_zip_code_where = [];

		if($id){
			$this->data['page_title'] = 'Update Client';
            $userArr = $this->client->get_client_by_id($id);
            
            // echo "<pre>";print_r($userArr);die;

            if($state_id = $userArr['state_id']){
                $this->data['cities'] = $this->db->get_where('cities',["is_deleted"=>0,'state_id'=>$state_id])->result_array();
                $all_zip_code_where["state_id"] = $state_id;
            }

            if($city_id = $userArr['city_id']){
                $all_zip_code_where["city_id"] = $city_id;
            }

		}else{
			$this->data['page_title'] = 'Add Client';
		}

		if($this->input->server("REQUEST_METHOD") == "POST"){
            // echo "<pre>";print_r($_POST);die;
            $this->form_validation->set_rules($this->client_validation_config);

            if ($this->form_validation->run() == TRUE) {

                $userData = array(
                    'client_name' => ($this->input->post('client_name')) ? $this->input->post('client_name') : NULL,
                    'gst_no' => ($this->input->post('gst_no')) ? $this->input->post('gst_no') : NULL,
                    'address' => ($this->input->post('address')) ? $this->input->post('address') : NULL,
                    'credit_limit' => ($this->input->post('credit_limit')) ? $this->input->post('credit_limit') : NULL,
                    'zip_code_id' => ($this->input->post('zip_code_id')) ? $this->input->post('zip_code_id') : NULL,
                    'state_id' => ($this->input->post('state_id')) ? $this->input->post('state_id') : NULL,
                    'city_id' => ($this->input->post('city_id')) ? $this->input->post('city_id') : NULL,
                    'category_id' => ($this->input->post('category_id')) ? $this->input->post('category_id') : NULL,

                    'contact_person_name_1' => ($this->input->post('contact_person_name_1')) ? $this->input->post('contact_person_name_1') : NULL,
                    'contact_person_1_phone_1' => ($this->input->post('contact_person_1_phone_1')) ? $this->input->post('contact_person_1_phone_1') : NULL,
                    'contact_person_1_phone_2' => ($this->input->post('contact_person_1_phone_2')) ? $this->input->post('contact_person_1_phone_2') : NULL,
                    'contact_person_1_email' => ($this->input->post('contact_person_1_email')) ? $this->input->post('contact_person_1_email') : NULL,

                    'contact_person_name_2' => ($this->input->post('contact_person_name_2')) ? $this->input->post('contact_person_name_2') : NULL,
                    'contact_person_2_phone_1' => ($this->input->post('contact_person_2_phone_1')) ? $this->input->post('contact_person_2_phone_1') : NULL,
                    'contact_person_2_phone_2' => ($this->input->post('contact_person_2_phone_2')) ? $this->input->post('contact_person_2_phone_2') : NULL,
                    'contact_person_2_email' => ($this->input->post('contact_person_2_email')) ? $this->input->post('contact_person_2_email') : NULL,

                );

                // add or update records
                if ($this->client->add_update($userData, $id)) {
                    $msg = 'Client created successfully.';
                    $type = 'success';
                    if ($id) {
                        $msg = "Client updated successfully.";
                        $this->flash($type, $msg);
                    } else {
                        $this->flash($type, $msg);
                    }
                } else {
                    $this->flash('error', 'Some error ocurred. Please try again later.');
                }
                redirect('clients', 'location');
            }else{
                // echo validation_errors();die;
                if($state_id = $this->input->post('state_id')){
                    $this->data['cities'] = $this->db->get_where('cities',["is_deleted"=>0,'state_id'=>$state_id])->result_array();
                    $all_zip_code_where["state_id"] = $state_id;
                }

                if($city_id = $this->input->post('city_id')){
                    $all_zip_code_where["city_id"] = $city_id;
                }
            }
		}

        $this->data['states'] = $this->model->get('states',"0","is_deleted",true);
        $this->data['all_zipcodes'] = array_column($this->db->get_where("zip_codes",$all_zip_code_where)->result_array(),"zip_code","id");
        $this->data['client_categories'] = $this->db->get_where("client_categories")->result_array();
        
        $this->data['salesmen'] = $this->user->get_user_by_role(2);
		$this->data['id'] = $id;
		$this->data['user_data'] = $userArr;
		$this->load_content('client/add_update', $this->data);
	}

    public function delete($client_id){
        if($this->db->update("clients",array('is_deleted'=>1),array('id'=>$client_id))){
            $this->flash("success","Client Deleted Successfully");
        }else{
            $this->flash("error","Client not Deleted");
        }
        redirect("clients/index");
    }

    public function price_list($client_id){
        
        $query = "SELECT
                    products.*,
                    client_product_price.sale_price as client_price,
                    client_product_price.id as client_product_price_id
                FROM products
                LEFT JOIN client_product_price ON client_product_price.product_id = products.id
                WHERE client_product_price.client_id={$client_id}
                ORDER BY products.product_name";
        $data = $this->db->query($query)->result_array();
        
        $client = $this->db->get_where("clients",["id"=>$client_id])->row_array();
        
        // echo "<pre>";print_r($data);echo "</pre>";die;

        $this->data['page_title'] = "Client Price List - {$client['client_name']}";
        $this->data['client'] = $client;
        $this->data['id'] = $client_id;
        $this->data['product_list'] = $data;
		$this->load_content('client/price_list', $this->data);

    }

    public function update_price($client_id){
        
        $price_list = $this->input->post('product');
        
        // echo "<pre>";print_r($price_list);echo "</pre>";

        $data = array_map(function($arr){
            unset($arr['old_price']);
            $arr['updated_at']    =  date('Y-m-d H:i:s');
            $arr['updated_by']    =  USER_ID;
            return $arr;
        },
            array_filter($price_list,function($arr){
                return ($arr['old_price'] != $arr['sale_price']);
            })
        );
        
        // echo "<pre>";print_r($data);
        
        if($data){
            // $this->db->where('client_id',$client_id);
            if($this->db->update_batch("client_product_price",$data,"id") !== FALSE){
                $this->flash('success','Prices updated successfully');
            }else{
                $this->flash('error','Prices not updated');
            }
            // echo "<pre>".$this->db->last_query();
        }else{
            $this->flash('success','Nothing to update');
        }
        redirect("clients/price_list/{$client_id}");        
    }

    public function client_price_export($client_id){

        $query = "SELECT
                products.id as product_id,
                products.product_name,
                products.cost_price,
                products.sale_price,
                client_product_price.sale_price as client_price
            FROM products
            LEFT JOIN client_product_price ON client_product_price.product_id = products.id
            WHERE client_product_price.client_id={$client_id}";
        
        $client = $this->db->get_where("clients",["id"=>$client_id])->row_array();

        $resultData = $this->db->query($query)->result_array();
        if($resultData){
            $headerColumns = implode(',', array_keys($resultData[0]));
            $filename = 'price_list-'.$client['client_name'].'-'.time().'.xlsx';
            $title = 'Price List - '.$client['client_name'];
            $sheetTitle = 'Price List - '.$client['client_name'];
            $this->export( $filename, $title, $sheetTitle, $headerColumns,  $resultData );        
        }else{
            $this->flash("error","No data to export");
            redirect("clients/price_list/{$client_id}");
        }		
    }
    
    private function get_client_price_list($client_id){

        $query = "SELECT
                    products.id as product_id,
                    products.product_name,
                    products.cost_price,
                    products.sale_price,
                    client_product_price.sale_price as client_price
                FROM products
                RIGHT JOIN client_product_price ON client_product_price.product_id = products.id
                WHERE client_product_price.client_id={$client_id}
                ORDER BY products.product_name";

        return $this->db->query($query)->result_array();
        
    }

    public function price_list_sample($client_id){

        $client = $this->db->get_where("clients",["id"=>$client_id])->row_array();
        $resultData = $this->get_client_price_list($client_id);

		$headerColumns = implode(',', array_keys($resultData[0]));
		$filename = 'price_list_sample.xlsx';
		// $title = 'Price List - '.$client['client_name'];
		$sheetTitle = 'Price List - '.$client['client_name'];
        $this->export( $filename, "NO", $sheetTitle, $headerColumns,  $resultData );  
    }

    public function price_list_import($client_id){

        if(isset($_FILES['csv_file']) && $_FILES['csv_file']['error']==0){
		  
            $csv_data = $this->readExcel($_FILES['csv_file']['tmp_name']);

            $client_price_list = $this->get_client_price_list($client_id);

            $product_id_arr = array_column($client_price_list,'product_id');
            
            if(count($csv_data) > 2){
              
              $data_to_import = [];


              foreach($csv_data as $k=>$arr){
      
                if($k==1) continue; //Skip header row

                if(in_array($arr['A'],$product_id_arr)){
                    $data_to_import[] = array(
                        'client_id'     =>  $client_id,
                        'product_id'    =>  $arr['A'],
                        'sale_price'    =>  $arr['E'],
                        'created_at'    =>  date('Y-m-d H:i:s'),
                        'created_by'    =>  USER_ID
                    );
                }
              }
  
              if($data_to_import){                

                if($this->db->where("client_id = {$client_id}")->update_batch("client_product_price",$data_to_import,'product_id') !== FALSE){                                        
                    $this->flash('success','Prices updated successfully');
                }else{
                  $this->flash("error","Internal Server Error. Please try again.");
                }
              }else{
                $this->flash("error","No records imported.");
              }
            }else{
              $this->flash("error","Empty file can't be processed.");
            }
          }else{
            $this->flash("error","Please try again later.");			
          }
          redirect("clients/price_list/{$client_id}");
    }

    public function client_delivery_addresses($client_id, $address_id=NULL){

        $this->data['client_id'] = $client_id;
        $this->data['address_id'] = $address_id;

        if($address_id){
            $address = $this->db->get_where("client_delivery_addresses","id = {$address_id}")->row_array();
            // echo $this->db->last_query();
            // echo "<pre>";print_r($address);die;
            $this->data['form_title'] = 'Update Address';
        }else{
            $address = array(
                'title'     =>  null,
                'address'   =>  null,
                'zip_code_id'=>  null,
                'lat'=>  null,
                'lng'=>  null,
            );
            $this->data['form_title'] = 'Add Address';
        }

        if($this->input->is_ajax_request()){
			$colsArr = array(
				'title',
                'address',
                "(CASE
                    WHEN client_delivery_addresses.lat IS NOT NULL AND client_delivery_addresses.lng IS NOT NULL
                    THEN CONCAT(client_delivery_addresses.lat,client_delivery_addresses.lng)
                    ELSE NULL
                END)",
                'zip_codes.zip_code',
				'action'
			);

            $query = $this
                ->model
                ->common_select("
                                    client_delivery_addresses.*,
                                    (CASE
                                        WHEN client_delivery_addresses.lat IS NOT NULL AND client_delivery_addresses.lng IS NOT NULL
                                        THEN CONCAT(client_delivery_addresses.lat,client_delivery_addresses.lng)
                                        ELSE NULL
                                    END)  AS coordinates,
                                    zip_codes.zip_code
                                ")
                ->common_join('`zip_codes`','`zip_codes`.`id` = `client_delivery_addresses`.`zip_code_id`','LEFT')
                ->common_get('`client_delivery_addresses`');

			echo $this->model->common_datatable($colsArr, $query, "client_delivery_addresses.is_deleted = 0 AND client_delivery_addresses.client_id = {$client_id}");die;
		}

        if($this->input->server("REQUEST_METHOD") == "POST"){
            
            $this->form_validation->set_rules($this->client_address_validation_config);

            if ($this->form_validation->run() == TRUE) {

                $data = array(
                    'title'      =>  $this->input->post('title'),
                    'address'    =>  $this->input->post('address'),
                    'zip_code_id'=>  $this->input->post('zip_code_id'),
                    'lat'        =>  ($this->input->post('lat')) ? $this->input->post('lat') : null,
                    'lng'        =>  ($this->input->post('lng')) ? $this->input->post('lng') : null,
                    'client_id'  =>  $client_id,
                );

                if ($this->client->add_update_address($data, $address_id)) {
                    
                    $msg = ($address_id) ? 'Client updated successfully.' : 'Address created successfully.';
                    $this->flash('success', $msg);

                } else {
                    $this->flash('error', 'Some error ocurred. Please try again later.');
                }
                redirect("clients/client_delivery_addresses/{$client_id}", 'location');
            }
        }

        $this->data['address'] = $address;
        $this->data['page_title'] = 'Client Delivery Addresses';
        $this->data['all_zipcodes'] = array_column($this->db->get_where("zip_codes")->result_array(),"zip_code","id");

		$this->load_content('client/client_delivery_addresses', $this->data);
    }

    public function delivery_addresses_get(){

        $client_id= ($this->input->post('client_id')) ? $this->input->post('client_id') : null;

        if($client_id) {
            $delivery_addresses = $this->db
                                ->select("client_delivery_addresses.id,client_delivery_addresses.title,client_delivery_addresses.address,zip_codes.zip_code")
                                ->join("zip_codes","zip_codes.id = client_delivery_addresses.zip_code_id")
                                ->where("client_delivery_addresses.client_id",$client_id)->get("client_delivery_addresses")->result_array();
            
            if($delivery_addresses) {
                echo json_encode([
                    'status'    =>  true,
                    'message'   =>  'Delivery address found',
                    'addresses'   =>  $delivery_addresses
                ]);
            } else {
                echo json_encode([
                    'status'    =>  false,
                    'message'   =>  'No delivery address found',
                    'addresses'   =>  $delivery_addresses
                ]);
            }
            
        } else {
            echo json_encode([
                'status'    =>  false,
                'message'   =>  'Client Id not provided',
                'addresses'   =>  []
            ]);
        }
    }
    
    public function add_location($id=null){
        echo "Feedback Required";
        $client = $this->client->get_client_by_id($id);
        $this->data['client'] = $client;

        if($this->input->server("REQUEST_METHOD") == "POST"){

        }

        $this->data['page_title'] = 'Client Location';
        $this->data['sub_page_title'] = "{$client['first_name']} {$client['last_name']}";
        $this->load_content('client/client_location', $this->data);
    }

    public function contacts($client_id,$contact_id=NULL){

        $this->data['client'] = $this->model->get("clients",$client_id,'id');
        $this->data['client_contacts'] = $this->model->get("client_contacts",$client_id,'client_id',true);
        $this->data['current_contact'] = ($contact_id) ? $this->model->get("client_contacts",$contact_id,'id') : array('person_name'=>'','phone'=>'','is_primary'=>"No");

        $this->data['page_title'] = 'Client Contacts';
        $this->data['sub_page_title'] = $this->data['client']['first_name'].' '.$this->data['client']['last_name'];

        $this->data['client_id'] = $client_id;
        $this->data['contact_id'] = $contact_id;
        $this->data['form_title'] = ($contact_id) ? "Update Client Contact" : "Add Client Contact";

        if($this->input->server("REQUEST_METHOD") == "POST"){

            $phone = $this->input->post('phone');

            // check username exist or not
            $existPhone = $this->client->check_contact_exist("phone", $phone, $contact_id);

            if($existPhone){
                $this->flash('error', 'Phone already exist.');
                redirect("clients/contacts/{$client_id}/{$contact_id}", 'location');
            }

            $data = array(
                'client_id'     =>  $client_id,
                'person_name'   =>  $this->input->post('person_name'),
                'phone'         =>  $phone,
                'is_primary'    =>  ($this->input->post('is_primary')=='Yes') ? 'Yes' : 'No',
            );

            if($this->client->insert_update_client_contact($data,$client_id,$contact_id)){
                $msg = 'Client Contact created successfully.';
                $type = 'success';
                if($contact_id){
                    $msg = "Client Contact updated successfully.";
                    $this->flash($type, $msg);
                }else{
                    $this->flash($type, $msg);
                }
            }else{
                $this->flash('error', 'Some error ocurred. Please try again later.');
            }

            redirect("clients/contacts/{$client_id}",'location');
        }

        $this->load_content('client/client_contact_list', $this->data);
    }

    public function client_inventory(){

        if($this->input->is_ajax_request()){
			$colsArr = array(
				'client_name',
				'product_name',
				'client_quantity',
                'action'
			);

            $query = "SELECT
                        clients.id AS clinet_id,
                        clients.client_name,
                        products.id AS product_id,
                        products.product_name,
                        (
                            #SUM(IFNULL(client_product_inventory.existing_quentity,0)) +
                            SUM(IFNULL(client_product_inventory.new_delivered,0)) -
                            SUM(IFNULL(client_product_inventory.empty_collected,0))
                        ) AS client_quantity
                    FROM client_product_inventory
                    LEFT JOIN products ON products.id = client_product_inventory.product_id
                    LEFT JOIN clients ON clients.id = client_product_inventory.client_id
                    GROUP BY clients.id";

			echo $this->model->common_datatable($colsArr, $query, "",NULL,true);die;
		}

        $this->data['page_title'] = 'Client Inventory';
		$this->load_content('client/inventory_list', $this->data);
    }

    public function client_inventory_history($client_id=NULL){
        
        if($client_id){

            $sql = "SELECT
                        clients.id AS client_id,
                        clients.client_name,
                        products.id AS product_id,
                        products.product_name,
                        IFNULL(client_product_inventory.existing_quentity,0) AS `existing_quentity`,
                        IFNULL(client_product_inventory.new_delivered,0) AS `new_delivered`,
                        IFNULL(client_product_inventory.empty_collected,0) AS `empty_collected`,
                        DATE_FORMAT(delivery_config_orders.delivery_datetime,'%Y-%m-%d') AS delivey_date,
                        #delivery_boy.first_name AS delivery_boy,
                        #driver.first_name AS driver,
                        (CASE
                            WHEN delivery_boy.id IS NOT NULL
                            THEN CONCAT(delivery_boy.first_name, ' ', IFNULL(delivery_boy.last_name,''), '<br/>',driver.first_name, ' ',IFNULL(driver.last_name,''))
                            ELSE CONCAT(driver.first_name, ' ',IFNULL(driver.last_name,''))
                        END) AS `team`,
                        delivery_config_orders.signature_file
                    FROM client_product_inventory
                    LEFT JOIN products ON products.id = client_product_inventory.product_id
                    LEFT JOIN clients ON clients.id = client_product_inventory.client_id
                    LEFT JOIN delivery_config_orders ON delivery_config_orders.id = client_product_inventory.dco_id
                    LEFT JOIN delivery_config ON delivery_config.id = delivery_config_orders.delivery_config_id
                    LEFT JOIN delivery ON delivery.id = delivery_config.delivery_id
                    LEFT JOIN users AS delivery_boy ON delivery_boy.id = delivery_config.delivery_boy_id
                    LEFT JOIN users AS driver ON driver.id = delivery_config.driver_id
                    WHERE clients.id = {$client_id}
                    ORDER BY delivery_config_orders.delivery_datetime DESC
                    LIMIT 10";
            
            $inventory = $this->db->query($sql)->result_array();

            echo json_encode(array(
                'status'    =>  true,
                'message'   =>  'Success',
                'payload'   =>  $inventory,

            ));
        }else{
            echo json_encode(array(
                'status'    =>  false,
                'message'   =>  'Client not specified.',
                'payload'   =>  [],
            ));
        }
    }
}