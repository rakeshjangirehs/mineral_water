<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class ApiV1 extends REST_Controller {

    public function __construct() { 

        parent::__construct();
        
        // Load the user model
        $this->load->model('user');
        $this->load->model('client');
        $this->load->model('activity');
        $this->load->model('order_model', 'order');
        $this->load->helper('url');

        $this->baseUrl = base_url()."index.php/";
        $this->client_signature_path = FCPATH. 'files'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'signatures'.DIRECTORY_SEPARATOR;
        $this->system_setting = $this->user->get_settings();

        $this->dashboard_images = array(
            array(
                "name"=>'product-edit1.jpg',
                "url"=>base_url()."files/assets/images/product-edit/product-edit1.jpg"
            ),
            array(
                "name"=>'product-edit2.jpg',
                "url"=>base_url()."files/assets/images/product-edit/product-edit2.jpg"
            ),
            array(
                "name"=>'product-edit3.jpg',
                "url"=>base_url()."files/assets/images/product-edit/product-edit3.jpg"
            )
        );

        // $h = fopen("demo.txt","a+");
        // fwrite($h,json_encode(array(
        //     'date'=>date('Y-m-d H:i:s'),
        //     'url'=>$_SERVER['PHP_SELF'],
        //     'method'=>$this->input->server('REQUEST_METHOD'),
        //     'data'=>$_REQUEST,
        // )) . PHP_EOL);
        // fclose($h);

    }
    
    

    
    // general function stop

    //Add/Update Visit - Client
    /*
    public function add_update_visit_post(){

        $id = $this->post('client_id');
        $user_id = $this->post('user_id');


        $email = ($this->input->post('email')) ? $this->input->post('email') : NULL;

        if($email){
            $existEmail = $this->client->check_exist("email", $email, $id);

            if($existEmail){
                $this->response(
                    array(
                        'status' => FALSE,
                        'message' => "Client Email already Exist",
                        'data' => []
                    ),
                    REST_Controller::HTTP_OK
                );
                die;
            }
        }

        $userData = array(
            'first_name'	=>$this->input->post('first_name'),
            'last_name'		=>($this->input->post('last_name')) ? $this->input->post('last_name') : NULL,
            'phone'		    =>($this->input->post('phone')) ? $this->input->post('phone') : NULL,
            'address'		=>($this->input->post('address')) ? $this->input->post('address') : NULL,
            'credit_limit'	=>($this->input->post('credit_limit')) ? $this->input->post('credit_limit') : NULL,
            'zip_code_id'	=>($this->input->post('zip_code_id')) ? $this->input->post('zip_code_id') : NULL,
            'email'			=>$email,
        );

        $visit_notes = ($this->input->post('visit_notes')) ? $this->input->post('visit_notes') : NULL;


        if($this->client->insert_update($userData, $id,NULL,$user_id,$visit_notes)){
            $msg = 'Client created successfully.';

            if($id){
                $msg = "Client updated successfully.";
            }

            $this->response(
                array(
                    'status' => TRUE,
                    'message' => $msg,
                    'data' => []
                ),
                REST_Controller::HTTP_OK
            );

        }else{
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => "Please try again",
                    'data' => []
                ),
                REST_Controller::HTTP_OK
            );
        }
    }
    */


    //Get Client Contacts
    /*public function contacts_get($client_id,$contact_id=NULL){

        if($contact_id){
            $contacts = $this->db->where("id = {$contact_id}")->get("client_contacts")->result_array();
        }else{
            $contacts = $this->db->where("client_id = {$client_id}")->get("client_contacts")->result_array();
        }

        $this->response(
            array(
                'status' => FALSE,
                'message' => "Client Contacts",
                'data' => $contacts
            ),
            REST_Controller::HTTP_OK
        );
    }*/

    //Add/Update Client Contact
    /*public function add_update_client_contact_post(){

        $client_id = $this->post('client_id');
        $user_id = $this->post('user_id');
        $contact_id = $this->post('contact_id');
        $phone = $this->input->post('phone');
        $lat = ($this->post('lat')) ? $this->post('lat') : NULL;
        $lng = ($this->post('lng')) ? $this->post('lng') : NULL;

        if($phone){
            $existPhone = $this->client->check_contact_exist("phone", $phone, $contact_id);

            if($existPhone){

                $this->response(
                    array(
                        'status' => FALSE,
                        'message' => "Phone already exist",
                        'data' => []
                    ),
                    REST_Controller::HTTP_OK
                );
                die;
            }
        }

        $data = array(
            'client_id'     =>  $client_id,
            'person_name'   =>  $this->input->post('person_name'),
            'phone'         =>  $phone,
            'lat'           =>  $lat,
            'lng'           =>  $lng,
            'is_primary'    =>  ($this->input->post('is_primary')=='Yes') ? 'Yes' : 'No',
        );

        if($this->client->insert_update_client_contact($data,$client_id,$contact_id,$user_id)){
            $msg = 'Client Contact created successfully.';

            if($contact_id){
                $msg = "Client Contact updated successfully.";
            }

            $this->response(
                array(
                    'status' => TRUE,
                    'message' => $msg,
                    'data' => []
                ),
                REST_Controller::HTTP_OK
            );
        }else{
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => "Please try again",
                    'data' => []
                ),
                REST_Controller::HTTP_OK
            );
        }
    }*/

    //Add Client Visit
    /*public function add_client_visit_post(){

        $data = array(
            'client_id'  => $this->post('client_id'),
            'visit_notes' => $this->post('visit_note'),
            'created_by' => $this->post('user_id'),
            'created_at' => date('Y-m-d H:i:s'),
        );

        if($this->db->insert("client_visits",$data)){
            $this->response(
                array(
                    'status' => TRUE,
                    'message' => "Client Visit Added",
                    'data' => []
                ),
                REST_Controller::HTTP_OK
            );
        }else{
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => "Please try again later",
                    'data' => []
                ),
                REST_Controller::HTTP_BAD_REQUEST
            );
        }
    }*/

        // delivery boy
        /*public function order_delivery_post(){

            $user_id = $this->post('user_id');
            $order_id = $this->post('order_id');
            $lat = $this->post('lat');
            $lng = $this->post('lng');

            // echo "<pre>"; print_r($_FILES);die;

            if(!empty($user_id) && !empty($order_id) && !empty($lat) && !empty($lng) && !empty($_FILES)){
                // check file type validation (image only)
                $this->file_check();

                $imageData = $this->store('signature');     // generate original image upload
            }else{
                $this->response(
                    array(
                        'status' => FALSE,
                        'message' => "Provide user_id, order_id, lat, lng and signature.",
                        'data' => []
                    ),
                    REST_Controller::HTTP_BAD_REQUEST
                );   
            }
        }
        // file validation
        public function file_check(){
            // var_dump($_FILES['signature']['type']);die;
            $allowed_mime_type_arr = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
            $mime = $_FILES['signature']['type'];
            if(isset($_FILES['signature']['name']) && $_FILES['signature']['name']!=""){
                if(!in_array($mime, $allowed_mime_type_arr)){
                    $this->response(
                        array(
                            'status' => FALSE,
                            'message' => "Signature is only image file.",
                            'data' => []
                        ),
                        REST_Controller::HTTP_BAD_REQUEST
                    );
                }
            }
            return true;
        }
        // store signature
        public function store($str){
            $config['upload_path'] = FCPATH. 'files'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'orders'.DIRECTORY_SEPARATOR.'signatures'.DIRECTORY_SEPARATOR;
            $config['allowed_types'] = 'gif|jpg|png';
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($str)) {
                $error = array('error' => $this->upload->display_errors());
                echo "<pre>"; print_r($error);die;
            } else {
                $image_data = $this->upload->data();
                return $image_data;
            }
        }*/

    /*public function client_invoice_summary_get($user_id = NULL){
        $client = array();
        $client = $this->db->query("SELECT 
                                        `clients`.*,
                                        COUNT(`paid`.`paid_ids`) AS `paid_invoice`,
                                        COUNT(`partial_inv`.`partial_ids`) AS `partial_invoice`,
                                        COUNT(`pending_inv`.`pending`) AS `pending_invoice`
                                    FROM `clients`
                                    LEFT JOIN(
                                        SELECT
                                            `orders`.`id`,
                                            `orders`.`client_id`,
                                            `payment_details`.`id` AS `paid_ids`
                                        FROM `orders`
                                        INNER JOIN `payment_details` ON `payment_details`.`order_id` = `orders`.`id`
                                        WHERE `payment_details`.`status` = 'PAID'
                                    ) AS `paid` ON `paid`.`client_id` = `clients`.`id`
                                    LEFT JOIN (
                                        SELECT
                                            `orders`.`id`,
                                            `orders`.`client_id`,
                                            `payment_details`.`id` AS `partial_ids`
                                        FROM `orders`
                                        INNER JOIN `payment_details` ON `payment_details`.`order_id` = `orders`.`id`
                                        WHERE `payment_details`.`status` = 'PARTIAL'
                                    ) AS `partial_inv` ON `partial_inv`.`client_id` = `clients`.`id`
                                    LEFT JOIN (
                                        SELECT
                                            `orders`.`id`,
                                            `orders`.`client_id`,
                                            `payment_details`.`id` AS `pending`,
                                            `payment_details`.`status`
                                        FROM `orders`
                                        LEFT JOIN `payment_details` ON `payment_details`.`order_id` = `orders`.`id`
                                        WHERE `payment_details`.`status` IS NULL
                                    ) AS `pending_inv` ON `pending_inv`.`client_id` = `clients`.`id`
                                    WHERE `created_by` = $user_id
                                    GROUP BY `clients`.`id`
                                ")->result_array();

        if($client){
            $this->response(
                array(
                    'status' => TRUE,
                    'message' => "Pending invoice found.",
                    'data' => $client
                ),
                REST_Controller::HTTP_OK
            );
        }else{
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => "No pending invoice found.",
                    'data' => $client
                ),
                REST_Controller::HTTP_OK
            );
        }
    }*/

    

    /*public function today_delivery_get($user_id = NULL){
        
        if(!$user_id){
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => "Please provide user_id.",
                    'today_delivery'=>0
                ),
                REST_Controller::HTTP_OK
            );
        }

        $sql = $this->db->query("SELECT
                    `orders`.*,
                   `clients`.`client_name` AS `client_name`,
                    #`clients`.`email`,
                    #IFNULL(`clients`.`phone`, '-') AS phone,
                    `clients`.`address`,
                    `details`.`order_details`
                FROM `orders`
                LEFT JOIN `clients` ON `clients`.`id` = `orders`.`client_id`
                LEFT JOIN (
                    SELECT 
                        CONCAT(
                            '[',
                                GROUP_CONCAT(
                                    CONCAT(
                                        '{',
                                        '\"product_id\": \"', product_id, '\", ',
                                        '\"product_name\": \"', product_name, '\", ',
                                        '\"quantity\": \"', quantity, '\", ',
                                        '\"sale_price\": \"', effective_price, '\", ',
                                        '\"subtotal\": \"', (effective_price*quantity), '\" ',
                                        '}'
                                    )
                                ),
                            ']'
                        ) AS `order_details`,
                        `order_id`
                    FROM `order_items`
                    LEFT JOIN `products` ON `products`.`id` = `order_items`.`product_id`
                    GROUP BY `order_items`.`order_id`
                ) AS `details` ON `details`.`order_id` = `orders`.`id`
                WHERE delivery_boy_id = $user_id
                AND (expected_delivery_date = CURDATE() OR actual_delivery_date IS NULL)
                AND actual_delivery_date IS NULL
                GROUP BY `orders`.`id`
        ");

        $main_data = ($sql->result_array()) ? $sql->result_array() : array();
        if(!empty($main_data)){
            foreach ($main_data as &$tmpdata) {
                $tmpdata['status'] = 'delivered';
                $tmpdata['order_details'] = json_decode($tmpdata['order_details'],true);
            }
        }

        $this->response(
            array(
                'status' => TRUE,
                'message' => "Delivery found.",
                'today_delivery'=>$this->db->affected_rows(),
                'today_delivery_data'=>$main_data
            ),
            REST_Controller::HTTP_OK
        );
    }*/

    // dashboards
    /*public function sales_dashboard_get($user_id){

        $date = date('Y-m-d');

        $dashboard = array(
            'today_visits'=>0,
            'today_orders'=>0,
            'today_leads'=>0,
            'images'=>array(
                array(
                    "name"=>'product-edit1.jpg',
                    "url"=>base_url()."files/assets/images/product-edit/product-edit1.jpg"
                ),
                array(
                    "name"=>'product-edit2.jpg',
                    "url"=>base_url()."files/assets/images/product-edit/product-edit2.jpg"
                ),
                array(
                    "name"=>'product-edit3.jpg',
                    "url"=>base_url()."files/assets/images/product-edit/product-edit3.jpg"
                )
            )
        );
        $this->db
            ->select("*")
            ->from('client_visits')
            ->where('created_by', $user_id)
            ->where('date(created_at) = "'.$date.'"', NULL, FALSE)
            ->get();
        $dashboard['today_visits'] = $this->db->affected_rows();

        $this->db
            ->select("*")
            ->from('orders')
            ->where('created_by', $user_id)
            ->where('date(created_at) = "'.$date.'"', NULL, FALSE)
            ->get();

        $dashboard['today_orders'] = $this->db->affected_rows();

        $this->db
            ->select("*")
            ->from('leads')
            ->where('created_by', $user_id)
            ->where('date(created_at) = "'.$date.'"', NULL, FALSE)
            ->get();

        $dashboard['today_leads'] = $this->db->affected_rows();

        $this->response(
            array(
            'status' => TRUE,
            'message' => "Dashboard",
            'data' => $dashboard
            ),
        REST_Controller::HTTP_OK
        );
    }

    public function delivery_dashboard_get($user_id = NULL){
        if(!$user_id){
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => "Please provide user_id.",
                    'today_delivery'=>0
                ),
                REST_Controller::HTTP_OK
            );
        }

        $sql = $this->db->query("SELECT
                    `orders`.*
                FROM `orders`
                WHERE delivery_boy_id = $user_id
                AND expected_delivery_date = CURDATE()
                AND actual_delivery_date IS NULL
                GROUP BY `orders`.`id`
            ");

        $this->response(
            array(
                'status' => TRUE,
                'message' => "Delivery found.",
                'today_delivery'=>$this->db->affected_rows(),
                'images'=>array(
                    array(
                        "name"=>'product-edit1.jpg',
                        "url"=>base_url()."files/assets/images/product-edit/product-edit1.jpg"
                    ),
                    array(
                        "name"=>'product-edit2.jpg',
                        "url"=>base_url()."files/assets/images/product-edit/product-edit2.jpg"
                    ),
                    array(
                        "name"=>'product-edit3.jpg',
                        "url"=>base_url()."files/assets/images/product-edit/product-edit3.jpg"
                    )
                )
            ),
            REST_Controller::HTTP_OK
        );
    }    

    public function follow_up_get($user_id = NULL){
        $result = [];
        if(!$user_id){
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => "Please provide user_id.",
                    'today_delivery'=>0
                ),
                REST_Controller::HTTP_OK
            );
        }

        $result = $this->db->query("SELECT 
                            leads.first_name,
                            leads.last_name,
                            leads.email,
                            leads.phone,
                            lead_visits.lead_id,
                            lead_visits.visit_date,
                            lead_visits.visit_time,
                            lead_visits.visit_type,
                            lead_visits.other_notes
                        FROM `lead_visits`
                        LEFT JOIN `leads` ON `leads`.`id` = `lead_visits`.`lead_id`
                        WHERE `lead_visits`.`created_by` = {$user_id}
                        ")->result_array();
        if(!empty($result)){

            $this->response(
                array(
                    'status' => TRUE,
                    'message' => "Follow up found.",
                    'data' => $result
                ),
                REST_Controller::HTTP_OK
            );
        }else{
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => "Follow up not found.",
                    'data' => $result
                ),
                REST_Controller::HTTP_OK
            );
        }
    }*/
    
    /*public function delivery_boy_orders_get($delivery_boy_id = NULL){
		
		$where = ' WHERE 1 = 1';
        $today = date('Y-m-d');
        
		if(!empty($delivery_boy_id)){
            $where .= ' AND `orders`.`delivery_boy_id` = "'.$delivery_boy_id.'" 
						AND `orders`.`expected_delivery_date` < "'.$today.'"
						AND `orders`.`delivery_id` IS NULL';
        }

        $query = "SELECT 
                    `clients`.`client_name`,
					`orders`.`expected_delivery_date`,
					`orders`.`payable_amount`,
					`orders`.`created_at`
                FROM `orders`
				LEFT JOIN clients ON clients.id = orders.client_id 
                $where
                ";
        $orders = $this->db->query($query)->result_array();

        if(!empty($orders)){

            $this->response(
                array(
                    'status' => TRUE,
                    'message' => "Orders",
                    'data' => $orders
                ),
                REST_Controller::HTTP_OK
            );
        }else{
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => "Orders not found.",
                    'data' => $orders
                ),
                REST_Controller::HTTP_OK
            );
        }
    }*/
    

                                                    /*-------------------------- Updated API ------------------------------*/

                                                    // Local URL    - http://172.16.3.107/mineral_water/index.php/api/apiv1/
                                                    // Live URL     - http://zoopapps.com/neervana/index.php/api/apiv1/

    /*
        Test API Endpoint Path
        @author Rakesh Jangir
    */
    public function test_get(){        
        $this->response("It Works");
    }

                                                                    /*------------- Login -------------*/

    /*
        Login User
        Afffected Table - user_devices
        Used Table -- users, user_devices
    */
    public function login_post() {
        
        // Get the post data
        $email = $this->post('username');
        $password = $this->post('password');
        $device_id = $this->post('fcm');
        
        // Validate the post data
        if(!empty($email) && !empty($password)){
            
            // Check if any user exists with the given credentials
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'email' => $email,
                'password' => $password,
                'status' => 1
            );
            $user = $this->user->getRows($con);
                        
            if($user){

                if(in_array($user['role'],APP_USER_ROLES)) {

                    if(!$user['last_name']){
                        $user['last_name'] = "";
                    }
                    
                    $this->db->delete("user_devices", array("device_id"=>$device_id));
                    $this->db->insert("user_devices", array(
                        "user_id"=>$user['user_id'],
                        "device_id"=>$device_id,
                    ));

                    // remove first created device ids if more than two
                    $sqlDeviceIds = $this->db->query("DELETE from user_devices 
                                                        WHERE id NOT IN(
                                                            SELECT id FROM (
                                                                SELECT 
                                                                    id
                                                                FROM user_devices
                                                                WHERE user_id = {$user['user_id']}
                                                                ORDER BY id DESC LIMIT 2
                                                            ) foo
                                                    ) AND user_id = {$user['user_id']}");

                    // Set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'message' => 'User login successful.',
                        'data' => $user
                    ], REST_Controller::HTTP_OK);
                    
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => "Only " . implode(", ",APP_USER_ROLES) . " are allowed to login.",
                        'data' => new stdClass()
                    ], REST_Controller::HTTP_OK);
                }

            }else{
                // Set the response and exit
                //BAD_REQUEST (400) being the HTTP response code
                $this->response([
                    'status' => FALSE,
                    'message' => 'Wrong username or password.',
                    'data' => new stdClass()
                ], REST_Controller::HTTP_OK);
            }
        }else{
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => "Provide username and password.",
                'data' => array()
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /*
        Logout User
        Afffected Table - user_devices
    */
    public function logout_post(){

        // $user_id = $this->input->post('user_id');
        
        $fcm = $this->input->post('fcm');

        if($fcm!=''){

            if($this->db->where("device_id",$fcm)->delete("user_devices")){
                $this->response([
                    'status' => TRUE,
                    'message' => 'Logout successfull'
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'Logout not successfull',
                ], REST_Controller::HTTP_OK);
            }
        }else{
            // Set the response and exit
            $this->response([
                    'status' => FALSE,
                    'message' => "fcm is required.",
                ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }


                                                                    /*---------- Lead / Visit -----------*/
    
    /*
        Get Leads added by User (Only leads which are not converted to client)
        @author Milan Soin
        @update by Rakesh Jangir
    */
    public function lead_by_user_get($user_id = NULL){

        if($user_id){

            $where = "1=1 AND is_converted = 0 AND is_deleted = 0 AND created_by = {$user_id}";            

            if($leads = $this->db->where($where)->get("leads")->result_array()){

                $this->response(
                    array(
                        'status' => TRUE,
                        'message' => "Leads",
                        'data' => $leads
                    ),
                    REST_Controller::HTTP_OK
                );
            }else{
                $this->response(
                    array(
                        'status' => FALSE,
                        'message' => "Leads not found.",
                        'data' => []
                    ),
                    REST_Controller::HTTP_OK
                );
            }
        }else{
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => "Please provide user_id.",
                    'today_delivery'=>0
                ),
                REST_Controller::HTTP_BAD_REQUEST
            );
        }
    }

    /*
        Add or Update Lead
        @author Rakesh Jangir
        Optionally Visit can also be added by providing Visit Note.
        Affected Tables - leads, lead_visits
    */
    public function add_update_lead_post($lead_id = NULL){

        $company_name = $this->post('company_name');
        $contact_person_name = $this->post('contact_person_name');
        $email = ($this->post('email')) ? $this->post('email') : null;
        $phone_1 = $this->post('phone_1');
        $phone_2 = ($this->post('phone_2')) ? $this->post('phone_2') : null;
        $user_id = $this->post('user_id');

        $visit_note = ($this->post('visit_note')) ? $this->post('visit_note') : NULL;

        if( !empty($company_name) && !empty($contact_person_name) && !empty($phone_1) ){

            $leadArr = array(
                'company_name'=>$company_name,
                'contact_person_name'=>$contact_person_name,
                'email'=>$email,
                'phone_1'=>$phone_1,
                'phone_2'=>$phone_2,
                'notes' => $visit_note,
            );

            // $visitArr = ($visit_note) ? array(
            //     'visit_date'    =>  date('Y-m-d'),
            //     'visit_time'    =>  date('H:i:s'),
            //     'visit_type'    =>  'InPerson',
            //     'visit_notes'   => $visit_note,
            //     'created_at'    =>  date('Y-m-d'),
            //     'created_by'    =>  $user_id
            // ) : array();
            $visitArr = [];

            if($lead_id){
                $leadArr['updated_by'] = $user_id;
            }else{
                $leadArr['created_by'] = $user_id;
            }

            if($this->client->add_update_lead($leadArr, $visitArr,$lead_id)){
                $this->response([
                    'status' => TRUE,
                    'message' => "Inquiry generated successfully.",
                    'data' => array()
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => "Failed to generate Inquiry.",
                    'data' => array()
                ], REST_Controller::HTTP_OK);
            }
        }else{
            $this->response([
                'status' => FALSE,
                'message' => "Company Name, Contact Person Name and Phone are required.",
                'data' => array()
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /*
        Add Visit for Client or Lead
        @author Rakesh Jangir
    */
    public function add_update_visit_post(){

        $type = $this->post('type');  //client or lead
        $id = $this->post('id');      //client or lead id
        $user_id = $this->post('user_id');

        

        if( !empty($type) && !empty($id) && !empty($user_id) ){

            // $visit_notes = ($this->input->post('visit_notes')) ? $this->input->post('visit_notes') : NULL;

            $visit_data = array(
                'visit_date'=> ($this->input->post('visit_date')) ? $this->input->post('visit_date') : NULL,
                'visit_time'=> ($this->input->post('visit_time')) ? $this->input->post('visit_time') : NULL,
                'visit_type'=> ($this->input->post('visit_type')) ? $this->input->post('visit_type') : NULL,
                'opportunity'=> ($this->input->post('opportunity')) ? $this->input->post('opportunity') : NULL,
                'visit_notes'=> ($this->input->post('other_notes')) ? $this->input->post('other_notes') : NULL, //other notes is actuelly visit_notes
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $user_id,
            );

            $insert_status = false;
            if($type == 'client'){
                $visit_data['client_id'] = $id;
                $insert_status = $this->db->insert("client_visits",$visit_data);
            }else{
                $visit_data['lead_id'] = $id;
                $insert_status = $this->db->insert("lead_visits",$visit_data);
            }

            if($insert_status){
            
                $this->response(
                    array(
                        'status' => TRUE,
                        'message' => 'FollowUp created successfully.',
                        'data' => []
                    ),
                    REST_Controller::HTTP_OK
                );

            }else{
                $this->response(
                    array(
                        'status' => FALSE,
                        'message' => "Please try again",
                        'data' => []
                    ),
                    REST_Controller::HTTP_OK
                );
            }
        }else{
            $this->response([
                'status' => FALSE,
                'message' => "Type and Id are required.",
                'data' => array()
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }


                                                                    /*---------- Order /  Scheme -----------*/
    /*
        Get List of applicable Schemes based on order_details
        @author Rakesh Jangir
    */
    public function scheme_by_evaluation_post(){
        
        /*
            {
                "subtotal":5000,
                "order_details":[
                    {
                        "product_id": 1,
                        "quantity":10,
                        "actual_price": 10,
                        "sale_price": 12
                    },
                    {
                        "product_id": 2,
                        "quantity":10,
                        "actual_price": 12,
                        "sale_price": 15
                    }
                ]
            }
        */

        $entityBody = file_get_contents('php://input');

        if(!empty($entityBody)){

            $orders = json_decode($entityBody,true);
            

            if(!empty($orders)){

                if(
                    isset($orders['order_details']) 
                    && isset($orders['subtotal']) && $orders['subtotal']!=''
                ){
                    
                    $order_details = $orders['order_details'];
                    $subtotal = $orders['subtotal'];
                    $order_products = array_column($order_details,'quantity','product_id');

                    $today = date('Y-m-d');
                    $applicable_scheme = [];
                    $all_schemes = $this->db->where("'{$today}' BETWEEN `start_date` AND `end_date`")->get("schemes")->result_array();
                    
                    foreach($all_schemes as $scheme){

                        $description = "";
                        $new_subtotal = $subtotal;

                        if($scheme['gift_mode'] == 'cash_benifit'){
                            if($scheme['discount_mode'] == 'amount'){
                                $description = "Get discount of Rs. {$scheme['discount_value']}";
                                $new_subtotal = $subtotal-$scheme['discount_value'];
                            }else{
                                $description = "Get {$scheme['discount_value']} % discount on order value.";
                                $new_subtotal = $subtotal- ($subtotal*$scheme['discount_value']/100);
                            }
                        }else{
                            if($free_product = $this->db->where("id = {$scheme['free_product_id']}")->get("products")->row_array()){
                                $description = "Get {$scheme['free_product_qty']} {$free_product['product_name']} absolutely free.";
                            }                                        
                        }

                        $new_subtotal = ($new_subtotal < 0) ? 0 : $new_subtotal;

                        if( true ){    //$this->check_in_range($scheme['start_date'],$scheme['end_date'],$today

                            if($scheme['type']=='price_scheme'){

                                if($subtotal >= $scheme['order_value']){

                                    $applicable_scheme[] = array(
                                        'id'             =>  $scheme['id'],
                                        'name'           =>  $scheme['name'],
                                        'description'    =>  $description,
                                        'new_subtotal'   =>  sprintf('%0.2f', $new_subtotal),
                                    );
                                }
                            }else{

                                $scheme_products = $this->db->select("product_id,quantity")->where("scheme_id = {$scheme['id']}")->get("scheme_products")->result_array();

                                if($scheme['match_mode']=='all'){

                                    $applicable = true;
                                    foreach($scheme_products as $sp){
                                        
                                        if(!(array_key_exists($sp['product_id'],$order_products) && $order_products[$sp['product_id']] >= $sp['quantity']) ){
                                            $applicable = false;
                                        }
                                    }

                                    if($applicable){
                                        $applicable_scheme[] = array(
                                            'id'             =>  $scheme['id'],
                                            'name'           =>  $scheme['name'],
                                            'description'    =>  $description,
                                            'new_subtotal'   =>  sprintf('%0.2f', $new_subtotal),
                                        );
                                    }

                                }else{

                                    $applicable = false;
                                    foreach($scheme_products as $sp){
                                        
                                        if(array_key_exists($sp['product_id'],$order_products) && $order_products[$sp['product_id']] >= $sp['quantity']){
                                            $applicable = true;
                                        }
                                    }

                                    if($applicable){
                                        $applicable_scheme[] = array(
                                            'id'             =>  $scheme['id'],
                                            'name'           =>  $scheme['name'],
                                            'description'    =>  $description,
                                            'new_subtotal'   =>  sprintf('%0.2f', $new_subtotal),
                                        );
                                    }

                                }

                            }
                        }
                    }
                    
                    if($applicable_scheme){

                        $scheme_count = count($applicable_scheme);
                        $msg = "{$scheme_count} scheme is applicable.";
                        
                        if($scheme_count > 1){
                            $msg = "{$scheme_count} schemes are applicable.";
                        }

                        $this->response([
                            'status' => TRUE,
                            'message' => $msg,
                            'data'    => $applicable_scheme,
                        ], REST_Controller::HTTP_OK);
                    }else{
                        $this->response([
                            'status' => FALSE,
                            'message' => 'No scheme is applicable.',
                            'data'    => [],
                        ], REST_Controller::HTTP_OK);
                    }

                }else{
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Please provide subtotal and order_details.',
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'Invalid json request.',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'Please provide json body.',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Check Credit limit of client
     * @author Rakesh Jangir
     */
    public function get_credit_limit($id)   //$client_id
    {
        $availableCreditLimit = $this->db->query("SELECT
                                                    (
                                                        IFNULL(clients.credit_limit,0)
                                                        + IFNULL(clients.credit_balance,0)
                                                        - IFNULL(SUM(
                                                            (CASE
                                                                WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                                                                    WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                                                                    ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                                                                END)
                                                                ELSE orders.payable_amount
                                                            END) 
                                                        ),0)
                                                        + SUM(IFNULL(paid.paid_amount,0))
                                                    )AS `available_credit_limit`
                                                FROM `clients`
                                                LEFT JOIN `orders` on `orders`.`client_id` = `clients`.`id` AND (orders.order_status <> 'Rejected') AND (orders.order_status <> 'Pending')
                                                LEFT JOIN `schemes` ON `schemes`.`id` = `orders`.`scheme_id`
                                                LEFT JOIN (
                                                    SELECT
                                                        payment_details.order_id,
                                                        SUM(payment_details.total_payment) AS paid_amount
                                                    FROM payment_details
                                                    GROUP BY payment_details.order_id
                                                ) AS paid ON paid.order_id = orders.id
                                                WHERE `clients`.`id` = {$id}
                                                GROUP BY `clients`.`id`")
                                            ->row_array()['available_credit_limit'];
        return $availableCreditLimit;
    }

     /*   Get List of applicable Schemes based on order_details
        @author Milan Soni
        @update by Rakesh Jangir - 21-11-2019
    */
    
    public function make_order_post(){

        $entityBody = file_get_contents('php://input');
        // var_dump($entityBody);die;
        // $h = fopen("debug.txt","a+");
        // fwrite($h,json_encode($entityBody) . PHP_EOL);
        // fclose($h);
        
        /*
            {                
                "user_id":1,
                "type":"client",
                "id":1,
                "scheme_id":1,
                "subtotal":300,
                "delivery_address_id":1,
                "expected_delivery_date":"2019-12-01",
                "priority":"High",
                "payment_mode":"Cash",
                "payment_schedule_date":"2019-12-15",
                "payment_schedule_time":"18:00:00",
                "contact_person_name_2":"Mr Unknown",
                "contact_person_2_phone_1":"9999999999",
                "contact_person_2_email":"test@test.com",
                "state_id":"2",
                "city_id":"3",
                "city_id":"3",
                "zip_code_id":"1",
                "gst_no":"GPC1134",
                "order_details":[
                    {
                        "product_id": 1,
                        "quantity":10,
                        "actual_price": 10,
                        "sale_price": 12
                    },
                    {
                        "product_id": 2,
                        "quantity":10,
                        "actual_price": 12,
                        "sale_price": 15
                    }
                ]
            }
        */

        if(!empty($entityBody)){

            $orders = json_decode($entityBody,true);
            
            if(!empty($orders)){

                if(
                    isset($orders['id']) && $orders['id']!=''
                    && isset($orders['type']) && $orders['type']!=''
                    && isset($orders['user_id']) && $orders['user_id']!=''
                    && isset($orders['order_details'])
                    && isset($orders['subtotal']) && $orders['subtotal']!=''
                ){

                    $user_id    =  $orders['user_id'];                    
                    $id         =   $orders['id'];    //lead or client id
                    $type       =   $orders['type'];    // type - lead/client
                    $subtotal   =   $orders['subtotal'];
                    $order_details  =   $orders['order_details'];
                    
                    $arrOrder   =   []; // order table array data
                    $arrClient  =   []; // clients table array data
                    $arrOrderItems=   []; // order products

                    if($type=='client'){

                        //Get Credit Limit for this client.                            
                        $availableCreditLimit = $this->get_credit_limit($id);

                        if(in_array($orders['payment_mode'],['Credit','Bank Transfer','Cheque']) && $subtotal > $availableCreditLimit){
                            
                            $this->response([
                                'status' => FALSE,
                                'message' => 'Available credit limit exceeded. Please pay your outstanding first.',
                            ], REST_Controller::HTTP_OK);
                            die;
                        }

                    }else{

                        $lead = $this->db->get_where("leads",["id"=>$id])->row_array();
                        
                        $arrClient = array(
                            'client_name'       =>  (isset($orders['company_name']) && $orders['company_name']!='') ? $orders['company_name'] : $lead['company_name'],
                            'credit_limit'      =>  $this->system_setting['default_credit_limit'],
                            'lead_id'           =>  $id,
                            'contact_person_name_1'     =>  $lead['contact_person_name'],
                            'contact_person_1_phone_1'  =>  $lead['phone_1'],
                            'contact_person_1_email'    =>  $lead['email'],

                            'contact_person_name_2'     =>  (isset($orders['contact_person_name_2']) && $orders['contact_person_name_2']!='') ? $orders['contact_person_name_2'] : null,
                            'contact_person_2_phone_1'  =>  (isset($orders['contact_person_2_phone_1']) && $orders['contact_person_2_phone_1']!='') ? $orders['contact_person_2_phone_1'] : null,
                            'contact_person_2_email'    =>  (isset($orders['contact_person_2_email']) && $orders['contact_person_2_email']!='') ? $orders['contact_person_2_email'] : null,
                            'gst_no'                    =>  (isset($orders['gst_no']) && $orders['gst_no']!='') ? $orders['gst_no'] : null,

                            'state_id'                  =>  (isset($orders['state_id']) && $orders['state_id']!='') ? $orders['state_id'] : null,
                            'city_id'                   =>  (isset($orders['city_id']) && $orders['city_id']!='') ? $orders['city_id'] : null,
                            'zip_code_id'               =>  (isset($orders['zip_code_id']) && $orders['zip_code_id']!='') ? $orders['zip_code_id'] : null,
                            
                            'created_at'                =>  date('Y-m-d H:i:s'),
                            'created_by'                =>  $user_id,
                        );
                        //TODO update client_name and contact person 1 details if provided in app
                    }

                    $need_admin_approval = false;

                    foreach($order_details as $detail){

                        if(!empty($detail['product_id']) && !empty($detail['quantity']) && !empty($detail['sale_price'])){
                            
                            // order items array data
                            $arrOrderItems[] = array(
                                'product_id'    =>  $detail['product_id'],
                                'quantity'      =>  $detail['quantity'],
                                'actual_price'  =>  $detail['actual_price'],
                                'effective_price'=> $detail['sale_price'],
                                'subtotal'      =>  ($detail['sale_price'] * $detail['quantity']),
                                'created_at'    =>  date('Y-m-d H:i:s'),
                                'created_by'    =>  $user_id,
                            );

                            if($detail['actual_price'] != $detail['sale_price']){
                                $need_admin_approval = true;
                            }

                        }else{
                            $this->response([
                                'status' => FALSE,
                                'message' => 'Provide product_id, quantity and sale_price.',
                            ], REST_Controller::HTTP_BAD_REQUEST);
                            die;
                        }
                    }

                    $arrOrder = array(
                        'client_id'     =>  $id,
                        'scheme_id'     =>  (isset($orders['scheme_id']) && $orders['scheme_id']!=0) ? $orders['scheme_id'] : null,
                        'payable_amount'=>  $subtotal,
                        'delivery_address_id'   =>  $orders['delivery_address_id'],
                        'expected_delivery_date'=>  $orders['expected_delivery_date'],
                        'priority'      =>  $orders['priority'],
                        'payment_mode'  =>  $orders['payment_mode'],
                        'payment_schedule_date' =>  $orders['payment_schedule_date'],
                        'payment_schedule_time' =>  $orders['payment_schedule_time'],
                        'need_admin_approval'   =>  $need_admin_approval,
                        'order_status'          =>  ($need_admin_approval) ? 'Approval Required' : 'Pending',
                        'created_at'    =>  date('Y-m-d H:i:s'),
                        'created_by'    =>  $user_id,
                    );

                    if($orderId = $this->order->add_order($arrOrder, $arrOrderItems,$arrClient)){
                        $this->response([
                            'status' => TRUE,
                            'message' => 'Order placed successfully.',
                        ], REST_Controller::HTTP_OK);
                    }else{
                        $this->response([
                            'status' => FALSE,
                            'message' => 'Failed to place order.',
                        ], REST_Controller::HTTP_OK);
                    }
                }else{
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Please provide type, client/lead id, user_id, subtotal and order_details.',
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'Invalid json request.',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'Please provide json body.',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /*
        Get Order List, Optionally can be filtered based on salesman who placed the order.
        @author Rakesh Jangir
    */
    public function my_order_list_post(){

        $user_id= $this->input->post('user_id');
        $start_date= $this->input->post('start_date');
        $end_date= $this->input->post('end_date');

        $where = " 1=1";
        $where .= ($user_id) ? " AND `orders`.`created_by` = {$user_id}" : "";

        if($start_date && $end_date){
            $where .= " AND ( date(`orders`.`created_at`) BETWEEN '$start_date' AND '{$end_date}' )";
        }else if($start_date){
            $where .= " AND date(`orders`.`created_at`) >= '{$start_date}'";
        }else if($end_date){
            $where .= " AND date(`orders`.`created_at`) <= '{$end_date}'";
        }else{
            // By default In my Order list, current date orders should come. Date is must required in order list.
            $where .= " AND date(`orders`.`created_at`) = CURDATE()";
        }

        $query = "SELECT
                    `clients`.`client_name`,
                    `clients`.`contact_person_name_1`,
                    `clients`.`contact_person_1_phone_1`,
                    `clients`.`contact_person_1_email`,
                    `orders`.`payable_amount`,
                    `orders`.`expected_delivery_date`,
                    DATE_FORMAT(`orders`.`created_at`,'%Y-%m-%d') AS `created_at`,
                    `orders`.`priority`,	
                    `orders`.`order_status`,
                    SUM(`order_items`.`quantity`) AS `product_count`
                FROM `orders`
                LEFT JOIN `clients` ON `clients`.`id` = `orders`.`client_id`
                LEFT JOIN `order_items` ON `order_items`.`order_id` = `orders`.`id`
                WHERE {$where}
                GROUP BY `orders`.`id`
                ORDER BY `orders`.`created_at` DESC";
        
        if($orders = $this->db->query($query)->result_array()){
            $this->response([
                'status' => TRUE,
                'message' => 'Data found.',
                'data' => $orders
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSe,
                'message' => 'Data not found.',
                'data' => []
            ], REST_Controller::HTTP_OK);
        }        
    }

    /*
        Get Paid, Partial, Pending Invoice counts for each client.
        For Salesman -  Result includes all orders, created by this salesman.
        For Delivery Boy - Result includes all orders, delivered by this delivery boy.
        @author Rakesh Jangir
    */
    public function invoices_post(){

        $user_id = $this->input->post("user_id");
        $user = $this->db->select("role_id")->get_where("users","id={$user_id}")->row_array();
        $role_id = $user['role_id'];    //1-Admin, 2-Sales, 3-Delivery Boy ,4-Loader/Driver

        $where = "";
        if($role_id == 2){
            $query = "SELECT
                            clients.id AS client_id,
                            clients.client_name,
                            clients.contact_person_name_1,
                            clients.contact_person_1_phone_1,
                            clients.contact_person_1_email,
                            IFNULL(sub_pending.pending,0) AS pending_count,
                            IFNULL(sub_partial.partial,0) AS partial_count,
                            IFNULL(sub_paid.paid,0) AS paid_count
                        FROM clients
                        LEFT JOIN client_delivery_addresses ON client_delivery_addresses.client_id = clients.id
                        LEFT JOIN (
                            SELECT
                                COUNT(*) AS pending,
                                client_id,
                                payment_status,
                                created_by
                            FROM orders
                            WHERE orders.order_status ='Delivered'
                            AND orders.payment_status = 'Pending'
                            GROUP BY client_id
                        ) sub_pending ON sub_pending.client_id = clients.id
                        LEFT JOIN (
                            SELECT
                                COUNT(*) AS paid,
                                client_id,
                                payment_status,
                                created_by
                            FROM orders
                            WHERE orders.order_status  = 'Delivered'
                            AND orders.payment_status = 'Paid'
                            GROUP BY client_id
                        ) sub_paid ON sub_paid.client_id = clients.id
                        LEFT JOIN (
                            SELECT
                                COUNT(*) AS partial,
                                client_id,
                                payment_status,
                                created_by
                            FROM orders
                            WHERE orders.order_status  = 'Delivered'
                            AND orders.payment_status = 'Partial'
                            GROUP BY client_id
                        ) sub_partial ON sub_partial.client_id = clients.id
                        WHERE 
                        (
                            client_delivery_addresses.zip_code_id IN
                            (
                                SELECT 
                                    zipcode_id
                                FROM 
                                (SELECT
                                    zip_codes.id as zipcode_id
                                FROM user_zip_code_groups
                                LEFT JOIN zip_code_groups ON zip_code_groups.id = user_zip_code_groups.zip_code_group_id
                                LEFT JOIN group_to_zip_code ON group_to_zip_code.zip_code_group_id = zip_code_groups.id
                                LEFT JOIN zip_codes ON zip_codes.id = group_to_zip_code.zip_code_id
                                WHERE user_zip_code_groups.user_id = {$user_id}
                                UNION
                                SELECT
                                    zip_codes.id as zipcode_id
                                FROM user_zip_codes
                                LEFT JOIN zip_codes ON zip_codes.id = user_zip_codes.zip_code_id
                                WHERE user_zip_codes.user_id = {$user_id}
                                ) tmp_zip
                                GROUP BY zip_code
                            )
                            OR
                            (
                                sub_pending.created_by = {$user_id} OR sub_paid.created_by = {$user_id} OR sub_partial.created_by = {$user_id}
                            )
                        )
                        GROUP BY clients.id
                        HAVING  ( pending_count > 0 OR partial_count > 0 OR paid_count > 0 )";
                        
        }else if($role_id == 3 || $role_id == 4){    
            $query = "SELECT
                        clients.id AS client_id,
                        clients.client_name,
                        clients.contact_person_name_1,
                        clients.contact_person_1_phone_1,
                        clients.contact_person_1_email,                        
                        IFNULL(sub_pending.pending,0) AS pending_count,
                        IFNULL(sub_partial.partial,0) AS partial_count,
                        IFNULL(sub_paid.paid,0) AS paid_count
                    FROM clients
                    LEFT JOIN client_delivery_addresses ON client_delivery_addresses.client_id = clients.id
                    LEFT JOIN (
                        SELECT
                            COUNT(*) AS pending,
                            client_id,
                            payment_status,
                            orders.created_by
                        FROM orders
                        LEFT JOIN clients on clients.id = orders.client_id
                        WHERE orders.order_status ='Delivered'
                        AND orders.payment_status = 'Pending'
                        AND `orders`.`client_id` IN (
                            SELECT
                                DISTINCT(`orders`.`client_id`) AS `client_id`
                            FROM `delivery_config_orders`
                            left join orders on orders.id = delivery_config_orders.order_id
                            LEFT JOIN `delivery_config` ON `delivery_config`.`id` = `delivery_config_orders`.`delivery_config_id`
                            WHERE `delivery_config`.`delivery_boy_id` = {$user_id} OR `delivery_config`.`driver_id` = {$user_id}
                        )
                        GROUP BY client_id
                    ) sub_pending ON sub_pending.client_id = clients.id
                    LEFT JOIN (
                        SELECT
                            COUNT(*) AS paid,
                            client_id,
                            payment_status,
                            orders.created_by
                        FROM orders
                        LEFT JOIN clients on clients.id = orders.client_id
                        WHERE orders.order_status ='Delivered'
                        AND orders.payment_status = 'Paid'
                        AND `orders`.`client_id` IN (
                            SELECT
                                DISTINCT(`orders`.`client_id`) AS `client_id`
                            FROM `delivery_config_orders`
                            left join orders on orders.id = delivery_config_orders.order_id
                            LEFT JOIN `delivery_config` ON `delivery_config`.`id` = `delivery_config_orders`.`delivery_config_id`
                            WHERE `delivery_config`.`delivery_boy_id` = {$user_id} OR `delivery_config`.`driver_id` = {$user_id}
                        )
                        GROUP BY client_id
                    ) sub_paid ON sub_paid.client_id = clients.id
                    LEFT JOIN (
                        SELECT
                            COUNT(*) AS partial,
                            client_id,
                            payment_status,
                            orders.created_by
                        FROM orders
                        LEFT JOIN clients on clients.id = orders.client_id
                        WHERE orders.order_status ='Delivered'
                        AND orders.payment_status = 'Partial'
                        AND `orders`.`client_id` IN (
                            SELECT
                                DISTINCT(`orders`.`client_id`) AS `client_id`
                            FROM `delivery_config_orders`
                            left join orders on orders.id = delivery_config_orders.order_id
                            LEFT JOIN `delivery_config` ON `delivery_config`.`id` = `delivery_config_orders`.`delivery_config_id`
                            WHERE `delivery_config`.`delivery_boy_id` = {$user_id} OR `delivery_config`.`driver_id` = {$user_id}
                        )
                        GROUP BY client_id
                    ) sub_partial ON sub_partial.client_id = clients.id
                    GROUP BY clients.id
                    HAVING  ( pending_count > 0 OR partial_count > 0 OR paid_count > 0 )";
        }

        if($user_id){
            
            if($data = $this->db->query($query)->result_array()){
                $this->response([
                    'status' => TRUE,
                    'message' => 'Data found.',
                    'data' => $data
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'Data not found.',
                    'data' => []
                ], REST_Controller::HTTP_OK);
            }
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'user_id is required',
                'data' => []
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /*
        Get list of invoices including order items for specific client
        @author Rakesh Jangir
    */
    public function invoice_details_post(){

        $client_id = $this->input->post('client_id');
        $invoice_url = $this->baseUrl."api/apiv1/print_invoice/";

        if($client_id){
                $query = "SELECT
                        `clients`.`client_name`,
                        `clients`.`contact_person_name_1`,
                        `clients`.`contact_person_1_phone_1`,
                        `clients`.`contact_person_1_email`,
                        `orders`.`id` AS `order_id`,
                        `orders`.`payable_amount`,
                        `orders`.`expected_delivery_date`,
                        `orders`.`priority`,	
                        `orders`.`payment_status`,
                        CONCAT('{$invoice_url}',`orders`.`id`) AS `pdf_link`,
                        SUM(`order_items`.`quantity`) AS `product_count`
                    FROM `orders`
                    LEFT JOIN `clients` ON `clients`.`id` = `orders`.`client_id`
                    LEFT JOIN `order_items` ON `order_items`.`order_id` = `orders`.`id`
                    WHERE `clients`.`id` = {$client_id}
                    AND `orders`.`order_status` = 'Delivered'
                    GROUP BY `orders`.`id`";
            
            if($orders = $this->db->query($query)->result_array()){

                /*
                foreach($orders as $k=>$order){
                    $orders[$k]['order_items'] = $this->db
                    ->select("
                                products.product_name,
                                order_items.quantity,
                                order_items.effective_price AS price,
                                order_items.subtotal AS total
                            ")
                    ->where("order_id = {$order['order_id']}")
                    ->from("order_items")
                    ->join("products","products.id = order_items.product_id","left")
                    ->get()
                    ->result_array();
                }*/

                $this->response([
                    'status' => TRUE,
                    'message' => 'Data found.',
                    'data' => $orders
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'Data not found.',
                    'data' => []
                ], REST_Controller::HTTP_OK);
            } 
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'client_id is required',
                'data' => []
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

                                                                    /*---------- Delivery -----------*/
    
    /*
        Get Today Deliveries by Delivery Boy
        @author Rakesh Jangir
    */
    public function today_delivery_get($user_id = NULL){

        if($user_id){

            $role_id = $this->db->select("role_id")->get_where("users","id = {$user_id}")->row_array()['role_id'];

            $query = "SELECT
                    `clients`.`client_name`,
                    `clients`.`contact_person_name_1` AS `contact_person`,
                    `clients`.`contact_person_1_phone_1` AS `client_contact`,
                    `clients`.`contact_person_1_email` AS `client_email`,
                    `client_delivery_addresses`.`title`,
                    `client_delivery_addresses`.`address`,
                    `zip_codes`.`zip_code`,
                    `orders`.`priority`,
                    (CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                            WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                            ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                        END)
                        ELSE orders.payable_amount
                    END) AS `payable_amount`,
                    date(`delivery`.`expected_delivey_datetime`) AS `expected_delivery_date`,
                    `orders`.`order_status`,
                    `delivery_config_orders`.`id` AS `dco_id`,
                    (CASE
                        WHEN {$role_id} = 3 THEN TRUE
                        ELSE (CASE
                            WHEN `delivery_config`.`delivery_boy_id` IS NULL THEN TRUE
                            ELSE FALSE
                        END)
                    END) AS `show_full_details`,
                    `orders`.`id` AS `order_id`,
                    `schemes`.`id` AS `scheme_id`,
                    0 AS `manage_stock_needed`,
                    0 AS `inverntory_existing_quantity`,
                    0 AS `inverntory_product_id`,
                    '' AS `inverntory_product_name`
                FROM `delivery`
                LEFT JOIN `delivery_config` ON `delivery_config`.`delivery_id` = `delivery`.`id`
                LEFT JOIN `delivery_config_orders` ON `delivery_config_orders`.`delivery_config_id` = `delivery_config`.`id`                
                LEFT JOIN `orders` ON `orders`.`id` = `delivery_config_orders`.`order_id`
                LEFT JOIN `schemes` ON `schemes`.`id` = `orders`.`scheme_id`
                LEFT JOIN `clients` ON `clients`.`id` = `orders`.`client_id`
                LEFT JOIN `client_delivery_addresses` ON `client_delivery_addresses`.`id` = `orders`.`delivery_address_id`
                LEFT JOIN `zip_codes` ON `zip_codes`.`id` = `client_delivery_addresses`.`zip_code_id`
                WHERE (`delivery_config`.`delivery_boy_id` = {$user_id} OR `delivery_config`.`driver_id` = {$user_id})
                AND `orders`.`order_status` <> 'Delivered'
                AND date(`delivery`.`expected_delivey_datetime`) = CURDATE()";

            if($deliveries = $this->db->query($query)->result_array()){

                
                foreach($deliveries as $k=>$delivery){

                    if($delivery['scheme_id']){

                        $products = $this->db->query("SELECT
                                                    products.product_name AS product,
                                                    order_items.quantity,
                                                    order_items.effective_price AS price,
                                                    order_items.subtotal AS total
                                                FROM order_items
                                                LEFT JOIN products ON products.id = order_items.product_id
                                                WHERE order_items.order_id = {$delivery['order_id']}
                                                
                                                UNION

                                                SELECT
                                                    `products`.`product_name` AS `product`,
                                                    `schemes`.`free_product_qty` AS `quantity`,
                                                    0 AS `price`,
                                                    0 AS `total`
                                                FROM `schemes`
                                                LEFT JOIN `products` ON `products`.`id` = `schemes`.`free_product_id`
                                                WHERE `schemes`.`gift_mode` = 'free_product'
                                                AND `schemes`.`id` = {$delivery['scheme_id']}")
                                        ->result_array();
                    }else{
                        $products = $this->db->query("SELECT
                                                    products.product_name AS product,
                                                    order_items.quantity,
                                                    order_items.effective_price AS price,
                                                    order_items.subtotal AS total
                                                FROM order_items
                                                LEFT JOIN products ON products.id = order_items.product_id
                                                WHERE order_items.order_id = {$delivery['order_id']}")
                                        ->result_array();
                    }
                    
                    
                    $deliveries[$k]['products'] = $products;

                    $existing_inv = $this->db->query("SELECT                                                    
                                                        order_items.product_id,
                                                        products.product_name,
                                                        (
                                                            IFNULL(client_product_inventory.existing_quentity,0) +
                                                            IFNULL(client_product_inventory.new_delivered,0) -
                                                            IFNULL(client_product_inventory.empty_collected,0)
                                                        ) AS existing_quentity
                                                    FROM orders                                                                
                                                    LEFT JOIN order_items ON order_items.order_id = orders.id
                                                    LEFT JOIN products ON products.id = order_items.product_id
                                                    LEFT JOIN client_product_inventory ON client_product_inventory.product_id = products.id 
                                                    AND client_product_inventory.client_id = orders.client_id 
                                                    WHERE order_items.order_id = {$delivery['order_id']} 
                                                    AND products.manage_stock_needed=1
                                                    ORDER BY client_product_inventory.id DESC
                                                    LIMIT 1")
                                            ->row_array();                    
                    
                    if($existing_inv){                        
                        $deliveries[$k]['inverntory_existing_quantity'] = $existing_inv['existing_quentity'];
                        $deliveries[$k]['inverntory_product_id'] = $existing_inv['product_id'];
                        $deliveries[$k]['inverntory_product_name'] = $existing_inv['product_name'];
                        $deliveries[$k]['manage_stock_needed'] = 1;
                    }

                }

                $this->response(
                    array(
                        'status' => TRUE,
                        'message' => "Delivery found.",
                        'today_delivery'=>count($deliveries),
                        'today_delivery_data'=>$deliveries
                    ),REST_Controller::HTTP_OK
                );
            }else{
                $this->response(
                    array(
                        'status' => FALSE,
                        'message' => "Delivery not found.",
                        'today_delivery'=>0,
                        'today_delivery_data'=>[]
                    ),REST_Controller::HTTP_OK
                );
            }

        }else{
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => "Please provide user_id.",
                    'today_delivery'=>0
                ),
                REST_Controller::HTTP_BAD_REQUEST
            );
        }        
    }
    
    /*
        Get List of delivery addresses based on client_id
        @author Rakesh Jangir
    */
    public function deliver_order_post(){
        
        // $h = fopen("debug.txt","a+");
        // fwrite($h,json_encode($_POST) . PHP_EOL);
        // fclose($h);

        $allowed_mime_type_arr = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');

        $user_id = $this->input->post('user_id');

        $dco_id = $this->input->post('dco_id'); //delivery_config_orders        
        $payment_mode = ($this->input->post('payment_mode')) ? trim($this->input->post('payment_mode')) : null;        
        $amount = $this->input->post('amount');        
        $notes = $this->input->post('notes');

        $manage_stock_needed = $this->input->post('manage_stock_needed');
        $existing_quentity = $this->input->post('existing_quentity');
        $new_delivered = $this->input->post('new_delivered');
        $empty_collected = $this->input->post('empty_collected');
        $product_id = $this->input->post('inverntory_product_id');
       

        if($user_id!='' && $dco_id!='' && $payment_mode!=''  && $manage_stock_needed!=''){

            //Check for stock
            if($manage_stock_needed==1 && ($existing_quentity=='' || $new_delivered=='' || $empty_collected=='' || $product_id=='' )){
                $this->response([
                    'status' => FALSE,
                    'message' => 'existing_quentity, new_delivered, empty_collected, product_id are required'
                ], REST_Controller::HTTP_BAD_REQUEST);
                die;
            }

            // Delivery Config Orders Data
            $dco_data = $this->db->select("
                                        delivery_config_orders.delivery_id,
                                        delivery_config_orders.order_id,
                                        delivery_config_orders.delivery_config_id,
                                        delivery.warehouse,
                                        orders.client_id")
                                ->join("delivery_config","delivery_config_orders.delivery_config_id = delivery_config.id","left")
                                ->join("delivery","delivery_config.delivery_id = delivery.id","left")
                                ->join("orders","orders.id = delivery_config_orders.order_id","left")
                                ->get_where("delivery_config_orders","delivery_config_orders.id = {$dco_id}")
                                ->row_array();

            //Get order payable amount and client_id
            $result = $this->db->query("SELECT 
                                            orders.client_id,
                                            (CASE
                                                WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                                                    WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                                                    ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                                                END)
                                                ELSE orders.payable_amount
                                            END) AS `effective_price`                     
                                        FROM delivery_config_orders
                                        LEFT JOIN orders ON orders.id = delivery_config_orders.order_id
                                        LEFT JOIN schemes ON schemes.id = orders.scheme_id
                                        WHERE `delivery_config_orders`.`id` = {$dco_id}
                                        GROUP BY `orders`.`id`")->row_array();
            $client_id = $result['client_id'];
            
            if($dco_data) {

                // Check credit limit for client if payment mode is Credit.
                if($payment_mode == "Credit") {
                    
                    $effective_price = $result['effective_price'];
                    
                    if($amount) {
                        if($amount >= $effective_price) {
                            $this->response([
                                'status' => FALSE,
                                'message' => "You have enough credit available than order amount.",
                            ], REST_Controller::HTTP_OK);
                            die;
                        } else {
                            $effective_price = $result['effective_price'] - $amount;
                        }
                    }

                    //Get Credit Limit for this client.                            
                    $availableCreditLimit = $this->get_credit_limit($client_id);                        

                    if($effective_price > $availableCreditLimit) {
                        
                        $this->response([
                            'status' => FALSE,
                            'message' => 'Available credit limit exceeded. Please pay your outstanding.',
                        ], REST_Controller::HTTP_OK);
                        die;
                    }
                }

                $delivery_data = array(
                    'payment_mode'  =>  $payment_mode,
                    'amount'        =>  $amount,
                    'notes'         =>  $notes,
                    'signature_file'=>  null,
                    'delivery_datetime'=>  date('Y-m-d H:i:s'),
                    'updated_at'    =>  date('Y-m-d'),
                    'updated_by'    =>  $user_id,
                );

                if(isset($_FILES['signature']['name']) && $_FILES['signature']['error']==0){

                    $mime = $_FILES['signature']['type'];

                    if(in_array($mime, $allowed_mime_type_arr)){

                        $config = array(
                            'upload_path'   =>   $this->client_signature_path,
                            'allowed_types' =>   'gif|jpg|png',
                        );

                        $this->load->library('upload', $config);

                        if ($this->upload->do_upload('signature')) {
                            
                            $image_data = $this->upload->data();
                            
                            $delivery_data['signature_file'] = $image_data['file_name'];

                        }else{

                            $error = $this->upload->display_errors('','');                        

                            $this->response(
                                array(
                                    'status' => FALSE,
                                    'message' => $error
                                ),
                                REST_Controller::HTTP_BAD_REQUEST
                            );
                            die;
                        }
                    }else{
                        $this->response(
                            array(
                                'status' => FALSE,
                                'message' => "Only image files are allowed as Signature."
                            ),
                            REST_Controller::HTTP_BAD_REQUEST
                        );
                        die;
                    }
                        
                }

                $this->db->trans_start();

                $this->db->where("id = {$dco_id}")->update("delivery_config_orders",$delivery_data);
            
                if($order_items = $this->db->select("product_id,quantity")->where("order_id",$dco_data['order_id'])->get("order_items")->result_array()){
                    $inward_data = array(
                        'warehouse_id'  =>  $dco_data['warehouse'],
                        'date'  =>  date('Y-m-d'),
                        'type'  =>  'Outward',
                        'created_at' => date('Y-m-d'),
                        'created_by' => $user_id
                    );

                    $inward_data_array = array_map(function($arr) use($inward_data){
                        return array_merge($inward_data,$arr);
                    },$order_items);

                    $this->db->insert_batch("inward_outword",$inward_data_array);

                }                
                
                $order_data = array(
                    'actual_delivery_date'  =>  date('Y-m-d'),
                    'order_status'          =>  'Delivered',
                    'updated_at'            =>  date('Y-m-d'),
                    'updated_by'            =>  $user_id,
                );
                
                $this->db->where("id = {$dco_data['order_id']}")->update("orders",$order_data);

                //Update only when there is no delivery order pending, check sideeffects.
                $if_any_delivered_pending_qry = "SELECT
                                                count(*) AS `pending_count`
                                            FROM delivery_config_orders
                                            WHERE delivery_config_orders.delivery_config_id = {$dco_data['delivery_config_id']}
                                            AND delivery_config_orders.delivery_datetime IS NULL";
                
                $if_any_delivered_pending = $this->db->query($if_any_delivered_pending_qry)->row_array();
                
                // log_message('error',"Order_model".__LINE__.$this->db->last_query()." Pending: ".$if_any_delivered_pending['pending_count']);
                
                if($if_any_delivered_pending['pending_count'] == 0){
                    
                    $delivery_data = array(
                        'actual_delivey_datetime'  =>  date('Y-m-d H:i:s'),
                        'updated_at'    =>  date('Y-m-d'),
                        'updated_by'    =>  $user_id,
                    );
                    $this->db->where("id = {$dco_data['delivery_id']}")->update("delivery",$delivery_data);
                }

                if($manage_stock_needed==1){
                    $this->db->insert("client_product_inventory",array(
                        'dco_id'            =>  $dco_id,
                        'client_id'         =>  $dco_data['client_id'],
                        'product_id'        =>  $product_id,
                        'existing_quentity' =>  $existing_quentity,
                        'new_delivered'     =>  $new_delivered,
                        'empty_collected'   =>  $empty_collected,
                        'created_at'        =>  date('Y-m-d'),
                        'created_by'        =>  $user_id,
                    ));
                }
                
                // If payment mode is Cash or G-Pay , Payment posting will be done automatically.
                if(in_array($payment_mode, ["Cash","G-Pay"]) && $amount) {  //paid_amount

                    $payments = array();
                    $paid_amount = $amount;

                    // Get List of pending payment invoices.
                    $pending_invoice_list = $this->order->get_invoice($client_id);
                    
                    $client = $this->db->where("id",$client_id)->get("clients")->row_array();
                    $original_credit_balance = $credit_balance = ($client['credit_balance']) ? $client['credit_balance'] : 0;

                    foreach($pending_invoice_list as $k=>$invoice) {
                        
                        $payable_amount = sprintf('%0.2f', $invoice['effective_payment']);
                        $amount_to_be_paid = sprintf('%0.2f', $invoice['effective_payment'] - $invoice['paid_amount']);

                        $payments_child =  array(
                            'order_id'  =>  $invoice['id'],
                            'outstanding_amount' => $amount_to_be_paid,
                            'amount_used'   => 0,
                            'credit_used' => 0,
                        );

                        if($credit_balance>0){

                            if($credit_balance >= $amount_to_be_paid){
                                $payments_child['credit_used'] = $amount_to_be_paid;
                                $credit_balance = sprintf('%0.2f', $credit_balance - $amount_to_be_paid);
                                $amount_to_be_paid = 0;
                            }else{
                                $payments_child['credit_used'] = $credit_balance;
                                $amount_to_be_paid = sprintf('%0.2f', $amount_to_be_paid - $credit_balance);
                                $credit_balance =0;
                            }
                        }

                        if($amount_to_be_paid>0){

                            if($paid_amount > 0){

                                if($paid_amount >= $amount_to_be_paid){
                                    $payments_child['amount_used'] = $amount_to_be_paid;
                                    $paid_amount = sprintf('%0.2f', $paid_amount - $amount_to_be_paid);
                                }else{
                                    $payments_child['amount_used'] = $paid_amount;
                                    $paid_amount =0;
                                }
                            }else{                                
                                $payments_child['amount_used'] = 0;
                            }
                        }

                        $payments[] = $payments_child;
                    }

                    if($paid_amount>0 || $credit_balance>0){
                        $credit_balance =  sprintf('%0.2f', $paid_amount+$credit_balance);
                    }else{
                        $credit_balance = 0;
                    }
            
                    // echo "Credit Balance: {$credit_balance}<br/>";
                    // echo "<pre>";print_r($payments);die;
                    
                    $paymnent_data = array(
                        'payment_date'  =>  date('Y-m-d'),
                        'client_id'  =>  $client_id,
                        'payment_mode'  =>  $payment_mode,
                        'check_no'  =>  null,
                        'check_date'  =>  null,
                        'transection_no'  =>  null,
                        'paid_amount'  =>  $amount,
                        'previous_credit_balance'  =>  $original_credit_balance,
                        'new_credit_balance'  =>  $credit_balance,
                        'created_at'    =>  date('Y-m-d H:i:s'),
                        'created_by'    =>  $user_id,
                    );

                    $order_status_update = [];

                    if($this->db->insert("payments",$paymnent_data)){

                        $payment_id = $this->db->insert_id();
        
                        $total_credit_used = 0;

                        foreach($payments as $k=>$payment){
        
                            $amount_used = floatval($payment['amount_used']);
                            $credit_used = floatval($payment['credit_used']);
                            $total_payment = $amount_used + $credit_used;
        
                            $total_credit_used += $credit_used;
        
                            $outstanding_amount = floatval($payment['outstanding_amount']);
                            unset($payments[$k]['outstanding_amount']);
        
                            $payments[$k]['payment_id'] = $payment_id;
                            $payments[$k]['total_payment'] = $total_payment;
        
                            if($total_payment == 0){
                                unset($payments[$k]);
                            }elseif($total_payment < $outstanding_amount){
                                $payments[$k]['status'] = 'PARTIAL';
                                $order_status_update[] = array(
                                    'id'  =>  $payment['order_id'],
                                    'payment_status' => 'Partial'
                                );
                            }else{
                                $payments[$k]['status'] = 'PAID';
                                $order_status_update[] = array(
                                    'id'  =>  $payment['order_id'],
                                    'payment_status' => 'Paid'
                                );
                            }
                        }
        
                        if($total_credit_used){
                            $this->db->update("payments",array('credit_balance_used'=>$total_credit_used),array('id'=>$payment_id));
                        }
        
                        if($order_status_update){
                            $this->db->update_batch("orders",$order_status_update,'id');
                        }
        
                        if($payments){
                            $this->db->insert_batch("payment_details",$payments);
                        }
        
                        $this->db->update("clients",array('credit_balance'=>$credit_balance),array('id'=>$client_id));
        
                    }
                }

                $ord_data = $this->db->query("SELECT 
                                            delivery_config_orders.order_id,
                                            clients.contact_person_1_phone_1 AS `mobile`
                                        FROM delivery_config_orders 
                                        LEFT JOIN orders on orders.id = delivery_config_orders.order_id
                                        LEFT JOIN clients on clients.id = orders.client_id
                                        WHERE delivery_config_orders.id = {$dco_id}")->row_array();
                
                $this->db->trans_complete();

                if($this->db->trans_status()){

                    //Send SMS to client.
                    $dt = date('Y-m-d');
                    $this->fcm->send_text($ord_data['mobile'],"Dear customer, Your order (Order Id : {$ord_data['order_id']}) was delivered on {$dt} from {$this->system_setting['system_name']}");

                    $this->response(
                        array(
                            'status' => TRUE,
                            'message' => 'Order Delivered'
                        ),
                        REST_Controller::HTTP_OK
                    );
                }else{
                    $this->response(
                        array(
                            'status' => FALSE,
                            'message' => 'Please Try Again.'
                        ),
                        REST_Controller::HTTP_OK
                    );
                }
            } else {
                $this->response(
                    array(
                        'status' => FALSE,
                        'message' => 'DCO Data not found.'
                    ),
                    REST_Controller::HTTP_OK
                );
            }
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'user_id, dco_id, payment_mode, manage_stock_needed are required.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /*
        Get Today Deliveries by Delivery Boy
        @author Rakesh Jangir
    */
    public function ideal_route_plan_get($user_id = NULL){

        if($user_id){

            $query = "SELECT	
                        `clients`.`client_name`,
                        `clients`.`contact_person_1_email` AS `email`,
                        `clients`.`contact_person_1_phone_1` AS `phone`,
                        `client_delivery_addresses`.`lat`,
                        `client_delivery_addresses`.`lng`
                    FROM `delivery`
                    LEFT JOIN `delivery_config` ON `delivery_config`.`delivery_id` = `delivery`.`id`
                    LEFT JOIN `delivery_config_orders` ON `delivery_config_orders`.`delivery_config_id` = `delivery_config`.`id`                
                    LEFT JOIN `orders` ON `orders`.`id` = `delivery_config_orders`.`order_id`
                    LEFT JOIN `clients` ON `clients`.`id` = `orders`.`client_id`
                    LEFT JOIN `client_delivery_addresses` ON `client_delivery_addresses`.`id` = `orders`.`delivery_address_id`                    
                    WHERE (`delivery_config`.`delivery_boy_id` = {$user_id} OR `delivery_config`.`driver_id` = {$user_id})
                    AND `orders`.`order_status`<>'Delivered'
                    AND date(`delivery`.`expected_delivey_datetime`) = CURDATE()
                    AND `client_delivery_addresses`.`lat` IS NOT NULL AND `client_delivery_addresses`.`lng` IS NOT NULL";

            if($routes = $this->db->query($query)->result_array()){
                $this->response(
                    array(
                        'status' => TRUE,
                        'message' => "Route Plan found.",
                        'route'=>$routes
                    ),REST_Controller::HTTP_OK
                );
            }else{
                $this->response(
                    array(
                        'status' => FALSE,
                        'message' => "Route Plan not found.",
                        'route'=>[]
                    ),REST_Controller::HTTP_OK
                );
            }

        }else{
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => "Please provide user_id.",
                    'route'=>[]
                ),
                REST_Controller::HTTP_BAD_REQUEST
            );
        }        
    }
                                                                    /*---------- Client -----------*/
    /*
        Get List of delivery addresses based on client_id
        @author Rakesh Jangir
    */
    public function delivery_addresses_get($id=null,$type=null){

        $where = ($type == 'lead') ? "lead_id = {$id}" : "client_id = {$id}";

        if($id){

            $delivery_addresses = $this->db
                                        ->select("client_delivery_addresses.id,CONCAT(client_delivery_addresses.title,',\n',client_delivery_addresses.address,',\n',zip_codes.zip_code) as `address`")
                                        ->join("zip_codes","zip_codes.id = client_delivery_addresses.zip_code_id")
                                        ->where($where)->get("client_delivery_addresses")->result_array();
            if($delivery_addresses){
                $this->response([
                    'status' => TRUE,
                    'message' => "Delivery Addresses Found",
                    'data' => $delivery_addresses,
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'No delivery address found',
                    'data' => [],
                ], REST_Controller::HTTP_OK);
            }
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'Client Id Missing',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /*
        Add Deliver Address to Client
        @author Rakesh Jangir
    */
    public function add_delivery_address_post(){

        $title      =   $this->input->post("title");
        $address    =   $this->input->post("address");
        $id         =   $this->input->post("id");
        $type       =   $this->input->post("type");
        $user_id    =   $this->input->post("user_id");
        $zip_code_id=   $this->input->post("zip_code_id");

        $lat=   $this->input->post("lat");
        $lng=   $this->input->post("lng");

        if(
            $title && $title!=''
            && $address && $address!=''
            && $id && $id!=''
            && $user_id && $user_id!=''
            && $zip_code_id && $zip_code_id!=''
        ){
            $address_data = array(
                'title'     =>  $this->input->post("title"),
                'address'   =>  $this->input->post("address"),
                'zip_code_id'=>  $this->input->post("zip_code_id"),
                'lat'=>  ($lat!='' && $lng!='') ? $lat : null,
                'lng'=>  ($lat!='' && $lng!='') ? $lng : null,
                'created_at'=>  date('Y-m-d H:i:s'),
                'created_by'=>  $this->input->post("user_id"),
            );

            if($type == 'lead'){
                $address_data['lead_id']  =   $this->input->post("id");
            }else{
                $address_data['client_id']  =   $this->input->post("id");
            }

            if($this->db->insert("client_delivery_addresses",$address_data)){
                $address_id = $this->db->insert_id();

                $this->response([
                    'status' => TRUE,
                    'message' => 'Client address saved.',
                    'data' => $address_id,
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'Client address not saved.',
                    'data'  =>  null,
                ], REST_Controller::HTTP_OK);
            }
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'Client Id, Tital, User Id, Zip Code and Address are required.',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        
    }

    /*
        Get Clients Created by specifited user and clients within users's zipcode group+zip code
        @author Rakesh Jangir
    */
    public function clients_by_salesman_get($user_id=null){

        if($user_id){
            $query = "SELECT 
                            clients.*
                        FROM clients
                        WHERE `clients`.`is_deleted` = 0 
                        AND (zip_code_id IN (
                                SELECT
                                    `user_zip_codes`.`zip_code_id`
                                FROM `users`
                                LEFT JOIN `user_zip_codes` ON `user_zip_codes`.`user_id` = `users`.`id`
                                WHERE `users`.`id` = {$user_id}
                            )
                            OR zip_code_id IN (
                                SELECT
                                    `group_to_zip_code`.`zip_code_id`
                                FROM `users`
                                LEFT JOIN `user_zip_code_groups` ON `user_zip_code_groups`.`user_id` = `users`.`id`
                                LEFT JOIN `group_to_zip_code` ON `group_to_zip_code`.`zip_code_group_id` = `user_zip_code_groups`.`zip_code_group_id`
                                WHERE `users`.`id` = {$user_id}
                            )
                            OR `clients`.`created_by` = {$user_id}
                        )";

            $clients = $this->db->query($query)->result_array();

            if(!empty($clients)){
                $this->response(
                    array(
                    'status' => TRUE,
                    'message' => "Clients",
                    'data' => $clients
                    ),REST_Controller::HTTP_OK
                );
            }else{
                $this->response(
                    array(
                    'status' => FALSE,
                    'message' => "Clients not found.",
                    'data' => []
                    ),REST_Controller::HTTP_OK
                );
            }
        }else{
            $this->response(
                array(
                'status' => FALSE,
                'message' => "UserId is required.",
                'data' => []
                ),REST_Controller::HTTP_BAD_REQUEST
            );
        }
    }


                                                                    /*---------- Dashboards -----------*/    
    
    /*
        Delivery Boy Dashboard
        @author Rakesh Jangir
    */
    public function delivery_boy_dashboard_post(){

        $user_id = $this->input->post('user_id');
        $version = $this->input->post('version');

        $force_update = 0;

        if($version && $this->db->where("force_update", 1)->where("version > ",$version)->get("app_versions")->result_array()){
            $force_update = 1;
        }


        if($user_id && $version){

            $notification_count = count($this->get_notifications($user_id));

            $query = "SELECT
                    `clients`.`client_name`,
                    `clients`.`contact_person_name_1` AS `contact_person`,
                    `clients`.`contact_person_1_phone_1` AS `client_contact`,
                    `clients`.`contact_person_1_email` AS `client_email`,
                    `client_delivery_addresses`.`title`,
                    `client_delivery_addresses`.`address`,
                    `zip_codes`.`zip_code`,
                    `orders`.`priority`,
                    `orders`.`payable_amount`,
                    date(`delivery`.`expected_delivey_datetime`) AS `expected_delivery_date`,
                    `orders`.`order_status`,
                    `delivery_config_orders`.`id` AS `dco_id`,
                    (CASE
                        WHEN `delivery_config`.`delivery_boy_id` IS NULL THEN TRUE
                        ELSE FALSE
                    END) AS `show_full_details`                    
                FROM `delivery_config_orders`
                LEFT JOIN `delivery` ON `delivery`.`id` = `delivery_config_orders`.`delivery_id`
                LEFT JOIN `orders` ON `orders`.`id` = `delivery_config_orders`.`order_id`
                LEFT JOIN `clients` ON `clients`.`id` = `orders`.`client_id`
                LEFT JOIN `client_delivery_addresses` ON `client_delivery_addresses`.`id` = `orders`.`delivery_address_id`
                LEFT JOIN `zip_codes` ON `zip_codes`.`id` = `client_delivery_addresses`.`zip_code_id`
                LEFT JOIN `delivery_config` ON `delivery_config`.`id` = `delivery_config_orders`.`delivery_config_id`
                WHERE (`delivery_config`.`delivery_boy_id` = {$user_id} OR `delivery_config`.`driver_id` = {$user_id})
                AND `orders`.`order_status`<>'Delivered'";

            $miss_delivery = " AND date(`delivery`.`expected_delivey_datetime`) < CURDATE()";
            $today_delivery = " AND date(`delivery`.`expected_delivey_datetime`) = CURDATE()";

            $today_deliveries = $this->db->query($query.$today_delivery)->result_array();
            $today_deliveriey_count = count($today_deliveries);

            if($miss_deliveries = $this->db->query($query.$miss_delivery)->result_array()){

                $this->response(
                    array(
                        'status' => TRUE,
                        'force_update' => $force_update,
                        'message' => "Missed Delivery found.",
                        'notification_count'    =>  $notification_count,
                        'today_delivery_count'=>$today_deliveriey_count,
                        'missed_deliveries'=>$miss_deliveries,
                        'images' => $this->dashboard_images,
                    ),REST_Controller::HTTP_OK
                );
            }else{
                $this->response(
                    array(
                        'status' => FALSE,
                        'force_update' => $force_update,
                        'message' => "Missed Delivery not found.",
                        'notification_count'    =>  $notification_count,
                        'today_delivery_count'=>$today_deliveriey_count,
                        'missed_deliveries'=>[],
                        'images' => $this->dashboard_images,
                    ),REST_Controller::HTTP_OK
                );
            }

        }else{
            $this->response(
                array(
                    'status' => FALSE,
                    'force_update' => $force_update,
                    'message' => "Please provide user_id and version.",
                    'notification_count'    =>  0,
                    'today_delivery_count' => 0,
                    'missed_deliveries'=>[],
                    'images' => $this->dashboard_images,
                ),
                REST_Controller::HTTP_BAD_REQUEST
            );
        }        
    }

    /*
        Salesman Dashboard
        @author Rakesh Jangir
    */
    public function salesman_dashboard_post(){

        $user_id = $this->input->post('user_id');
        $version = $this->input->post('version');
        $force_update = 0;

        if($version && $this->db->where("force_update", 1)->where("version > ",$version)->get("app_versions")->result_array()){
            $force_update = 1;
        }

        if($user_id && $version){

            $notification_count = count($this->get_notifications($user_id));
            
            //Count Lead Visits
            $today_followup_lead = "SELECT
                            COUNT(*) AS `today_followups`
                        FROM `lead_visits`
                        WHERE `created_by` = {$user_id}
                        AND date(`created_at`) = CURDATE()";

            $today_followup_lead = $this->db->query($today_followup_lead)->row_array()['today_followups'];

            //Count Client Visits
            $today_followup_client = "SELECT
                            COUNT(*) AS `today_followups`
                        FROM `client_visits`
                        WHERE `created_by` = {$user_id}
                        AND date(`created_at`) = CURDATE()";

            $today_followup_client = $this->db->query($today_followup_client)->row_array()['today_followups'];

            $today_followup_count = $today_followup_lead + $today_followup_client;

            //Count Today Orders
            $today_orders = "SELECT
                COUNT(*) AS `today_orders_count`
            FROM `orders`
            WHERE `created_by` = {$user_id}
            AND date(`created_at`) = CURDATE()";

            $today_orders_count = $this->db->query($today_orders)->row_array()['today_orders_count'];
            
            //Count Today Leads
            $today_leads = "SELECT
                COUNT(*) AS `today_leads_count`
            FROM `leads`
            WHERE `created_by` = {$user_id}
            AND date(`created_at`) = CURDATE()";

            $today_leads_count = $this->db->query($today_leads)->row_array()['today_leads_count'];

            //Count Pending Invoices (Pending+Partial)
            $pending_invoices_count = $this->db
                                            ->query("SELECT
                                                        COUNT(`orders`.`id`) AS `pending_invoices_count`
                                                    FROM `orders`
                                                    WHERE `orders`.`payment_status` <> 'Paid'
                                                    AND `orders`.`created_by` = 1")
                                            ->row_array()['pending_invoices_count'];

            $this->response(
                array(
                    'status' => TRUE,
                    'force_update' => $force_update,
                    'message' => "Salesman Dashboard",
                    'notification_count'    =>  $notification_count,
                    'today_followup_count'=>$today_followup_count,
                    'today_orders_count'=>$today_orders_count,
                    'today_leads_count'=>$today_leads_count,
                    'today_pending_invoice_count'=>$pending_invoices_count,
                    'images' => $this->dashboard_images,
                ),REST_Controller::HTTP_OK
            );

        }else{
            $this->response(
                array(
                    'status' => FALSE,
                    'force_update' => $force_update,
                    'message' => "Please provide user_id and version.",
                    'notification_count'    =>  0,
                    'today_followup_count'=>null,
                    'today_orders_count'=>null,
                    'today_leads_count'=>null,
                    'today_pending_invoice_count'=>null,
                    'images' => $this->dashboard_images,
                ),
                REST_Controller::HTTP_BAD_REQUEST
            );
        }        
    }

                                                                    /*---------- Product -----------*/

    /*
        Get Product List
        (To get prise based on client, pass client_id)
        @author Milan Soni
        @changed by Rakesh Jangir 25-11-2019
    */
    public function products_get($client_id=null){

        $originalImgUrl = base_url()."files/assets/uploads/products/originals";
        $thumbImgUrl = base_url()."files/assets/uploads/products/thumbnails";
        $products = array();

        if($client_id){
            $query = "SELECT 
                        `products`.`id` AS `product_id`,
                        `products`.`product_name`,
                        `products`.`product_code`,
                        `products`.`description`,
                        `products`.`weight`,
                        `client_product_price`.`sale_price`,
                        `products`.`status`,
                        `original_image_name`,
                        `thumb`
                    FROM `client_product_price`
                    LEFT JOIN `products` ON `products`.`id` = `client_product_price`.`product_id`
                    LEFT JOIN `product_images` ON `product_images`.`product_id` = `products`.`id`
                    WHERE `products`.`is_deleted` = 0
        AND `client_product_price`.`client_id`={$client_id}";
        }else{
            $query = "SELECT 
                        `products`.`id` AS `product_id`,
                        `products`.`product_name`,
                        `products`.`product_code`,
                        `products`.`description`,
                        `products`.`weight`,
                        `products`.`sale_price`,
                        `products`.`status`,
                        `original_image_name`,
                        `thumb`
                    FROM `products`
                    LEFT JOIN `product_images` ON `product_images`.`product_id` = `products`.`id`
                    WHERE `products`.`is_deleted` = 0";
        }

        $products = $this->db->query($query)->result_array();

        if(!empty($products)){
            foreach($products as &$pr){
                $pr['original_image_name'] = $originalImgUrl.'/'.$pr['original_image_name'];
                $pr['thumb'] = $thumbImgUrl.'/'.$pr['thumb'];
            }
        }
        if(!empty($products)){
            $this->response([
                'status' => TRUE,
                'message' => 'Data found.',
                'data' => $products
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'Data not found.',
                'data' => $products
            ], REST_Controller::HTTP_OK);
        }
    }

                                                                        /*---------- FCM Notifications -----------*/
    /*
        Get FCM Notifications List
        @author Rakesh Jangir
    */
    public function notifications_get($user_id=null){

        if($user_id){

            $notifications = $this->get_notifications($user_id,true);

            if($notifications){
                $this->response(
                    array(
                        'status' => TRUE,
                        'message' => "Notifications found.",
                        'notifications' => $notifications
                    ),
                    REST_Controller::HTTP_OK
                );
            }else{
                $this->response(
                    array(
                        'status' => FALSE,
                        'message' => "Notifications not found.",
                        'notifications' => []
                    ),
                    REST_Controller::HTTP_OK
                );
            }    
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'Please provide user_id.',
                'notifications' => []
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /*
        Get FCM Notifications List
        @param $user_id, $notification_id
        @author Rakesh Jangir
    */
    public function read_notification_post(){

        $user_id = $this->input->post('user_id');
        $notification_id = $this->input->post('notification_id');   // id field of fcm_notification_user table

        if($user_id && $notification_id){

            $data = array(
                "is_read"   =>  1,
                "updated_at"=>  date('Y-m-d'),
                "updated_by"=>  $user_id,
            );

            if($this->db->where("id",$notification_id)->update("fcm_notification_user",$data)){
                $this->response(
                    array(
                        'status' => TRUE,
                        'message' => "Notifications read successful"
                    ),
                    REST_Controller::HTTP_OK
                );
            }else{
                $this->response(
                    array(
                        'status' => FALSE,
                        'message' => "Notifications read failed"
                    ),
                    REST_Controller::HTTP_OK
                );
            }    
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'Please provide user_id and notification_id both.',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }


                                                                    /*---------- Stae/City/Zip -----------*/
    /*
        Get ZIP Code List
        @author Milan Soni
        @changed by Rakesh Jangir 22-11-2019
    */
    public function zip_codes_get($user_id=null){

        if($user_id){
            $zip_codes = $this->db->query("SELECT 
                    `zip_code_id`,
                    CONCAT(`zip_code`,' ',`area`) AS `zip_code`
                    FROM `user_zip_codes`
                    LEFT JOIN `zip_codes` ON `zip_codes`.`id` = `user_zip_codes`.`zip_code_id`
                    LEFT JOIN `users` ON `users`.`id` = `user_zip_codes`.`user_id`
                    WHERE `users`.`id` = $user_id
                    AND `zip_codes`.`status` = 'Active'
                    ")->result_array();
        }else{
            $zip_codes = $this->db->select("id as zip_code_id,CONCAT(`zip_code`,' ',`area`) AS `zip_code`")->get("zip_codes")->result_array();
        }
        
        if(!empty($zip_codes)){
            $this->response(
                array(
                    'status' => TRUE,
                    'message' => "ZIP Codes found.",
                    'data' => $zip_codes
                ),
                REST_Controller::HTTP_OK
            );
        }else{
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => "ZIP Codes not found.",
                    'data' => $zip_codes
                ),
                REST_Controller::HTTP_OK
            );
        }
    }
    /*
        Get list of cities in specific state
        @author Rakesh Jangir
        @param $state_id
    */
    public function cities_by_state_post(){
        
        if($state_id = $this->input->post('state_id')){

            $cities = $this->db->select("id,name")->get_where("cities",['state_id'=>$state_id,'is_deleted'=>0,'status'=>'Active'])->result_array();

                if($cities){
                    $this->response(
                        array(
                            'status' => TRUE,
                            'message' => "Cities found.",
                            'data' => $cities
                        ),
                        REST_Controller::HTTP_OK
                    );
                }else{
                    $this->response(
                        array(
                            'status' => FALSE,
                            'message' => "Cities not found.",
                            'data' => []
                        ),
                        REST_Controller::HTTP_OK
                    );
                }
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'State Id is required.',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /*
        Get List of states
        Optionally get specific state by providing $state_id
        @author Rakesh Jangir
        @param $state_id Optional
    */
    public function states_get($state_id=NULL){
        
        if($state_id){
            if($state = $this->db->select("name")->get_where("states",['id'=>$state_id,'is_deleted'=>0,'status'=>'Active'])->row_array()){
                $this->response(
                    array(
                        'status' => TRUE,
                        'message' => "State found.",
                        'data' => $state
                    ),
                    REST_Controller::HTTP_OK
                );
            }else{
                $this->response(
                    array(
                        'status' => FALSE,
                        'message' => "State not found.",
                        'data' => NULL
                    ),
                    REST_Controller::HTTP_OK
                );
            }
        }else{
            if($states = $this->db->select("id,name")->get_where("states",['is_deleted'=>0,'status'=>'Active'])->result_array()){
                $this->response(
                    array(
                        'status' => TRUE,
                        'message' => "States found.",
                        'data' => $states
                    ),
                    REST_Controller::HTTP_OK
                );
            }else{
                $this->response(
                    array(
                        'status' => FALSE,
                        'message' => "States not found.",
                        'data' => []
                    ),
                    REST_Controller::HTTP_OK
                );
            }
        }
    }

    /*
        Check whether user needs to update his app or not
        @author Rakesh Jangir
        @date 26-12-2019
    */
    public function check_update_post(){

        $version = $this->input->post('version');
        
        if($version){
            if($this->db->where("force_update", 1)->where("version > ",$version)->get("app_versions")->result_array()){
                $this->response(
                    array(
                        'status' => TRUE,
                        'force_update' => 1,
                        'message' => 'Update required'
                    ),
                    REST_Controller::HTTP_OK
                );
            }else{
                $this->response(
                    array(
                        'status' => TRUE,
                        'force_update' => 0,
                        'message' => 'No need to update'
                    ),
                    REST_Controller::HTTP_OK
                );
            }
        }else{
            $this->response(
                array(
                    'status' => FALSE,
                    'force_update' => 0,
                    'message' => 'Version missing'
                ),
                REST_Controller::HTTP_BAD_REQUEST
            );
        }
    }


    // Helper Function
    private function check_in_range($start_date, $end_date, $date_from_user){
        // Convert to timestamp
        $start_ts = strtotime($start_date);
        $end_ts = strtotime($end_date);
        $user_ts = strtotime($date_from_user);

        // Check that user date is between start & end
        return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
    }

    private function get_notifications($user_id,$all=false){

        if($all){
            $notifications = $this->db
                            ->select("fcm_notifications.title,fcm_notifications.message,fcm_notification_user.is_read,fcm_notification_user.user_id,fcm_notification_user.id AS notification_id")
                            ->where("fcm_notification_user.user_id",$user_id)
                            ->join("fcm_notification_user","fcm_notification_user.notification_id = fcm_notifications.id","left")
                            ->order_by("fcm_notifications.created_at", "DESC")
                            ->get("fcm_notifications")
                            ->result_array();
        }else{
            $notifications = $this->db
                            ->select("fcm_notifications.title,fcm_notifications.message,fcm_notification_user.is_read,fcm_notification_user.user_id,fcm_notification_user.id AS notification_id")
                            ->where("fcm_notification_user.user_id",$user_id)
                            ->where("fcm_notification_user.is_read",0)
                            ->join("fcm_notification_user","fcm_notification_user.notification_id = fcm_notifications.id","left")
                            ->order_by("fcm_notifications.created_at", "DESC")
                            ->get("fcm_notifications")
                            ->result_array();
        }
        
        return $notifications;
    }

    public function print_invoice_get($id){

        $order = $this->get_order($id);
        
        $this->data['order'] = $order;
        $invoice = $this->load->view('order/order_print', $this->data,true);

        $date = date('d-m-Y',strtotime($order['created_at']));
        $file_name = "Invoice #{$order['id']} {$order['client_name']} {$date}.pdf";
        $this->generate_pdf($invoice,$file_name);
    }

    private function generate_pdf($html,$file_name=NULL,$mode='I'){

        ini_set("pcre.backtrack_limit", "5000000");
        ini_set('memory_limit','2048M');
        ini_set('max_execution_time',0);

        $root_path = FCPATH.'files'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR;

        $pathInfo = pathinfo($file_name);
        if(isset($pathInfo['extension']) && $pathInfo['dirname']!='.'){

            $dir_structure =dirname($file_name);
            if (!file_exists($dir_structure)) {
                mkdir($dir_structure, 0777, true);
            }
        }

        $modeArr = array(
            'I'=>\Mpdf\Output\Destination::INLINE,
            'D'=>\Mpdf\Output\Destination::DOWNLOAD,
            'F'=>\Mpdf\Output\Destination::FILE,
            'S'=>\Mpdf\Output\Destination::STRING_RETURN,
        );

        $mpdf = new \Mpdf\Mpdf(
            array(
                // 'mode' => 'utf-8',
                // 'format' => array(210, 297),
                // 'orientation' => 'P',
                // 'setAutoTopMargin' => 'stretch',
                // 'autoMarginPadding' => 0,
                // 'bleedMargin' => 0,
                // 'crossMarkMargin' => 0,
                // 'cropMarkMargin' => 0,
                // 'nonPrintMargin' => 0,
                // 'margBuffer' => 0,
                // 'collapseBlockMargins' => false,
            )
        );
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        $mpdf->Output($file_name,$modeArr[$mode]);
    }

    private function get_order($id){    //order_id

        $order = $this->db
            ->select("
                orders.*,
                `clients`.`client_name`,
                CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                schemes.name as scheme_name,
                schemes.description,
                schemes.gift_mode,
                schemes.discount_mode,
                schemes.discount_value,
                schemes.free_product_id,
                schemes.free_product_qty,
                (CASE
                    WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                        WHEN schemes.discount_mode='amount' THEN schemes.discount_value
                        ELSE (orders.payable_amount*schemes.discount_value/100)
                    END)
                    ELSE 0
                END) AS `computed_disc`,
                (CASE
                    WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                        WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                        ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                    END)
                    ELSE orders.payable_amount
                END) AS `effective_amount`")                
            ->where("orders.id = {$id}")
            ->from("orders")
            ->join("schemes","schemes.id = orders.scheme_id","left")
            ->join("clients","clients.id = orders.client_id","left")
            ->join("users as salesman","salesman.id = orders.created_by","left")
            ->get()
            ->row_array();

        $client_id = $order['client_id'];
        
        if($order){
            $order['order_items'] = $this->db
                ->select("order_items.*,products.product_name,products.product_code,products.description,products.weight,products.dimension,products.sale_price as original_sale_price")
                ->where("order_id = {$order['id']}")
                ->from("order_items")
                ->join("products","products.id = order_items.product_id","left")
                ->get()
                ->result_array();

            $order['order_client'] = $this->db
                ->select("clients.*")
                ->where("id = {$client_id}")
                ->from("clients")
                ->get()
                ->row_array();

            if($order['free_product_id']){
                $order['free_product'] = $this->db->where("id",$order['free_product_id'])->get("products")->row_array();
                // echo "<pre>";print_r($order['free_product']);die;
            }else{
                $order['free_product'] = null;
            }
        }
        
        return $order;
    }
}