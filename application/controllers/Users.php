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

        //validation config
        $this->user_validation_config = array(
            array(
                'field' => 'first_name',
                'label' => 'First Name',
                'rules' => 'required|max_length[200]'
            ),
            array(
                'field' => 'last_name',
                'label' => 'Last Name',
                'rules' => 'required|max_length[200]'
            ),
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|valid_email|max_length[300]|callback_check_duplicate_email'
            ),
            array(
                'field' => 'username',
                'label' => 'username',
                'rules' => 'max_length[200]|callback_check_duplicate_username'
            ),
            array(
                'field' => 'phone',
                'label' => 'Phone',
                'rules' => 'integer|max_length[50]|callback_check_duplicate_phone'
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|max_length[200]'
            ),
            array(
                'field' => 'role',
                'label' => 'Role',
                'rules' => 'required|max_length[200]'
            ),
            array(
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required|max_length[200]'
            ),
            array(
                'field' => 'zip_codes[]',
                'label' => 'Zipcode',
                'rules' => 'required'
            ),

        );
	}

	public function index(){
		if($this->input->is_ajax_request()){
			$colsArr = array(
				'`first_name`',
				'`last_name`',
				'`username`',
				'`email`',
				'`phone`',
				'`role_name`',
				'`user_zip_codes`',
				'`user_zip_code_groups`',
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
                        ->common_group_by("`users`.`id`")
						->common_get('users');

            echo $this->model->common_datatable($colsArr, $query, "status = 'Active'",NULL,true);die;
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
			$userArr = $this->user->get_user_by_id($id)[0];
//			echo "<pre>";print_r($userArr);die;
		}else{
			$this->data['page_title'] = 'Add User';
		}

		if($this->input->server("REQUEST_METHOD") == "POST"){

            $this->form_validation->set_rules($this->user_validation_config);

            if ($this->form_validation->run() == TRUE) {

                $zip_code_group = $this->input->post('zip_code_group');
                $zip_codes = $this->input->post('zip_codes');

                $userData = array(
                    'first_name' => ($this->input->post('first_name')) ? $this->input->post('first_name') : NULL,
                    'last_name' => ($this->input->post('last_name')) ? $this->input->post('last_name') : NULL,
                    'phone' => ($this->input->post('phone')) ? $this->input->post('phone') : NULL,
                    'email' => ($this->input->post('email')) ? $this->input->post('email') : NULL,
                    'username' => ($this->input->post('username')) ? $this->input->post('username') : NULL,
                    'role_id' => ($this->input->post('role')) ? $this->input->post('role') : NULL,
                );

                if ($password = $this->input->post('password')) {
                    $userData['password'] = $password;
                }

                // add or update records
                if ($this->user->insert_update($userData, $zip_codes, $zip_code_group, $id)) {
                    $msg = 'User created successfully.';
                    $type = 'success';
                    if ($id) {
                        $msg = "User updated successfully.";
                        $this->flash($type, $msg);
                    } else {
                        $this->flash($type, $msg);
                    }
                } else {
                    $this->flash('error', 'Some error ocurred. Please try again later.');
                }
                redirect('users', 'location');
            }
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

    public function check_duplicate_email($new_email){

        $client_id = $this->uri->segment(3);

        if($new_email && $this->user->check_exist("email", $new_email, $client_id)){
            $this->form_validation->set_message('check_duplicate_email',"Email id {$new_email} already exist.");
            return false;
        }else{
            return true;
        }
    }

    public function check_duplicate_username($new_username){

        $client_id = $this->uri->segment(3);

        if($new_username && $this->user->check_exist("username", $new_username, $client_id)){
            $this->form_validation->set_message('check_duplicate_username',"username {$new_username} already exist.");
            return false;
        }else{
            return true;
        }
    }

    public function check_duplicate_phone($new_phone){

        $client_id = $this->uri->segment(3);

        if($new_phone && $this->user->check_exist("phone", $new_phone, $client_id)){
            $this->form_validation->set_message('check_duplicate_phone',"Phone {$new_phone} already exist.");
            return false;
        }else{
            return true;
        }
    }
}