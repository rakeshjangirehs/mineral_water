<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking extends MY_Controller {

    public function __construct(){
        parent::__construct();
    }

    public function index(){

        $this->data['page_title'] = 'Live Tracking';
        $this->data['no_breadcrumb'] = true;
        $this->load_content('tracking/tracking_map', $this->data);
    }
}