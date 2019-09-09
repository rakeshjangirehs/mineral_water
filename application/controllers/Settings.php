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

 	public function index($mode=NULL){

        $mode = ($mode) ? $mode : "system_setting";
        $this->data['mode'] = $mode;

        if($this->input->server("REQUEST_METHOD") == "POST"){

 			switch ($mode) {
 				case 'smtp':
 					$this->form_validation->set_rules('smtp_host', 'SMTP Host', 'trim|required');
					$this->form_validation->set_rules('username', 'SMTP User', 'trim|required');
					$this->form_validation->set_rules('password', 'SMTP Password', 'trim|required');
					$this->form_validation->set_rules('from_name', 'Person Name', 'trim|required');

					if ($this->form_validation->run() == TRUE)
				    {
				    	$dataSmtp = array(
				    		'email_host'	=>($this->input->post('smtp_host')) ? $this->input->post('smtp_host') : NULL,
				    		'username'		=>($this->input->post('username')) ? $this->input->post('username') : NULL,
				    		'password'		=>($this->input->post('password')) ? $this->input->post('password') : NULL,
				    		'from_name'		=>($this->input->post('from_name')) ? $this->input->post('from_name') : NULL,
				    	);

				    	if($this->settings_model->add_update($dataSmtp)){
			    			$this->flash('success', 'SMTP updated successfully.');
				    	}else{
				    		$this->flash('success', 'SMTP failed to update.');
				    	}
                        redirect("settings/index/{$mode}", 'location');
				    }
 					break;
                case 'maps':
                    $this->form_validation->set_rules('maps_api_key', 'API Key', 'trim|required');
                    $this->form_validation->set_rules('node_server_url', 'Node Server Url', 'trim|required');

                    if ($this->form_validation->run() == TRUE)
                    {
                        $dataSmtp = array(
                            'maps_api_key'	    =>($this->input->post('maps_api_key')) ? $this->input->post('maps_api_key') : NULL,
                            'node_server_url'	=>($this->input->post('node_server_url')) ? $this->input->post('node_server_url') : NULL,
                        );

                        if($this->settings_model->add_update_smtp($dataSmtp)){
                            $this->flash('success', 'Map Settings updated successfully.');
                        }else{
                            $this->flash('success', 'Map Settings failed to update.');
                        }
                        redirect("settings/index/{$mode}", 'location');
                    }
                    break;
 				case 'system_setting':

 					$this->form_validation->set_rules('system_name', 'System Name', 'trim|required');

 					if($this->form_validation->run() == TRUE){
 						$dataSystemSetting = array(
 							'system_name'=>$this->input->post('system_name')
 						);
 						if($this->settings_model->add_update($dataSystemSetting)){
			    			$this->flash('success', 'System setting updated successfully.');
				    	}else{
				    		$this->flash('success', 'System setting failed to update.');
				    	}
				    	redirect("settings/index/{$mode}", 'location');
 					}
 					break;
 				default:
 					# code...
 					break;
 			}
 		}
 		$this->data['smtp'] = $this->db->get('settings')->row_array();
 		$this->data['settings'] = $this->db->get('settings')->row_array();
 		$this->data['page_title'] = 'Settings';
		$this->load_content('setting/setting', $this->data);
 	}
 }