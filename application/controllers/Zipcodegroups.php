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
        );
	}

	public function index($zipcode_group_id=null){

	    $this->data['zipcode_group_id'] = $zipcode_group_id;

	    if($zipcode_group_id){
            $this->data['form_title'] = "Update ZIP Code Group";
            $this->data['group_details'] = $this->model->get("zip_code_groups",$zipcode_group_id,"id");
            $this->data['group_zip_codes'] = array_column($this->model->get("group_to_zip_code",$zipcode_group_id,"zip_code_group_id",true),'zip_code_id');
        }else{
            $this->data['form_title'] = "Add ZIP Code Group";
            $this->data['group_details'] = array('id'=>null,'group_name'=>null);
            $this->data['group_zip_codes'] = [];
        }


		if($this->input->is_ajax_request()){
			$colsArr = array(
				'`zip_code_groups`.`group_name`',
                `zip_codes`.`zip_code`,
				'action'
			);

            $query = $this
                ->model
                ->common_select('`zip_code_groups`.`id`,`zip_code_groups`.`group_name`,GROUP_CONCAT(`zip_codes`.`zip_code`) AS `zip_codes`')
                ->common_join('`group_to_zip_code`','`group_to_zip_code`.`zip_code_group_id` = `zip_code_groups`.`id`','LEFT')
                ->common_join('`zip_codes`','`zip_codes`.`id` = `group_to_zip_code`.`zip_code_id`','LEFT')
                ->common_get('`zip_code_groups`');

			echo $this->model->common_datatable($colsArr, $query, "zip_code_groups.status = 'Active'","`zip_code_groups`.`id`");die;
		}

        if($this->input->server("REQUEST_METHOD") == "POST"){

            $this->form_validation->set_rules($this->zipcodegroup_validation_config);

            if ($this->form_validation->run() == TRUE){
                $zip_code = $this->input->post('zip_code');
                $group_name = $this->input->post('group_name');

                if($this->zipcodegroup->insert_update($group_name, $zip_code,$zipcode_group_id)){
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
            }
        }

        $this->data['all_zipcodes'] = array_column($this->model->get("zip_codes"),"zip_code","id");
//        echo "<pre>";print_r($this->data['all_zipcodes']);echo "</pre>";


		$this->data['page_title'] = 'ZipCode Groups';
		$this->load_content('zipcodegroup/zipcodegroup_list', $this->data);
	}
}