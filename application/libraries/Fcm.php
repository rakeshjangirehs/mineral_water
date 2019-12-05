<?php

class Fcm{

    private $CI = null;
    private $db = null;
    private $settings = null;

    public function __construct()
    {
        //use $this->fcm->function_name() in your controller/model
        $this->CI =& get_instance();
        $this->db = $this->CI->db;
        $this->settings = $this->CI->db->get('settings')->row_array();
    }

    /*
        @param $registration_ids array of device_ids.
        @param $msg message to send.
    */
    public function send( $user_arr = array(), $title='New Notification', $message = 'New Notification' ){

        $registration_ids = [];
        foreach($user_arr as $user){
            $registration_ids[] = $user['device_id'];
        }

        if($registration_ids){

            // API access key from Google FCM App Console
            define( 'API_ACCESS_KEY', 'AAAAMQEDeNc:APA91bHJlseCIESeljuCJ7uKv-5TQk1-_nFt6SljrCTXE9TjH4HjPSDbgjHSFExEtNYv6MgSiBsu6bernHEd0mJVZLDwzq5W1EBrDRJQ_6MTT1mdwbryQ3pXwzmNC3eLei676_1yADLn');

            //API URL of FCM
            $url = 'https://fcm.googleapis.com/fcm/send';

            //header includes Content type and api key
            $headers = array(
                'Content-Type:application/json',
                'Authorization:key='.API_ACCESS_KEY
            );

            /*
                vibrate - available in GCM, but not in FCM
            */
            $fcmMsg = array(
                'title' => $title,
                'body' => $message,
                'sound' => "default",
                    'color' => "#203E78" 
            );

            /*
                priority - options are normal and high, if not set, defaults to high.
                registration_ids -expects an array of ids.
                to - expecting a single ID
            */
            $fields = array(
                'registration_ids'  => $registration_ids,
                'priority'          => 'high',
                'notification'      => $fcmMsg
            );

            
            // Initate CURL to send fcm notification.

            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, $url );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
            $result = curl_exec($ch );

            // var_dump(curl_errno($ch));
            // var_dump(curl_getinfo($ch));
            // var_dump($result);die;
            
            // $response = array(
            //     'status'    =>  true,
            //     'message'   =>  'FCM Notification sent.',
            // );

            // if ($result === FALSE) {
            //     $response = array(
            //         'status'    =>  false,
            //         'message'   =>  curl_error($ch),
            //     );
            // }

            curl_close( $ch );

            $fcm_notifications_data = array(
                'title'     =>  $title,
                'message'   =>  $message,
                'response'  =>  $result
            );
            
            if($this->db->insert("fcm_notifications",$fcm_notifications_data)){
                $notification_id = $this->db->insert_id();
                
                $fcm_notification_user_data = [];
                
                foreach($user_arr as $k=>$user_notify){
                    $fcm_notification_user_data[] = array(
                        'user_id'           =>  $user_notify['user_id'],
                        'notification_id'   =>  $notification_id,
                        'created_at'        =>  date('Y-m-d'),
                        'created_by'        =>  0,
                    );                    
                }

                $this->db->insert_batch("fcm_notification_user",$fcm_notification_user_data);
            }

        }else{
            echo 'no user';die;
        }

        /*
            HELP RESOURCES
            prep the bundle
            to see all the options for FCM to/notification payload: 
            https://firebase.google.com/docs/cloud-messaging/http-server-ref#notification-payload-support 
        */
    }

}