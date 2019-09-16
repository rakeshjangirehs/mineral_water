<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/*PHP Mailer*/
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require FCPATH.'vendor/autoload.php';

class MY_Controller extends CI_Controller {

	public $baseUrl;
	protected $data = null;
	public $system_setting = array();
	public function __construct(){
		parent::__construct();

		$this->load->helper('url');
		if(!$this->session->userdata('id')){
			redirect('auth/login', 'location');
			die;
		}

		if(!empty($this->session)){
			// $this->output->cache(1);		// to enable caching carefully.
			define('USER_ID', $this->session->userdata('id'));
			define('USER_USERNAME', $this->session->userdata('username'));
			define('USER_FIRSTNAME', $this->session->userdata('first_name'));
			define('USER_LASTNAME', $this->session->userdata('last_name'));
			define('USER_EMAIL', $this->session->userdata('email'));
			define('USER_PHONE', $this->session->userdata('phone'));
			$this->session->set_userdata('last_time', time());
		}
		$this->baseUrl = base_url()."index.php/";
		$this->assetsUrl = base_url();
		if(!in_array($_SERVER['REMOTE_ADDR'], $this->config->item('maintenance_ips')) && $this->config->item('maintenance_mode') == TRUE) {
      		include(APPPATH.'views/maintenance_view.php');
	        die();
	    }
		$this->load->helper('breadcrumb_helper');
		$this->load->model('MY_Model','model'); //Load the Model here
		$this->system_setting = $this->model->get_settings();

        defined('NODE_URL')  OR define('NODE_URL', $this->system_setting['node_server_url']);
        defined('MAP_API_KEY')  OR define('MAP_API_KEY', $this->system_setting['maps_api_key']);
	}

	public function load_content($content = NULL, $data = array()){
		$content = $this->load->view($content, $this->data, TRUE);
		$this->data['page_js'] = $this->get_string_between($content);
		$this->data['content'] = preg_replace('/@script[\s\S]+?@endscript/', '', $content);
		$this->load->view('layouts/main_layout', $this->data);
	}

	public function get_string_between($string, $start = '@script', $end = '@endscript'){
	    $string = ' ' . $string;
	    $ini = strpos($string, $start);
	    if ($ini == 0) return '';
	    $ini += strlen($start);
	    $len = strpos($string, $end, $ini) - $ini;
	    return substr($string, $ini, $len);
	}

	public function flash($type, $msg) {
		$this->session->set_flashdata($type, $msg);
	}

	public function common_upload(){
		$this->load->library('upload');
	}

	public function readExcel( $file ){
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
		// echo "<pre>"; print_r($spreadsheet);die;
		// read excel data and store into an array
		$xls_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
		return $xls_data;
	}

	public function export( $fileName = 'test.xlsx', $title = "Export excel", $sheetTitle = 'Test', $headerColumns = array(), $data = array(), $tmp = false ){

		$abc = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA'];

		$this->load->helper('download');

		if( !is_array($headerColumns) ){
            $headerColumns = explode(',', $headerColumns);
        }
        $length = count($headerColumns);
        $rowCount = 2;
        $index = 1;
        // set Header
        $start = $abc[0];
        $end = $abc[$length-1];

        $sheetData = array();
		$sheetData['title'] = $sheetTitle;

		// get employee list
		$spreadsheet = new Spreadsheet();
        //name the worksheet
		$sheet = $spreadsheet->getActiveSheet();

		if( !empty( $headerColumns ) )
        {
            foreach( $headerColumns as $key=>$header )
            {
                $spreadsheet->getActiveSheet()->SetCellValue($abc[$key].$rowCount,ucwords(str_replace("_"," ", $header)));
            }
        }

        // set bold header
        $spreadsheet->getActiveSheet()->getStyle($start.$index.":".$end.$index)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle($start.$index.":".$end.$index)->getFont()->setSize(16);

		// set bold header
		$spreadsheet->getActiveSheet()->getStyle($start . $rowCount . ':'.$end . $rowCount)->getFont()->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle($start . $rowCount . ':'.$end . $rowCount)->getFont()->setSize(12);
		// merge
		$spreadsheet->getActiveSheet()->mergeCells($start.$index.":".$end.$index);

		$spreadsheet->getActiveSheet()->setCellValue($start.$index, $title);

		$spreadsheet->getActiveSheet()->getStyle($start.$index.":".$end.$index)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setWrapText(true);

		$spreadsheet->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);

		// read data to active sheet
        if (!empty($data)) {
            foreach ($data as $row_data) {
                $rowCount++;
                foreach( $headerColumns as $k=>$header )
                {
                    $spreadsheet->getActiveSheet()->SetCellValue($abc[$k] . $rowCount, $row_data[$header]);
                }
                $index++;
            }
        }

        foreach(range($start,$end) as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $fileName . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
	}

	public function libQr( $data = array(), $fileName = NULL ){
		$codesDir = FCPATH.'qr';
		include_once(FCPATH.'vendor'.DIRECTORY_SEPARATOR.'kairos'.DIRECTORY_SEPARATOR.'phpqrcode'.DIRECTORY_SEPARATOR."qrlib.php");
		$fileName = $fileName.'.png';
        $codeFile = $codesDir.'/'.$fileName;
        if (!file_exists($codeFile)) {
			QRcode::png(json_encode($data), $codeFile, "L", 4, 4);

			$png = imagecreatefrompng($codeFile);
	        $jpeg = imagecreatefromjpeg($codesDir.DIRECTORY_SEPARATOR."agrocel_logo.jpg");
	        list($width, $height) = getimagesize($codeFile);
            list($newwidth, $newheight) = getimagesize($codesDir.DIRECTORY_SEPARATOR."agrocel_logo.jpg");

            $out = imagecreatetruecolor($newwidth, $newheight);
            // imagecopyresampled($out, $png, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            // imagecopyresampled($out, $jpeg, 0, 0, 0, 0, $newwidth, $newheight, $newwidth, $newheight);
            imagecopyresampled($out, $jpeg, 0, 0, 0,0, $newwidth,$newheight, $newwidth, $newheight);
            imagecopyresampled($out, $png, 40, 0, 0, 0, 222, 222, 250, 250);

            // Prepare font size and colors
            $text_color = imagecolorallocate($out, 0, 0, 0);
            $bg_color = imagecolorallocate($out, 255, 255, 255);
            $font = FCPATH.'assets/fonts/open_sans.ttf';
            $font_size = 8;

            // Set the offset x and y for the text position
            $offset_x = 60;
            $offset_y = 215;
            // Add text
            // imagettftext($out, $font_size, 0, $offset_x, $offset_y, $text_color, $font, "Test");

            // imagettftext($out, $font_size, 0, $width/1.40, $offset_y, $text_color, $font, "Milan");
            $fileName = $fileName.".png";
            imagepng($out, $codesDir.'/'.$fileName);
            unlink($codeFile);
            return $fileName;
    	}
	}

    protected function generate_pdf($html,$file_name=NULL,$mode='I'){

        ini_set("pcre.backtrack_limit", "5000000");
        ini_set('memory_limit','2048M');
        ini_set('max_execution_time',0);

        $root_path = FCPATH.'files'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR;

        $pathInfo = pathinfo($file_name);
        if(isset($pathInfo['extension']) && $pathInfo['dirname']!='.'){

            $dir_structure =dirname($file_name);
            if (!file_exists($dir_structure)) {
                mkdir($dir_structure, 0777, true);
            }
        }

        $modeArr = array(
            'I'=>\Mpdf\Output\Destination::INLINE,
            'D'=>\Mpdf\Output\Destination::DOWNLOAD,
            'F'=>\Mpdf\Output\Destination::FILE,
            'S'=>\Mpdf\Output\Destination::STRING_RETURN,
        );

        $mpdf = new \Mpdf\Mpdf(
            array(
//                 'mode' => 'utf-8',
//                 'format' => array(210, 297),
//                 'orientation' => 'P',
//                 'setAutoTopMargin' => 'stretch',
//                 'autoMarginPadding' => 0,
//                 'bleedMargin' => 0,
//                 'crossMarkMargin' => 0,
//                 'cropMarkMargin' => 0,
//                 'nonPrintMargin' => 0,
//                 'margBuffer' => 0,
//                 'collapseBlockMargins' => false,
            )
        );
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        $mpdf->Output($file_name,$modeArr[$mode]);
    }

}
?>