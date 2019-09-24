	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking extends MY_Controller {

    public function __construct(){
        parent::__construct();

        $this->data['users'] = $this->db
            ->select("users.*,roles.role_name")
            ->join("roles","roles.id = users.role_id","left")
            //->where("roles.id=3")
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

    public function tracking_path($provide_data=false){

        //Get Delivery Boys
        $this->data['users'] = $this->db
            ->select("users.*,roles.role_name")
            ->join("roles","roles.id = users.role_id","left")
            ->where("roles.id=3")
            ->get("users")->result_array();

        if($this->input->server('REQUEST_METHOD')=='POST'){

            $date = ($this->input->post('date')) ? $this->input->post('date') : date('Y-m-d');
            $user_id = $this->input->post('user_id');

            if($user_id){
                $users = $this->db
                    ->select("users.*,roles.role_name")
                    ->join("roles","roles.id = users.role_id","left")
                    ->where("users.id={$user_id}")
                    ->get("users")->result_array();
            }else{
                $users =  $this->data['users'];
            }

            foreach($users as $key=>$user){
                $users[$key]['coordinates'] = array();
                if($coordinate = $this->db->where(array('user_id' => $user['id'],'date(created_at)' => $date))->order_by("id","ASC")->select("lat,lng")->get("coordinates")->result_array()){
                    $users[$key]['coordinates'][] = $coordinate;
                }
            }
            echo json_encode($users);
        }else{
            $this->data['page_title'] = 'Tracking Path';
            $this->data['no_breadcrumb'] = true;
            $this->load_content('tracking/tracking_path', $this->data);
        }
    }

    public function add_marker(){
        $this->data['page_title'] = 'Add Marker';
        $this->data['no_breadcrumb'] = true;
        $this->load_content('tracking/add_marker', $this->data);
    }

    public function set_route(){
        $this->data['page_title'] = 'Set Route';
        $this->data['no_breadcrumb'] = true;
        $this->load_content('tracking/set_route', $this->data);
    }

    public function getLatLng(){
        $users =  $this->db->select("id")->get("users")->result_array();
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