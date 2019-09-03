	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->data['users'] = $this->db
            ->select("users.*,roles.role_name")
            ->join("roles","roles.id = users.role_id","left")
            ->get("users")->result_array();
    }

    public function index(){
        $this->live_location();
    }

    public function live_location(){
        $this->data['page_title'] = 'Live Tracking';
        $this->data['no_breadcrumb'] = true;
        $this->load_content('tracking/tracking_map', $this->data);
    }

    public function add_marker(){
        $this->data['page_title'] = 'Live Tracking';
        $this->data['no_breadcrumb'] = true;
        $this->load_content('tracking/add_marker', $this->data);
    }

    public function getLatLng(){
        $users =  $this->db->select("id")->group_by("id")->get("users")->result_array();
        $data = array();
        foreach($users as $key=>$user){
            if($latest_coordinate = $this->db->where("user_id = {$user['id']}")->order_by("id","DESC")->limit(1)->get("coordinates")->row_array()){
                $data[] = $latest_coordinate;
            }
        }

        echo json_encode($data);
    }

    /*
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
    */
}