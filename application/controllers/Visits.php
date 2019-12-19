<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visits extends MY_Controller {

	public function __construct(){
		parent::__construct();
		// $this->load->model('visit');
	}

	public function index(){

		if($this->input->is_ajax_request()){

			$colsArr = array(
				'visit_mode',
				'client_name',
				'visit_date',
				'visit_type',
				'opportunity',
                'visit_notes',
                'created_by_emp',
                'action'
            );
            
            $whr = "";
            if($_REQUEST['date']){
                // echo json_encode($_REQUEST['date']);die;
                $whr = "WHERE visit_date = '{$_REQUEST['date']}'";
            }

            $query = "SELECT
                        clients.client_name,                        
                        CONCAT(client_visits.visit_date,' ',client_visits.visit_time) AS `visit_date`,
                        client_visits.visit_type,
                        client_visits.opportunity,
                        client_visits.visit_notes,
                        CONCAT(users.first_name,' ',IFNULL(users.last_name,'')) AS created_by_emp,
                        'Client Visit' AS `visit_mode`
                        FROM client_visits
                        LEFT JOIN clients ON clients.id = client_visits.client_id
                        LEFT JOIN users ON users.id = client_visits.created_by
                        {$whr}
                        UNION
                        SELECT
                        leads.company_name AS client_name,                        
                        CONCAT(lead_visits.visit_date,' ',lead_visits.visit_time) AS `visit_date`,
                        lead_visits.visit_type,
                        lead_visits.opportunity,
                        lead_visits.visit_notes,
                        CONCAT(users.first_name,' ',IFNULL(users.last_name,'')) AS created_by_emp,
                        'Lead Visit' AS `visit_mode`
                        FROM lead_visits
                        LEFT JOIN leads ON leads.id = lead_visits.lead_id
                        LEFT JOIN users ON users.id = lead_visits.created_by
                        {$whr}";

			echo $this->model->common_datatable($colsArr, $query, "",NULL,true);die;
		}

        $this->data['page_title'] = 'Followup List';
		$this->load_content('visits/visit_list', $this->data);
	}
}