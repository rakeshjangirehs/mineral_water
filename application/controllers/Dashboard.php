<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->data['page_title'] = 'Dashboard';
		//$this->data['sub_page_title'] = 'Overview &amp; stats';
		$this->load_content('dashboard', $this->data);
	}
}