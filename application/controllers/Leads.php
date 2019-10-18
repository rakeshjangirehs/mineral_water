<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leads extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('lead');

		//validation config
		$this->lead_validation_config = array(
            array(
                'field' => 'first_name',
                'label' => 'Name',
                'rules' => 'required'
            ),
        );
	}

	public function index($zipcode_group_id=null){

	    $this->data['zipcode_group_id'] = $zipcode_group_id;

        $this->data['cities'] = [];
        $all_zip_code_where = [];
        
	    if($zipcode_group_id){
            $this->data['form_title'] = "Update Lead";            
            $group_details = $this->db->get_where("leads",["id"=>$zipcode_group_id])->row_array();
            
            $this->data['group_details'] = $group_details;            
        }else{
            $this->data['form_title'] = "Add Lead";
            $this->data['group_details'] = array(
                'id'=>null,
                'first_name'=>null,
                'last_name'=>null,
                'email'=>null,
                'phone'=>null,
            );
        }


		if($this->input->is_ajax_request()){
			$colsArr = array(
				'first_name',
                'last_name',
                'email',
                'phone',
				'action'
			);

            $query = $this
                ->model
                ->common_select('`leads`.*')
                ->common_get('`leads`');

			echo $this->model->common_datatable($colsArr, $query, "is_deleted = 0");die;
		}

        if($this->input->server("REQUEST_METHOD") == "POST"){


            $this->form_validation->set_rules($this->lead_validation_config);

            if ($this->form_validation->run() == TRUE){
                
                $data = array(
                    'first_name'  =>  ($this->input->post('first_name')) ? $this->input->post('first_name') : null,
                    'last_name'  =>  ($this->input->post('last_name')) ? $this->input->post('last_name') : null,
                    'email'  =>  ($this->input->post('email')) ? $this->input->post('email') : null,
                    'phone'  =>  ($this->input->post('phone')) ? $this->input->post('phone') : null,
                );

                if($this->lead->insert_update($data,$zipcode_group_id)){
                    $msg = 'Lead Created Successfully.';
                    $type = 'success';
                    if($zipcode_group_id){
                        $msg = "Lead Updated Successfully.";
                        $this->flash($type, $msg);
                    }else{
                        $this->flash($type, $msg);
                    }
                }else{
                    $this->flash('error', 'Some error ocurred. Please try again later.');
                }
                redirect("leads",'location');
            }
        }

        $this->data['page_title'] = 'Leads';
		$this->load_content('leads/lead_list', $this->data);
	}

    public function delete($vehicle_id){
        if($this->db->update("leads",array('is_deleted'=>1),array('id'=>$vehicle_id))){
            $this->flash("success","Lead Deleted Successfully");
        }else{
            $this->flash("error","Lead not Deleted");
        }
        redirect("vehicles/index");
    }
}