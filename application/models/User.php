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
        $resultUser = $this->db->select("users.id AS `user_id`, users.first_name, users.last_name, users.username, users.email, users.phone, roles.role_name `role`")
                 ->from("users")
                 ->join("roles", "roles.id = users.role_id", "LEFT")
                 ->where("users.status", 'Active')
                 ->where("(users.email = '{$params['conditions']['email']}' OR users.username = '{$params['conditions']['email']}')")
                 ->where("users.password", $params['conditions']['password'])
                 ->get()
                 ->row_array();
        return $resultUser;
    }
    
    /*
     * Insert user data
     */
    public function insert_update($data,$new_zip_codes,$new_zip_code_groups,$user_id = NULL){

        $old_zip_codes = ($user_id) ? array_column($this->model->get("user_zip_codes",$user_id,"user_id",true),'zip_code_id') : [];
        $removable_zip_codes = array_diff($old_zip_codes,$new_zip_codes);
        $insertable_zip_codes = array_diff($new_zip_codes,$old_zip_codes);

        $old_zip_code_groups = ($user_id) ? array_column($this->model->get("user_zip_code_groups",$user_id,"user_id",true),'zip_code_group_id') : [];
        $removable_zip_code_groups = array_diff($old_zip_code_groups,$new_zip_code_groups);
        $insertable_zip_code_groups = array_diff($new_zip_code_groups,$old_zip_code_groups);

        $this->db->trans_start();
        if($user_id){
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['updated_by'] = USER_ID;

            $this->db->where("id", $user_id);
            $this->db->update("users", $data);

        }else{
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = USER_ID;
            $this->db->insert("users", $data);
            $user_id = $this->db->insert_id();
        }

        if($removable_zip_codes){
            $removable_zip_codes_str = implode(",",$removable_zip_codes);
            $delete_query = "DELETE FROM `user_zip_codes` WHERE `user_zip_codes`.`zip_code_id` IN ({$removable_zip_codes_str}) AND `user_zip_codes`.`user_id` = {$user_id}";
            $this->db->query($delete_query);
        }

        if($insertable_zip_codes){
            $insertable_zip_codes_arr = [];
            foreach($insertable_zip_codes as $k=>$zip_code){
                if($zip_code){
                    $insertable_zip_codes_arr[] = array(
                        'user_id' => $user_id,
                        'zip_code_id'  => $zip_code,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => USER_ID,
                    );
                }
            }
            if($insertable_zip_codes_arr){
                $this->db->insert_batch("user_zip_codes",$insertable_zip_codes_arr);
            }
        }

        if($removable_zip_code_groups){
            $removable_zip_code_groups_arr = implode(",",$removable_zip_code_groups);
            $delete_query = "DELETE FROM `user_zip_code_groups` WHERE `user_zip_code_groups`.`zip_code_group_id` IN ({$removable_zip_code_groups_arr}) AND `user_zip_code_groups`.`user_id` = {$user_id}";
            $this->db->query($delete_query);
        }

        if($insertable_zip_code_groups){
            $insertable_zip_code_groups_arr = [];
            foreach($insertable_zip_code_groups as $k=>$zip_code_group){
                if($zip_code_group){
                    $insertable_zip_code_groups_arr[] = array(
                        'user_id' => $user_id,
                        'zip_code_group_id'  => $zip_code_group,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => USER_ID,
                    );
                }
            }
            if($insertable_zip_code_groups_arr){
                $this->db->insert_batch("user_zip_code_groups",$insertable_zip_code_groups_arr);
            }
        }

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

    public function get_user($where=null){

        $query =  $this->db->select("users.*, roles.role_name as role_name,GROUP_CONCAT(DISTINCT `user_zip_codes`.`zip_code_id`) AS `user_zip_codes`,GROUP_CONCAT(DISTINCT `user_zip_code_groups`.`zip_code_group_id`) AS `user_zip_code_groups`")
                        ->from("users")
                        ->join("roles", "roles.id = users.role_id", "left")
                        ->join("user_zip_codes", "user_zip_codes.user_id = users.id", "left")
                        ->join("user_zip_code_groups", "user_zip_code_groups.user_id = users.id", "left")
                        ->group_by("users.id");
        if($where)  $query->where($where);

                    return $query
                            ->get()
                            ->result_array();
    }

    public function get_user_by_id($id){
        $where = "users.id = {$id}";
        return $this->get_user($where);
    }

    public function get_user_by_role($id){
        $where = "roles.id = {$id}";
        return $this->get_user($where);
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