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

    public function products_get(){
        $originalImgUrl = base_url()."assets/uploads/products/originals";
        $thumbImgUrl = base_url()."assets/uploads/products/thumbnails";
        $products = [];
        $products = $this->db->query("SELECT 
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
                ")->result_array();

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
    // general function stop
    
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

            $this->db->insert("user_devices", array("user_id"=>$user['user_id'], "device_id"=>$device_id));

            // remove first created device ids if more than two
            $sqlDeviceIds = $this->db->query("
                DELETE FROM `user_devices`
                WHERE id NOT IN (
                  SELECT id
                  FROM (
                    SELECT id
                    FROM `user_devices`
                    ORDER BY id DESC
                    LIMIT 2
                  ) foo
                )
                ");
            
            if($user){
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
                    'data' => array()
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

    //Get Clients by Salesman
    public function clients_by_salesman_get($user_id){

        $query = "SELECT 
                        id,first_name,last_name,credit_limit,email,address
                    FROM clients
                    WHERE zip_code_id IN (
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
                    )";
        $clients = $this->db->query($query)->result_array();

        if($clients){
            foreach($clients as $k=>$client){

                $contacts = $this->db->select("id,phone,person_name,is_primary")->where("client_id = {$client['id']}")->get("client_contacts")->result_array();
                $clients[$k]['contacts'] = $contacts;
            }
        }

        $this->response(
            array(
            'status' => TRUE,
            'message' => "Clients",
            'data' => $clients
            ),
        REST_Controller::HTTP_OK
        );
    }

    //Get ZIP Code List
    public function zip_codes_get(){

        $zip_codes = $this->db->get("zip_codes")->result_array();
        $this->response(
            array(
                'status' => FALSE,
                'message' => "ZIP Codes",
                'data' => $zip_codes
            ),
            REST_Controller::HTTP_OK
        );
    }

    //Add/Update Visit - Client
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

    public function make_order_post(){
        $entityBody = file_get_contents('php://input');
        // var_dump($entityBody);die;
        /*
            {
                "client_id": 1,
                "user_id":1,
                "order_details":[
                    {
                        "product_id": 1,
                        "quantity":10,
                        "actual_price": 10,
                        "effective_price": 12
                    },
                    {
                        "product_id": 2,
                        "quantity":10,
                        "actual_price": 12,
                        "effective_price": 15
                    }
                ]
            }
        */

        if(!empty($entityBody)){
            $orders = json_decode($entityBody,true);
            if(!empty($orders)){
                // echo "<pre>"; print_r($orders);die;
                if(!empty($orders['client_id']) && !empty($orders['user_id']) && !empty($orders['order_details'])){
                    foreach($orders['order_details'] as $detail){
                        if(!empty($detail['product_id']) && !empty($detail['quantity']) && !empty($detail['effective_price'])){

                            // order table array data
                            $arrOrder = array(
                                'client_id'=>$orders['client_id'],
                                'created_at'=>date('Y-m-d H:i:s'),
                                'created_by'=>$orders['user_id']
                            );

                            // order items array data
                            $arrOrderItems[] = array(
                                'product_id'=>$detail['product_id'],
                                'quantity'=>$detail['quantity'],
                                'actual_price'=>$detail['actual_price'],
                                'effective_price'=>$detail['effective_price']
                            );
                        }else{
                            $this->response([
                                'status' => FALSE,
                                'message' => 'Provide product_id, quantity and effective price.',
                            ], REST_Controller::HTTP_OK);
                        }
                    }
                    if($this->order->insert_order($arrOrder, $arrOrderItems)){
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
                        'message' => 'Please provide client_id, user_id and order details.',
                    ], REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'Invalid json request.',
                ], REST_Controller::HTTP_OK);
            }
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'Please provide json body.',
            ], REST_Controller::HTTP_OK);
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
}