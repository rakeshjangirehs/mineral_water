<?php  
 defined('BASEPATH') OR exit('No direct script access allowed'); 
 /** Developer: Milan Soni 
  * Created Date: 2019-08-26 16:57:31 
  * Created By : CLI 
 */ 
 
class Logs extends MY_Controller {
    
    private $logViewer;

    public function __construct() {
        parent::__construct(); 
        $this->logViewer = new \CILogViewer\CILogViewer();
    }

    public function index() {
        echo $this->logViewer->showLogs();
        return;
    }
}