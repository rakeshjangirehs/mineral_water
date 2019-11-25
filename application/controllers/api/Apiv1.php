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
    }
    
    public function send_notification( $deviceIds = array(), $msg = 'test' ){
        // API access key from Google FCM App Console
        define( 'API_ACCESS_KEY', 'AAAAttXlDzw:APA91bFay0Y4UpcRFTefhlu2zNJbnGUcyImoBp7v3oUwh3SGK6hs8NBS2s_gXBvmr7SUM9QnWMsjGU5_WrIhfqsftRVMOH5DQZY8E8Zt1FRGGkwPIT5s9s1mGFK71s2_u72Xw8qRf807' );

        //$singleID = 'fvSMP9Herzk:APA91bGVjjj71IN-5vxUcfOgndIcNd2wEgQWxayllwESVMOzr9znJPteYXOM8S35qcG5CuMokOz10KVyEorZvo8IjanIkywzLX1R6c0gqJc9fSHN-oG0KTimSy4hwDLtbF3ruZ002nPl'; 
        $registrationIDs = array();
        foreach($deviceIds as $device){
            array_push($registrationIDs, $device['device_id']);
        }

        /*$registrationIDs = array(
             'eEvFbrtfRMA:APA91bFoT2XFPeM5bLQdsa8-HpVbOIllzgITD8gL9wohZBg9U.............mNYTUewd8pjBtoywd', 
             'eEvFbrtfRMA:APA91bFoT2XFPeM5bLQdsa8-HpVbOIllzgITD8gL9wohZBg9U.............mNYTUewd8pjBtoywd'
             'eEvFbrtfRMA:APA91bFoT2XFPeM5bLQdsa8-HpVbOIllzgITD8gL9wohZBg9U.............mNYTUewd8pjBtoywd'
        ) ;*/

        // prep the bundle
        // to see all the options for FCM to/notification payload: 
        // https://firebase.google.com/docs/cloud-messaging/http-server-ref#notification-payload-support 

        // 'vibrate' available in GCM, but not in FCM
        $fcmMsg = array(
            'body' => $msg,
            'title' => 'Maintenance Activity',
            'sound' => "default",
                'color' => "#203E78" 
        );
        // I haven't figured 'color' out yet.
        // On one phone 'color' was the background color behind the actual app icon.  (ie Samsung Galaxy S5)
        // On another phone, it was the color of the app icon. (ie: LG K20 Plush)

        // 'to' => $singleID ;  // expecting a single ID
        // 'registration_ids' => $registrationIDs ;  // expects an array of ids
        // 'priority' => 'high' ; // options are normal and high, if not set, defaults to high.
        $fcmFields = array(
            // 'to'                => 'test',
            'registration_ids'  => $registrationIDs,
            'priority'          => 'high',
            'notification'      => $fcmMsg
        );

        $headers = array(
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );
         
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fcmFields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        // echo $result . "\n\n";
    }

    
    // general function stop
    
    

    // dashboards
    public function sales_dashboard_get($user_id){

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

    //Get Clients by Salesman
    public function clients_by_salesman_get($user_id){

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
                            WHERE `users`.`created_by` = {$user_id}
                        )
                    )";
        $clients = $this->db->query($query)->result_array();

        if(!empty($clients)){
            // foreach($clients as $k=>$client){

            //     $contacts = $this->db->select("id,phone,person_name,is_primary")->where("client_id = {$client['id']}")->get("client_contacts")->result_array();
            //     $clients[$k]['contacts'] = $contacts;
            // }

            $this->response(
                array(
                'status' => TRUE,
                'message' => "Clients",
                'data' => $clients
                ),
            REST_Controller::HTTP_OK
            );
        }else{
            $this->response(
                array(
                'status' => FALSE,
                'message' => "Clients not found.",
                'data' => $clients
                ),
            REST_Controller::HTTP_OK
            );
        }
    }

    

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
    public function contacts_get($client_id,$contact_id=NULL){

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
    }

    //Add/Update Client Contact
    public function add_update_client_contact_post(){

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
    }

    //Add Client Visit
    public function add_client_visit_post(){

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
    }

    // delivery boy
    public function order_delivery_post(){
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
    }

    public function client_invoice_summary_get($user_id = NULL){
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
    }

    public function today_delivery_get($user_id = NULL){
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

    public function ideal_route_plan_get($user_id = NULL){
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
                    CONCAT_WS(' ', `clients`.`first_name`, `clients`.`last_name`) AS `client_name`,
                    `clients`.`email`,
                    IFNULL(`clients`.`phone`, '-') AS phone,
                    `clients`.`lat`,
                    `clients`.`lng`
                FROM `orders`
                LEFT JOIN `clients` ON `clients`.`id` = `orders`.`client_id`
                WHERE delivery_boy_id = $user_id
                AND expected_delivery_date = CURDATE()
                AND actual_delivery_date IS NULL
                GROUP BY `orders`.`id`
        ");
        $main_data = (!empty($sql->result_array())) ? $sql->result_array() : array();
        // echo "<pre>".$this->db->last_query();die;
        if(!empty($main_data)){
            $this->response(
                array(
                    'status' => TRUE,
                    'message' => "Ideal Route plan found.",
                    'ideal_route'=>$main_data
                ),
                REST_Controller::HTTP_OK
            );
        }else{
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => "Ideal Route plan not found.",
                    'ideal_route'=>$main_data
                ),
                REST_Controller::HTTP_OK
            );
        }
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
    }
    
    public function delivery_boy_orders_get($delivery_boy_id = NULL){
		
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
    }
    

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
                $this->db->insert("user_devices", array("user_id"=>$user['user_id'], "device_id"=>$device_id));

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

            }else{
                // Set the response and exit
                //BAD_REQUEST (400) being the HTTP response code
                $this->response([
                    'status' => FALSE,
                    'message' => 'Wrong email or password.',
                    'data' => new stdClass()
                ], REST_Controller::HTTP_OK);
            }
        }else{
            // Set the response and exit
            $this->response([
                    'status' => FALSE,
                    'message' => "Provide email and password.",
                    'data' => array()
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

            $where = "1=1 AND is_converted = 0 AND created_by = {$user_id}";            

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
                'created_by'=>$user_id
            );

            $visitArr = ($visit_note) ? array(
                'visit_date'    =>  date('Y-m-d'),
                'visit_time'    =>  date('H:i:s'),
                'visit_type'    =>  'InPerson',
                'visit_notes'   => $visit_note,
                'created_at'    =>  date('Y-m-d'),
                'created_by'    =>  $user_id
            ) : array();

            if($lead_id){
                $leadArr['updated_by'] = $user_id;
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

            $visit_notes = ($this->input->post('visit_notes')) ? $this->input->post('visit_notes') : NULL;

            $visit_data = array(
                'visit_date'=> ($this->input->post('visit_date')) ? $this->input->post('visit_date') : NULL,
                'visit_time'=> ($this->input->post('visit_time')) ? $this->input->post('visit_time') : NULL,
                'visit_type'=> ($this->input->post('visit_type')) ? $this->input->post('visit_type') : NULL,
                'opportunity'=> ($this->input->post('opportunity')) ? $this->input->post('opportunity') : NULL,
                'other_notes'=> ($this->input->post('other_notes')) ? $this->input->post('other_notes') : NULL,
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
                        'message' => 'Visit created successfully.',
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
                                        'new_subtotal'   =>  $new_subtotal,
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
                                            'new_subtotal'   =>  $new_subtotal,
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
                                            'new_subtotal'   =>  $new_subtotal,
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

    /*
        Get List of applicable Schemes based on order_details
        @author Milan Soni
        @update by Rakesh Jangir - 21-11-2019
    */
    public function make_order_post(){

        $entityBody = file_get_contents('php://input');
        // var_dump($entityBody);die;
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
                        $availableCreditLimit = $this->db->query("SELECT 
                                                        `clients`.`id`,
                                                        `clients`.`client_name`,
                                                        `clients`.`credit_limit`,
                                                        `clients`.`credit_balance`,
                                                        IFNULL(`ord`.`outstanding`,0) AS `outstanding`,
                                                        IFNULL(`pay`.`paid`,0) AS `paid`,
                                                        ((`clients`.`credit_limit`+`clients`.`credit_balance`) - (IFNULL(`ord`.`outstanding`,0)-IFNULL(`pay`.`paid`,0))) AS `available_credit_limit`
                                                    FROM `clients`
                                                    LEFT JOIN (
                                                        SELECT
                                                            `client_id`,
                                                            SUM(`payable_amount`) AS `outstanding`
                                                        FROM `orders`
                                                        GROUP BY `client_id`
                                                    ) AS `ord` ON `ord`.`client_id` = `clients`.`id`
                                                    LEFT JOIN (
                                                        SELECT 
                                                            `client_id`,
                                                            SUM(`paid_amount`) AS `paid`
                                                        FROM `payments`
                                                        GROUP BY `client_id`
                                                    ) AS `pay` ON `pay`.`client_id` = `clients`.`id`
                                                    WHERE `clients`.`id` = {$id}
                                                    GROUP BY `clients`.`id`")
                                                ->row_array()['available_credit_limit'];


                        // echo $availableCreditLimit."<br/>".$subtotal;die;
                        // Available credit limit logic verify - TODO
                        $availableCreditLimit = 50000;

                        if($subtotal > $availableCreditLimit){
                            $this->response([
                                'status' => FALSE,
                                'message' => 'Available credit limit exceeded. Please pay your outstanding.',
                            ], REST_Controller::HTTP_OK);
                            die;
                        }

                    }else{

                        $lead = $this->db->get_where("leads",["id"=>$id])->row_array();
                        $settings = $this->db->get("settings")->row_array();

                        $arrClient = array(
                            'client_name'       =>  $lead['company_name'],
                            'credit_limit'      =>  $settings['default_credit_limit'],
                            'lead_id'           =>  $id,
                            'contact_person_name_1'     =>  $lead['contact_person_name'],
                            'contact_person_1_phone_1'  =>  $lead['phone_1'],
                            'contact_person_1_email'    =>  $lead['email'],
                            'created_at'                =>  date('Y-m-d H:i:s'),
                            'created_by'                =>  $user_id,
                        );
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
                        'scheme_id'     =>  (isset($orders['scheme_id'])) ? $orders['scheme_id'] : null,
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

                    if($orderId = $this->order->insert_order($arrOrder, $arrOrderItems,$arrClient)){
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

                                                                    /*---------- Order /  Scheme -----------*/
    /*
        Get List of delivery addresses based on client_id
        @author Rakesh Jangir
    */
    public function delivery_addresses_get($client_id=null){

        if($client_id){

            $delivery_addresses = $this->db
                                        ->select("client_delivery_addresses.id,CONCAT(client_delivery_addresses.title,',\n',client_delivery_addresses.address,',\n',zip_codes.zip_code) as `address`")
                                        ->join("zip_codes","zip_codes.id = client_delivery_addresses.zip_code_id")
                                        ->where("client_id = {$client_id}")->get("client_delivery_addresses")->result_array();
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
        $client_id  =   $this->input->post("client_id");
        $user_id    =   $this->input->post("user_id");
        $zip_code_id    =   $this->input->post("zip_code_id");

        if(
            $title && $title!=''
            && $address && $address!=''
            && $client_id && $client_id!=''
            && $user_id && $user_id!=''
            && $zip_code_id && $zip_code_id!=''
        ){
            $address_data = array(
                'title'     =>  $this->input->post("title"),
                'address'   =>  $this->input->post("address"),
                'zip_code_id'=>  $this->input->post("zip_code_id"),
                'client_id' =>  $this->input->post("client_id"),                
                'created_at'=>  date('Y-m-d H:i:s'),
                'created_by'=>  $this->input->post("user_id"),
            );

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
                    `zip_code`
                    FROM `user_zip_codes`
                    LEFT JOIN `zip_codes` ON `zip_codes`.`id` = `user_zip_codes`.`zip_code_id`
                    LEFT JOIN `users` ON `users`.`id` = `user_zip_codes`.`user_id`
                    WHERE `users`.`id` = $user_id
                    AND `zip_codes`.`status` = 'Active'
                    ")->result_array();
        }else{
            $zip_codes = $this->db->select("id as zip_code_id,zip_code")->get("zip_codes")->result_array();
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

                                                                    /*---------- Stae/City/Zip -----------*/

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


    // Helper Function
    private function check_in_range($start_date, $end_date, $date_from_user){
    // Convert to timestamp
    $start_ts = strtotime($start_date);
    $end_ts = strtotime($end_date);
    $user_ts = strtotime($date_from_user);

    // Check that user date is between start & end
    return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
    }
}