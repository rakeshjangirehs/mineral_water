	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking extends MY_Controller {

    public function __construct(){
        parent::__construct();
    }

    public function index(){

        $this->data['page_title'] = 'Live Tracking';
        $this->data['users'] = $this->db->get("users")->result_array();
        $this->data['no_breadcrumb'] = true;
        $this->load_content('tracking/tracking_map', $this->data);
    }
	
	public function saveLatLng(){
		$data = array(
			'lat'		=>	$this->input->post('lat'),
			'lng'		=>	$this->input->post('lng'),
			'user_id'	=>	$this->input->post('user_id'),
			'created_at'=>	date('Y-m-d H:i:s'),
			'created_by'=>	$this->input->post('user_id'),
		);
		
		echo json_encode($this->db->insert('coordinates',$data));
	}
	
	public function getLatLng(){
		$data = $this->db->query("SELECT `coordinates`.*,`users`.`username`,`users`.`email` FROM `coordinates` LEFT JOIN `users` ON `users`.`id` = `coordinates`.`user_id`")->result_array();
		
		echo json_encode($data);
	}
	
}