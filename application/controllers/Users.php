<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property user $user
 * @property model $model
 */

class Users extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('user');
	}

	public function index(){
		if($this->input->is_ajax_request()){
			$colsArr = array(
				'`users`.`first_name`',
				'`users`.`last_name`',
				'`users`.`username`',
				'`users`.`email`',
				'`users`.`phone`',
				'`roles`.`role_name`',
				'action'
			);

			$query = $this
						->model
						->common_select('users.*,`roles`.`role_name`,GROUP_CONCAT(DISTINCT zip_codes.zip_code) AS user_zip_codes,GROUP_CONCAT(DISTINCT zip_code_groups.group_name ORDER BY zip_code_groups.group_name) AS user_zip_code_groups')
						->common_join('roles','roles.id = users.role_id','LEFT')
						->common_join('user_zip_codes','user_zip_codes.user_id = users.id','LEFT')
						->common_join('zip_codes','user_zip_codes.zip_code_id = zip_codes.id','LEFT')
                        ->common_join('user_zip_code_groups','user_zip_code_groups.user_id = users.id','LEFT')
                        ->common_join('zip_code_groups','user_zip_code_groups.zip_code_group_id = zip_code_groups.id','LEFT')
						->common_get('users');

			echo $this->model->common_datatable($colsArr, $query, "users.status = 1","`users`.`id`");die;
		}
		$this->data['page_title'] = 'User List';
		$this->load_content('user/user_list', $this->data);
	}

	public function add_update( $id = NULL ){
		$userArr = array(
			'first_name'	=> '',
			'last_name'		=> '',
			'username'		=> '',
			'email'			=> '',
			'phone'			=> '',
            'role_id'       =>  '',
		);
		if($id){
			$this->data['page_title'] = 'Update User';
			$userArr = $this->user->get_user($id);
//			echo "<pre>";print_r($userArr);die;
		}else{
			$this->data['page_title'] = 'Add User';
		}

		if($this->input->server("REQUEST_METHOD") == "POST"){

//		    echo "<pre>";print_r($_POST);die;

			$username = $this->input->post('username');
			$email = $this->input->post('email');
			$phone = $this->input->post('phone');
			$zip_code_group = $this->input->post('zip_code_group');
			$zip_codes = $this->input->post('zip_codes');

			// check username exist or not
			$existUsername = $this->user->check_exist("username", $username, $id);
			$existEmail = $this->user->check_exist("email", $email, $id);
			$existPhone = $this->user->check_exist("phone", $phone, $id);


			if($existUsername){
				$this->flash('error', 'Username already exist.');
				redirect('users/add_update/'.$id, 'location');
			}
			if($existEmail){
				$this->flash('error', 'Email already exist.');
				redirect('users/add_update/'.$id, 'location');
			}
			if($existPhone){
				$this->flash('error', 'Phone already exist.');
				redirect('users/add_update/'.$id, 'location');
			}

			$userData = array(
				'first_name'	=>$this->input->post('first_name'),
				'last_name'		=>$this->input->post('last_name'),
				'phone'			=>$phone,
				'email'			=>$email,
				'username'		=>$username,
                'role_id'       =>$this->input->post('role'),
			);

            if($password = $this->input->post('password')){
                $userData['password'] = $password;
            }

			// add or update records
			if($this->user->insert_update($userData,$zip_codes,$zip_code_group,$id)){
				$msg = 'User created successfully.';
				$type = 'success';
				if($id){
					$msg = "User updated successfully.";
					$this->flash($type, $msg);
				}else{
					$this->flash($type, $msg);
				}
			}else{
				$this->flash('error', 'Some error ocurred. Please try again later.');
			}
			redirect('users','location');
		}
		$this->data['roles'] = $this->model->get("roles");
		$this->data['id'] = $id;
		$this->data['user_data'] = $userArr;
        $this->data['zip_code_groups'] = array_column($this->model->get('zip_code_groups'),"group_name","id");
        $this->data['zip_codes'] = array_column($this->model->get('zip_codes'),"zip_code","id");

		$this->load_content('user/add_update', $this->data);
	}

	public function user_export(){
		$query = $this
            ->model
            ->common_select('`users`.`first_name`,`users`.`last_name`,`users`.`username`,`users`.`email`,`users`.`phone`,`roles`.`role_name`,GROUP_CONCAT(DISTINCT zip_codes.zip_code) AS user_zip_codes,GROUP_CONCAT(DISTINCT zip_code_groups.group_name ORDER BY zip_code_groups.group_name) AS user_zip_code_groups')
            ->common_join('roles','roles.id = users.role_id','LEFT')
            ->common_join('user_zip_codes','user_zip_codes.user_id = users.id','LEFT')
            ->common_join('zip_codes','user_zip_codes.zip_code_id = zip_codes.id','LEFT')
            ->common_join('user_zip_code_groups','user_zip_code_groups.user_id = users.id','LEFT')
            ->common_join('zip_code_groups','user_zip_code_groups.zip_code_group_id = zip_code_groups.id','LEFT')
            ->common_group_by('`users`.`id`')
            ->common_get('users');

		$resultData = $this->db->query($query)->result_array();
		$headerColumns = implode(',', array_keys($resultData[0]));
		$filename = 'users-'.time().'.xlsx';
		$title = 'User List';
		$sheetTitle = 'User List';
		$this->export( $filename, $title, $sheetTitle, $headerColumns,  $resultData );
	}
}