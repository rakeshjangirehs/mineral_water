<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        // Load the database library
        $this->load->database();
        
        $this->userTbl = 'users';
    }

    /*
     * Get rows from the users table
     */
    function getRows($params = array()){
        // echo "<pre>"; print_r($params);die;
        $resultUser = $this->db->select("users.id AS `user_id`, users.first_name, users.last_name, users.username, users.email, users.phone, user_types.id AS `role_id`, user_types.name AS `role`")
                 ->from("users")
                 ->join("user_roles", "user_roles.user_id = users.id", "LEFT")
                 ->join("user_types", "user_types.id = user_roles.user_type_id", "LEFT")
                 ->where("users.status", 1)
                 ->where("(users.email = '{$params['conditions']['email']}' OR users.username = '{$params['conditions']['email']}')")
                 ->where("users.password", $params['conditions']['password'])
                 ->get()
                 ->row_array();

        if(!empty($resultUser)){
            $resultDepartment = $this->db->query("SELECT 
                                                `user_departments`.`department_id`, 
                                                `departments`.`name` AS `department_name`
                                            FROM `user_departments`
                                            LEFT JOIN `users` ON `users`.`id` = `user_departments`.`user_id`
                                            LEFT JOIN `departments` ON `departments`.`id` = `user_departments`.`department_id`
                                            WHERE `user_departments`.`user_id` = {$resultUser['user_id']}
                                            ")->result_array();

            $resultUser['departments'] = $resultDepartment;
        }

        return $resultUser;
    }
    
    /*
     * Insert user data
     */
    public function insert_update($data, $roleArr,$user_id = NULL){
        
        $this->db->trans_start();
        if($user_id){
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['updated_by'] = USER_ID;

            $this->db->where("id", $user_id);
            $this->db->update("users", $data);

            // delete old roles data
            $this->db->delete("user_roles", array("user_id"=>$user_id));
        }else{
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = USER_ID;
            $this->db->insert("users", $data);
            $user_id = $this->db->insert_id();
        }
        if(!empty($roleArr)){
            foreach( $roleArr as &$role ){
                $role['user_id'] = $user_id;
            }
        }

        $this->db->insert_batch("user_roles", $roleArr);

        $this->db->trans_complete();
        if($this->db->trans_status()){
            return $user_id;
        }else{
            return false;
        }
    }

    public function get_admins($id = NULL){
        return $this->db->select("users.*")
                        ->from("users")
                        ->join("user_roles", "user_roles.user_id = users.id", "left")
                        ->join("user_types", "user_types.id = user_roles.user_type_id", "left")
                        ->where("user_types.id", 1)
                        ->where("user_types.status", 1)
                        ->where("users.status", 1)
                        // ->where_not_in("users.id", array($id))
                        ->get()
                        ->result_array();
    }

    public function get_user($id){
        // echo "<pre>"; var_dump($id);die;

        return $this->db->select("users.*, user_types.name as role_name, u.first_name as reportee, user_types.id as user_type_id")
                        ->from("users")
                        ->join("users u", "u.id = users.reporting_to", "left")
                        ->join("user_roles", "user_roles.user_id = users.id", "left")
                        ->join("user_types", "user_types.id = user_roles.user_type_id", "left")
                        ->where("users.id", $id)
                        ->get()
                        ->row_array();
    }

    public function check_exist( $whereKey, $whereVal, $id = NULL ){
        if($id){
            $res = $this->db->select("*")
                            ->from("users")
                            ->where("$whereKey", $whereVal)
                            ->where_not_in("users.id", array($id))
                            ->get();
        }else{
            $res = $this->db->select("*")
                            ->from("users")
                            ->where("$whereKey", $whereVal)
                            ->get();
        }
        return $res->row_array();
    }

    public function valid_username(){
        echo 'Hello';die;
    }

    public function fetch_admin_users( $user_id = NULL ){
        return $this->db->query("SELECT 
                            users.*,
                            `user_types`.`name` AS `role`,
                            `user_roles`.`user_type_id`
                        FROM `users`
                        LEFT JOIN `user_roles` ON `user_roles`.`user_id` = `users`.`id`
                        LEFT JOIN `user_types` ON `user_types`.`id` = `user_roles`.`user_type_id`
                        WHERE `users`.`reporting_to` = $user_id
                    ")->result_array();
    }

}