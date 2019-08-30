<?php 
class Settings_model extends MY_Model{
	public function __construct(){
		parent::__construct();
	}

	public function add_update_smtp($data){
		$this->db->where('id', 1);
		$this->db->update('settings', $data);
		return true;
	}
}
?>