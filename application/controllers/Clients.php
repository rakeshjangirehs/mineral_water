<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('client');

        //validation config
        $this->client_validation_config = array(
            array(
                'field' => 'first_name',
                'label' => 'First Name',
                'rules' => 'required|max_length[200]'
            ),
            array(
                'field' => 'last_name',
                'label' => 'Last Name',
                'rules' => 'max_length[200]'
            ),
            array(
                'field' => 'credit_limit',
                'label' => 'Credit Limit',
                'rules' => 'numeric'
            ),
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'valid_email|max_length[300]|callback_check_duplicate_email'
            ),
            array(
                'field' => 'address',
                'label' => 'Address',
                'rules' => 'max_length[500]'
            ),

        );
	}

	public function index(){
		if($this->input->is_ajax_request()){
			$colsArr = array(
				'`clients`.`first_name`',
				'`clients`.`last_name`',
				'`clients`.`credit_limit`',
				'`clients`.`email`',
				'`clients`.`address`',
				'`zip_codes`.`zip_code`',
				'action'
			);

			$query = $this
						->model
						->common_select('clients.*,`zip_codes`.`zip_code`')
						->common_join('zip_codes','zip_codes.id = clients.zip_code_id','LEFT')
						->common_get('clients');

			echo $this->model->common_datatable($colsArr, $query, "clients.status = 'Active'");die;
		}
		$this->data['page_title'] = 'Client List';
		$this->load_content('client/client_list', $this->data);
	}

	public function add_update( $id = NULL ){

		$userArr = array(
			'first_name'	=> '',
			'last_name'		=> '',
			'address'		=> '',
			'credit_limit'  => '',
			'email'			=> '',
			'zip_code'	    => '',
		);

		if($id){
			$this->data['page_title'] = 'Update Client';
			$userArr = $this->client->get_client($id);
		}else{
			$this->data['page_title'] = 'Add Client';
		}

		if($this->input->server("REQUEST_METHOD") == "POST"){

            $this->form_validation->set_rules($this->client_validation_config);

            if ($this->form_validation->run() == TRUE) {

                $userData = array(
                    'first_name' => ($this->input->post('first_name')) ? $this->input->post('first_name') : NULL,
                    'last_name' => ($this->input->post('last_name')) ? $this->input->post('last_name') : NULL,
                    'address' => ($this->input->post('address')) ? $this->input->post('address') : NULL,
                    'credit_limit' => ($this->input->post('credit_limit')) ? $this->input->post('credit_limit') : NULL,
                    'zip_code_id' => ($this->input->post('zip_code_id')) ? $this->input->post('zip_code_id') : NULL,
                    'email' => ($this->input->post('email')) ? $this->input->post('email') : NULL,
                );

                // add or update records
                if ($this->client->insert_update($userData, $id)) {
                    $msg = 'Client created successfully.';
                    $type = 'success';
                    if ($id) {
                        $msg = "Client updated successfully.";
                        $this->flash($type, $msg);
                    } else {
                        $this->flash($type, $msg);
                    }
                } else {
                    $this->flash('error', 'Some error ocurred. Please try again later.');
                }
                redirect('clients', 'location');
            }
		}

        $this->data['zip_codes'] = $this->model->get("zip_codes");
		$this->data['id'] = $id;
		$this->data['user_data'] = $userArr;
		$this->load_content('client/add_update', $this->data);
	}

	public function client_export(){
		$query = $this
                    ->model
                    ->common_select('`clients`.`first_name`,`clients`.`last_name`,`clients`.`credit_limit`,`clients`.`email`,`clients`.`address`,`zip_codes`.`zip_code`')
                    ->common_join('zip_codes','zip_codes.id = clients.zip_code_id','LEFT')
                    ->common_get('clients');

		$resultData = $this->db->query($query)->result_array();
		$headerColumns = implode(',', array_keys($resultData[0]));
		$filename = 'clients-'.time().'.xlsx';
		$title = 'Client List';
		$sheetTitle = 'Client List';
		$this->export( $filename, $title, $sheetTitle, $headerColumns,  $resultData );
	}

	public function contacts($client_id,$contact_id=NULL){

        $this->data['client'] = $this->model->get("clients",$client_id,'id');
        $this->data['client_contacts'] = $this->model->get("client_contacts",$client_id,'client_id',true);
        $this->data['current_contact'] = ($contact_id) ? $this->model->get("client_contacts",$contact_id,'id') : array('person_name'=>'','phone'=>'','is_primary'=>"No");

        $this->data['page_title'] = 'Client Contacts';
        $this->data['sub_page_title'] = $this->data['client']['first_name'].' '.$this->data['client']['last_name'];

        $this->data['client_id'] = $client_id;
        $this->data['contact_id'] = $contact_id;
        $this->data['form_title'] = ($contact_id) ? "Update Client Contact" : "Add Client Contact";

        if($this->input->server("REQUEST_METHOD") == "POST"){

            $phone = $this->input->post('phone');

            // check username exist or not
            $existPhone = $this->client->check_contact_exist("phone", $phone, $contact_id);

            if($existPhone){
                $this->flash('error', 'Phone already exist.');
                redirect("clients/contacts/{$client_id}/{$contact_id}", 'location');
            }

            $data = array(
                'client_id'     =>  $client_id,
                'person_name'   =>  $this->input->post('person_name'),
                'phone'         =>  $phone,
                'is_primary'    =>  ($this->input->post('is_primary')=='Yes') ? 'Yes' : 'No',
            );

            if($this->client->insert_update_client_contact($data,$client_id,$contact_id)){
                $msg = 'Client Contact created successfully.';
                $type = 'success';
                if($contact_id){
                    $msg = "Client Contact updated successfully.";
                    $this->flash($type, $msg);
                }else{
                    $this->flash($type, $msg);
                }
            }else{
                $this->flash('error', 'Some error ocurred. Please try again later.');
            }

            redirect("clients/contacts/{$client_id}",'location');
        }

        $this->load_content('client/client_contact_list', $this->data);
    }


    public function check_duplicate_email($new_email){

	    $client_id = $this->uri->segment(3);

	    if($new_email && $this->client->check_exist("email", $new_email, $client_id)){
            $this->form_validation->set_message('check_duplicate_email',"Email id {$new_email} already exist.");
            return false;
        }else{
	        return true;
        }
    }

}