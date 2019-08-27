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
        $this->load->model('activity');
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
}