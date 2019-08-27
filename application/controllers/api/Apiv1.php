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

    public function general_data_get(){
        $qrUrl = base_url()."qr";

        $res = array();
        $resultDepartment = $this->db->get_where('departments', array('status'=>1))->result_array();
        $resultPlants = $this->db->get_where('plants', array('status'=>1))->result_array();
        $resultEquipments = $this->db->get_where('equipments', array('status'=>1))->result_array();
        $resultReason = $this->db->get_where('reasons', array('status'=>1))->result_array();
        
        $resultTags = $this->db->select("equipment_tags.id as tag_id, equipment_tags.equipment_id, equipment_tags.plant_id, equipment_tags.tag_no, equipment_tags.equipment_use, equipment_tags.qr, equipment_tags.status, equipments.name as equipment_name, plants.name as plant_name")
                                ->from("equipment_tags")
                                ->join("equipments", "equipments.id = equipment_tags.equipment_id", "LEFT")
                                ->join("plants", "plants.id = equipment_tags.plant_id", "LEFT")
                                ->get()
                                ->result_array();

        if(!empty($resultTags)){
            foreach($resultTags as &$tags){
                $tags['qr'] = $qrUrl.'/'.$tags['qr'];
            }
        }
        $res['departments'] = $resultDepartment;
        $res['plants'] = $resultPlants;
        $res['equipments'] = $resultEquipments;
        $res['equipment_tags'] = $resultTags;
        $res['reasons'] = $resultReason;
        
        if(!empty($res)){
            $this->response([
                'status' => TRUE,
                'message' => 'Data found.',
                'data' => $res
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'Data not found.',
                'data' => $res
            ], REST_Controller::HTTP_OK);
        }
    }

    public function maintenance_start_stop_post(){
        $note = $this->input->post('note');
        $activity = $this->input->post('activity');
        $tag_no = $this->input->post('tag_no');
        $user_id = $this->post('user_id');

        $start_date = ($this->input->post('start_date')) ? $this->input->post('start_date') : NULL;
        $end_date = ($this->input->post('end_date')) ? $this->input->post('end_date') : NULL;
        $status = ($this->input->post('status')) ? $this->input->post('status') : 0;

        // get tag_id from tag_no
        $tag_id = $this->getTagId($tag_no);

        if(!empty($note) && !empty($tag_id) && !empty($activity) && !empty($user_id)){

            $arrData = array(
                'note'          => $note,
                'activity'      => $activity,
                'tag_id'        => $tag_id,
                'status'        => $status,
                'start_date'    => $start_date,
                'end_date'      => $end_date,
                'photo'         => NULL,
                'created_by'    => $user_id,
                'created_at'    => date('Y-m-d H:i:s')
            );
            $this->db->trans_start();
            $this->db->insert("equipment_notes", $arrData);
            // send push notification start
            // get device ids
            $deviceIds = $deviceIds = $this->getDeviceIds($user_id);

            // for fcm message notification
            $resultTags = $this->db->select("equipment_tags.id as tag_id, equipment_tags.equipment_id, equipment_tags.plant_id, equipment_tags.tag_no, equipment_tags.equipment_use, equipment_tags.qr, equipment_tags.status, equipments.name as equipment_name, plants.name as plant_name")
                                ->from("equipment_tags")
                                ->join("equipments", "equipments.id = equipment_tags.equipment_id", "LEFT")
                                ->join("plants", "plants.id = equipment_tags.plant_id", "LEFT")
                                ->where('equipment_tags.id', $tag_id)
                                ->get()
                                ->row_array();
            $msg = $resultTags['equipment_name']." from plant: ".$resultTags['plant_name']." with tag no: ".$resultTags['tag_no']." is under maintenance.";
            if($status){
                $msg = $resultTags['equipment_name']." from plant: ".$resultTags['plant_name']." with tag no: ".$resultTags['tag_no']." is now release from maintenance.";
            }
            $this->send_notification($deviceIds, $msg);
            // send push notification end
            $this->db->trans_complete();

            if($this->db->trans_status()){
                $this->response([
                    'status' => TRUE,
                    'message' => "Note added successfully.",
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => "Some error occured from server. Try again later.",
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            $this->response([
                    'status' => FALSE,
                    'message' => "Provide user_id, note, tag_no and activity.",
                ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function user_maintenance_post(){
        $user_id = $this->post("user_id");
        $tag_no = $this->post("tag_no");

        if(!empty($user_id) && !empty($tag_no)){
            $resData = $this->activity->get_maintenance_history($user_id, $tag_no);
            // echo "<pre>"; print_r($resData);die;
            if(!empty($resData)){
                $this->response([
                    'status' => TRUE,
                    'message' => 'Data found.',
                    'data' => $resData
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'No data found.',
                    'data' => []
                ], REST_Controller::HTTP_OK);
            }
        }else{
            $this->response([
                'status' => FALSE,
                'message' => "Provide user_id and tag_no.",
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function reason_get(){
        $resultReason = $this->db->get_where('reasons', array('status'=>1))->result_array();

        if(!empty($resultReason)){
            $this->response([
                'status'    =>TRUE,
                'message'   =>"Reason fetched successfully.",
                'data'      =>$resultReason
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status'    =>FALSE,
                'message'   =>"Some error occured from server. Try again later."
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function routine_activity_post(){
        $tagNo = $this->input->post('tag_no');
        $comment = $this->post('comment');
        $user_id = $this->post('user_id');
        if(!empty($tagNo) && !empty($comment)){
            $tag_id = $this->getTagId($tagNo);
            $arrData = array(
                'tag_id'=>$tag_id,
                'comment'=>$comment,
                'created_at'=>date('Y-m-d H:i:s'),
                'created_by'=>$user_id
            );
            $this->db->trans_start();
            $this->db->insert("routine_activity", $arrData);
            // send push notification start
            // get device ids
            $deviceIds = $this->getDeviceIds($user_id);
            // for fcm message notification
            $resultTags = $this->db->select("equipment_tags.id as tag_id, equipment_tags.equipment_id, equipment_tags.plant_id, equipment_tags.tag_no, equipment_tags.equipment_use, equipment_tags.qr, equipment_tags.status, equipments.name as equipment_name, plants.name as plant_name")
                                ->from("equipment_tags")
                                ->join("equipments", "equipments.id = equipment_tags.equipment_id", "LEFT")
                                ->join("plants", "plants.id = equipment_tags.plant_id", "LEFT")
                                ->where('equipment_tags.id', $tag_id)
                                ->get()
                                ->row_array();
            $msg = $resultTags['equipment_name']." from plant: ".$resultTags['plant_name']." with tag no: ".$resultTags['tag_no']." routine activity ".$comment;
            $this->send_notification($deviceIds, $msg);
            // send push notification end
            $this->db->trans_complete();
            if($this->db->trans_status()){
                $this->response([
                    'status' => TRUE,
                    'message' => "Routine activity added successfully.",
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => "Some error occured from server. Try again later.",
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            $this->response([
                'status' => FALSE,
                'message' => "Provide tag_no, comment and user_id.",
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function routine_activity_get_post(){
        $user_id = $this->input->post('user_id');
        $tag_no = $this->input->post('tag_no');

        // $tag_id = $this->getTagId($tag_no);

        if(!empty($user_id) && !empty($tag_no)){
            $resultData = $this->activity->get_activity( $tag_no, $user_id );

            if(!empty($resultData)){
                $this->response([
                    'status'    =>TRUE,
                    'message'   =>"Routine activity fetched successfully.",
                    'data'      =>$resultData
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status'    =>FALSE,
                    'message'   =>"Routine activity not found.",
                    'data'      =>$resultData
                ], REST_Controller::HTTP_OK);
            }
        }else{
            $this->response([
                'status' => FALSE,
                'message' => "Provide user_id and tag_no.",
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /* Admin webservices start*/
    public function task_allocate_post( $id = NULL ){
        $user_id = $this->input->post('user_id');
        $task = $this->input->post('task');
        $assignee = $this->input->post('assignee');

        $task_id = $id;

        if(!empty($user_id) && !empty($task) && !empty($assignee)){
            $dataArr = array(
                'task'          =>$task,
                'assignee'      =>$assignee,
            );
            
            if($task_id){
                $dataArr['updated_at'] = date('Y-m-d H:i:s');
                $dataArr['updated_by'] = $user_id;
            }else{
                $dataArr['created_at'] = date('Y-m-d H:i:s');
                $dataArr['created_by'] = $user_id;
            }

            $this->db->trans_complete();
            if($task_id){
                $this->db->update("user_tasks", $dataArr);
                $msg = "User task updated successfully.";
            }else{
                $this->db->insert("user_tasks", $dataArr);
                $msg = "User task created successfully.";
            }

            $deviceIds = $this->getDeviceIds($assignee);
            
            $this->send_notification($deviceIds, $task.' '.$msg);
            $this->db->trans_complete();

            if($this->db->trans_status()){
                $this->response([
                    'status'    =>TRUE,
                    'message'   =>$msg,
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => "Some error occured from server. Try again later.",
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            $this->response([
                'status' => FALSE,
                'message' => "Provide user_id, task and assignee.",
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function admin_tasks_get( $user_id ){
        $resData = $this->db->query("SELECT 
                                        `user_tasks`.*,
                                        (
                                            CASE
                                                WHEN `user_tasks`.`status` = 0 THEN 'Pending' ELSE 'Completed'
                                            END
                                        ) task_status,
                                        CONCAT_WS(' ', `helper`.`first_name`, `helper`.`last_name`) AS `assignee_name`,
                                        CONCAT_WS(' ', `users`.`first_name`, `users`.`last_name`) AS `admin_name`
                                    FROM `user_tasks`
                                    LEFT JOIN `users` ON `users`.`id` = `user_tasks`.`created_by`
                                    LEFT JOIN `users` `helper` ON `helper`.`id` = `user_tasks`.`assignee`
                                    WHERE `user_tasks`.`created_by` = $user_id
                                ")->result_array();

        if(!empty($resData)){
            $this->response([
                'status' => FALSE,
                'message' => 'Data found.',
                'data' => $resData
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No data found.',
                'data' => []
            ], REST_Controller::HTTP_OK);
        }
    }

    public function user_tasks_post(){
        $user_id = $this->post('user_id');
        $assignee_id = $this->post('assignee');

        if(!empty($user_id) && !empty($assignee_id)){
            $resData = $this->db->query("SELECT 
                                            `user_tasks`.*,
                                            (
                                                CASE
                                                    WHEN `user_tasks`.`status` = 0 THEN 'Pending' ELSE 'Completed'
                                                END
                                            ) task_status,
                                            CONCAT_WS(' ', `helper`.`first_name`, `helper`.`last_name`) AS `assignee_name`,
                                            CONCAT_WS(' ', `users`.`first_name`, `users`.`last_name`) AS `admin_name`
                                        FROM `user_tasks`
                                        LEFT JOIN `users` ON `users`.`id` = `user_tasks`.`created_by`
                                        LEFT JOIN `users` `helper` ON `helper`.`id` = `user_tasks`.`assignee`
                                        WHERE `user_tasks`.`assignee` = $assignee_id
                                        ")->result_array();
            if(!empty($resData)){
                $this->response([
                    'status' => FALSE,
                    'message' => 'Data found.',
                    'data' => $resData
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'No data found.',
                    'data' => []
                ], REST_Controller::HTTP_OK);
            }
        }else{
           $this->response([
                'status' => FALSE,
                'message' => "Provide user_id and assignee.",
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    }

    public function admin_routine_activity_post(){
        $user_id = $this->post("user_id");

        // optional tag_no
        $tag_no = $this->post("tag_no");

        if( !empty($user_id) ){
            $user_ids = array_column($this->user->fetch_admin_users($user_id), 'id');
            $resultData = $this->activity->get_activity( $tag_no, $user_ids );

            if(!empty($resultData)){
                $this->response([
                    'status'    =>TRUE,
                    'message'   =>"Routine activity fetched successfully.",
                    'data'      =>$resultData
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status'    =>FALSE,
                    'message'   =>"Routine activity not found.",
                    'data'      =>$resultData
                ], REST_Controller::HTTP_OK);
            }
        }else{
            $this->response([
                'status' => FALSE,
                'message' => "Provide user_id.",
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    }

    public function maintenance_get(){

    }

    /* Admin webservices end*/
}