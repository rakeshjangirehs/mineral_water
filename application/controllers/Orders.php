<?php  
 defined('BASEPATH') OR exit('No direct script access allowed'); 
 /** Developer: Milan Soni 
  * Created Date: 2019-08-26 16:57:31 
  * Created By : CLI 
 */

 class Orders extends MY_Controller {
 
 	public function __construct() {
 	 	parent::__construct();
        ini_set('memory_limit','2048M');
        ini_set('max_execution_time',0);
 	 	$this->load->model('order_model');
 	}

 	public function index(){

        if($this->input->is_ajax_request()){
            $colsArr = array(
                '`orders`.`id`',
                'CONCAT(`clients`.`first_name`," ",IFNULL(`clients`.`last_name`, ""))',
                '`orders`.`expected_delivery_date`',
                '`orders`.`actual_delivery_date`',
                'CONCAT(`salesman`.`first_name`," ",IFNULL(`salesman`.`last_name`, ""))',
                'action'
            );

            $query = $this
                ->model
                ->common_select('orders.*,`clients`.`id` AS `client_id`,CONCAT(`clients`.`first_name`," ",IFNULL(`clients`.`last_name`, "")) as `client_name`,`salesman`.`id` AS `salesman_id`,CONCAT(`salesman`.`first_name`," ",IFNULL(`salesman`.`last_name`, "")) as `salesman_name`')
                ->common_join('clients','clients.id = orders.client_id','LEFT')
                ->common_join('users as salesman','salesman.id = orders.created_by','LEFT')
                ->common_get('orders');

            echo $this->model->common_datatable($colsArr, $query, "orders.status = 'Active'");die;
        }

        $this->data['page_title'] = 'Order List';
        $this->load_content('order/order_list', $this->data);
 	}

 	public function order_details($id){

        $order = $this->db
                                ->select("orders.*,CONCAT(`clients`.`first_name`,' ',IFNULL(`clients`.`last_name`, '')) as `client_name`,CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`")
                                ->where("orders.id = {$id}")
                                ->from("orders")
                                ->join("clients","clients.id = orders.client_id","left")
                                ->join("users as salesman","salesman.id = orders.created_by","left")
                                ->get()
                                ->row_array();

        if($order){
            $order['order_items'] = $this->db
                ->select("order_items.*,products.product_name,products.product_code,products.description,products.weight,products.dimension")
                ->where("order_id = {$order['id']}")
                ->from("order_items")
                ->join("products","products.id = order_items.product_id","left")
                ->get()
                ->result_array();

            $order['order_client'] = $this->db
                ->select("clients.*")
                ->where("id = {$order['client_id']}")
                ->from("clients")
                ->get()
                ->row_array();
        }
        $this->data['order'] = $order;
        $this->data['page_title'] = 'Order Details';
        $this->load_content('order/order_details', $this->data);
    }

     public function print_invoice($id){

         $order = $this->db
             ->select("orders.*,CONCAT(`clients`.`first_name`,' ',IFNULL(`clients`.`last_name`, '')) as `client_name`,CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`")
             ->where("orders.id = {$id}")
             ->from("orders")
             ->join("clients","clients.id = orders.client_id","left")
             ->join("users as salesman","salesman.id = orders.created_by","left")
             ->get()
             ->row_array();

         if($order){
             $order['order_items'] = $this->db
                 ->select("order_items.*,products.product_name,products.product_code,products.description,products.weight,products.dimension")
                 ->where("order_id = {$order['id']}")
                 ->from("order_items")
                 ->join("products","products.id = order_items.product_id","left")
                 ->get()
                 ->result_array();

             $order['order_client'] = $this->db
                 ->select("clients.*")
                 ->where("id = {$order['client_id']}")
                 ->from("clients")
                 ->get()
                 ->row_array();
         }
         $this->data['order'] = $order;
         $this->data['page_title'] = 'Order Details';
         $c = $this->load->view('order/order_print', $this->data,true);
//echo $c;die;
         $mpdf = new \Mpdf\Mpdf([
             'mode' => 'utf-8',
             'format' => [210, 297],
             'orientation' => $orientation,
             'setAutoTopMargin' => 'stretch',
             'autoMarginPadding' => 0,
             'bleedMargin' => 0,
             'crossMarkMargin' => 0,
             'cropMarkMargin' => 0,
             'nonPrintMargin' => 0,
             'margBuffer' => 0,
             'collapseBlockMargins' => false,
         ]);
         $mpdf->SetDisplayMode('fullpage');
         $mpdf->WriteHTML($c);
         $mpdf->Output();
     }
}