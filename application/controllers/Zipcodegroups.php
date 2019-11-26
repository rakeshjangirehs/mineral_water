<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zipcodegroups extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('zipcodegroup');

		//validation config
		$this->zipcodegroup_validation_config = array(
            array(
                'field' => 'group_name',
                'label' => 'ZIP Code Group Name',
                'rules' => 'required'
            ),
            array(
                'field' => 'zip_code[]',
                'label' => 'ZIP Code',
                'rules' => 'required'
            ),
        );
	}

	public function index($zipcode_group_id=null){

	    $this->data['zipcode_group_id'] = $zipcode_group_id;

        $this->data['cities'] = [];
        $all_zip_code_where = [];
        
	    if($zipcode_group_id){
            $this->data['form_title'] = "Update ZIP Code Group";
            $group_details = $this->model->get("zip_code_groups",$zipcode_group_id,"id");
            
            $this->data['group_details'] = $group_details;
            $this->data['group_zip_codes'] = array_column($this->model->get("group_to_zip_code",$zipcode_group_id,"zip_code_group_id",true),'zip_code_id');
            
            
            if($state_id = $group_details['state_id']){
                $this->data['cities'] = $this->db->get_where('cities',["is_deleted"=>0,'state_id'=>$state_id])->result_array();
                $all_zip_code_where["state_id"] = $state_id;
            }

            if($city_id = $group_details['city_id']){
                $all_zip_code_where["city_id"] = $city_id;
            }

        }else{
            $this->data['form_title'] = "Add ZIP Code Group";
            $this->data['group_details'] = array('id'=>null,'group_name'=>null,'state_id'=>null,'city_id'=>null);
            $this->data['group_zip_codes'] = [];
        }


		if($this->input->is_ajax_request()){
			$colsArr = array(
				'group_name',
                'zip_codes',
				'action'
			);

            $query = $this
                ->model
                ->common_select('`zip_code_groups`.`id`,`zip_code_groups`.`group_name`,GROUP_CONCAT(`zip_codes`.`zip_code`) AS `zip_codes`,zip_code_groups.status')
                ->common_join('`group_to_zip_code`','`group_to_zip_code`.`zip_code_group_id` = `zip_code_groups`.`id`','LEFT')
                ->common_join('`zip_codes`','`zip_codes`.`id` = `group_to_zip_code`.`zip_code_id`','LEFT')
                ->common_group_by("`zip_code_groups`.`id`")
                ->common_get('`zip_code_groups`');

			echo $this->model->common_datatable($colsArr, $query, "status = 'Active'",NULL,true);die;
		}

        if($this->input->server("REQUEST_METHOD") == "POST"){

            // echo "<pre>";print_r($_POST);die;

            $this->form_validation->set_rules($this->zipcodegroup_validation_config);

            if ($this->form_validation->run() == TRUE){
                $zip_code = $this->input->post('zip_code');
                
                $data = array(
                    'group_name'  =>  ($this->input->post('group_name')) ? $this->input->post('group_name') : null,
                    'state_id'  =>  ($this->input->post('state_id')) ? $this->input->post('state_id') : null,
                    'city_id'  =>  ($this->input->post('city_id')) ? $this->input->post('city_id') : null,
                );

                if($this->zipcodegroup->insert_update($data, $zip_code,$zipcode_group_id)){
                    $msg = 'ZIP Code Group created successfully.';
                    $type = 'success';
                    if($zipcode_group_id){
                        $msg = "ZIP Code Group updated successfully.";
                        $this->flash($type, $msg);
                    }else{
                        $this->flash($type, $msg);
                    }
                }else{
                    $this->flash('error', 'Some error ocurred. Please try again later.');
                }
                redirect("zipcodegroups/index/{$zipcode_group_id}",'location');
            }else{
                if($state_id = $this->input->post('state_id')){
                    $this->data['cities'] = $this->db->get_where('cities',["is_deleted"=>0,'state_id'=>$state_id])->result_array();
                    $all_zip_code_where["state_id"] = $state_id;
                }

                if($city_id = $this->input->post('city_id')){
                    $all_zip_code_where["city_id"] = $city_id;
                }
            }
        }

        $this->data['page_title'] = 'ZipCode Groups';
        $this->data['states'] = $this->model->get('states',"0","is_deleted",true);
        $this->data['all_zipcodes'] = array_column($this->db->get_where("zip_codes",$all_zip_code_where)->result_array(),"zip_code","id");
		$this->load_content('zipcodegroup/zipcodegroup_list', $this->data);
	}

    public function sendMail(){
//        $this->commonSendMail();
        $this->load->library('mymailer');

        $a = array(
            FCPATH.'files/assets/images/logo.png',
            FCPATH.'files/assets/images/logo-blue.png'
        );
        var_dump($this->mymailer->send_email("test","test","rakeshj@letsenkindle.com",null,null,$a));

    }
}