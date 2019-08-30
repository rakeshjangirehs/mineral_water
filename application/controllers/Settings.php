<?php  
 defined('BASEPATH') OR exit('No direct script access allowed'); 
 /** Developer: Milan Soni 
  * Created Date: 2019-08-30 11:40:21 
  * Created By : CLI 
 */ 
 
 class Settings extends MY_Controller {
 
 	public function __construct() {
 	 	parent::__construct();
 	 	$this->load->model('settings_model');
 	}

 	public function index(){
 		$this->load->library('form_validation');
 		if(isset($_GET['q'])){
 			$option = $_GET['q'];

 			switch ($option) {
 				case 'smtp':
 					$this->form_validation->set_rules('smtp_host', 'SMTP Host', 'trim|required');
					$this->form_validation->set_rules('username', 'SMTP User', 'trim|required');
					$this->form_validation->set_rules('password', 'SMTP Password', 'trim|required');
					$this->form_validation->set_rules('from_name', 'Person Name', 'trim|required');

					if ($this->form_validation->run() == TRUE)
				    {
				    	$dataSmtp = array(
				    		'email_host'		=>$this->input->post('smtp_host'),
				    		'username'		=>$this->input->post('username'),
				    		'password'		=>$this->input->post('password'),
				    		'from_name'		=>$this->input->post('from_name'),
				    	);

				    	if($this->settings_model->add_update_smtp($dataSmtp)){
			    			$this->flash('success', 'SMTP updated successfully.');
				    	}else{
				    		$this->flash('success', 'SMTP failed to update.');
				    	}
				    	redirect('settings?q=smtp', 'location');
				    }
 					break;
 				
 				default:
 					# code...
 					break;
 			}


 		}else{
 			redirect('settings?q=system_setting', 'location');
 		}

 		$this->data['smtp'] = $this->db->get('settings')->row_array();
 		$this->data['page_title'] = 'Settings';
		$this->load_content('setting/setting', $this->data);
 	}

 	public function save_system_setting(){
 		// load validation library
 		$this->load->library('form_validation');

 		$this->form_validation->set_rules('smtp_host', 'SMTP Host', 'trim|required');
		$this->form_validation->set_rules('username', 'SMTP User', 'trim|required');
		$this->form_validation->set_rules('password', 'SMTP Password', 'trim|required');
		$this->form_validation->set_rules('from_name', 'Person Name', 'trim|required');

		if ($this->form_validation->run() == TRUE)
	    {
	    	
	    }


 	}
 }