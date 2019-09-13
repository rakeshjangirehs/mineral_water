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
        $this->load->model('client');
        $this->load->model('user');
 	}

 	public function index(){

        if($this->input->is_ajax_request()){
            $colsArr = array(
                '`orders`.`id`',
                'CONCAT(`clients`.`first_name`," ",IFNULL(`clients`.`last_name`, ""))',
                '`orders`.`payable_amount`',
                '`orders`.`expected_delivery_date`',
                '`orders`.`actual_delivery_date`',
                'CONCAT(`salesman`.`first_name`," ",IFNULL(`salesman`.`last_name`, ""))',
                'CONCAT(`deliveryboy`.`first_name`," ",IFNULL(`deliveryboy`.`last_name`, ""))',
                'action'
            );

            $query = $this
                ->model
                ->common_select('orders.*,`clients`.`id` AS `client_id`,CONCAT(`clients`.`first_name`," ",IFNULL(`clients`.`last_name`, "")) as `client_name`,`salesman`.`id` AS `salesman_id`, CONCAT(`salesman`.`first_name`," ",IFNULL(`salesman`.`last_name`, "")) as `salesman_name`,`deliveryboy`.`id` AS `deliveryboy_id`, CONCAT(`deliveryboy`.`first_name`," ",IFNULL(`deliveryboy`.`last_name`, "")) as `deliveryboy_name`')
                ->common_join('clients','clients.id = orders.client_id','LEFT')
                ->common_join('users as salesman','salesman.id = orders.created_by','LEFT')
                ->common_join('users as deliveryboy','deliveryboy.id = orders.delivery_boy_id','LEFT')
                ->common_get('orders');

            echo $this->model->common_datatable($colsArr, $query, "orders.status = 'Active'");die;
        }

        $this->data['delivery_boys'] = $this->user->get_user_by_role(3);
//        echo "<pre>";print_r($this->data['delivery_boys']);die;
        $this->data['page_title'] = 'Order List';
        $this->load_content('order/order_list', $this->data);
 	}

 	public function get_deliveryboy_by_order_id(){
 	    $order_id = $this->input->post('order_id');
        $order = $this->get_order($order_id);
        $zip_code_id = $order['order_client']['zip_code_id'];
 	    $users = $this->user->get_user_by_role_and_zip_code(2,null,$zip_code_id);
        echo json_encode($users);
    }

 	public function order_details($id){

        $order = $this->get_order($id);
        $this->data['id'] = $id;
        $this->data['order'] = $order;
        $this->data['page_title'] = 'Order Details';
        $this->load_content('order/order_details', $this->data);
    }

    public function update_delivery_boy(){

 	    $order_id = $this->input->post('order_id');
        $where = array(
            'id'  =>  $order_id
        );
        $data = array(
            'delivery_boy_id' => ($this->input->post('delivery_boy')) ? $this->input->post('delivery_boy') : NULL,
        );

        if($this->db->update("orders",$data,$where)){
            $this->flash("success", "Delivery Boy Updated for Order Id # {$order_id}");
        }else{
            $this->flash("error", "Delivery Boy not Updated");
        }
        redirect("orders/index");
    }

    private function get_order($id){
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
        return $order;
    }

    public function print_invoice($id){

         $order = $this->get_order($id);
         $this->data['order'] = $order;
         $invoice = $this->load->view('order/order_print', $this->data,true);

         $date = date('d-m-Y',strtotime($order['created_at']));
         $file_name = "Invoice #{$order['id']} {$order['client_name']} {$date}.pdf";

         $this->generate_pdf($invoice,$file_name);
     }

    public function email_order($order_id){

        $response = array(
            'success'    => false,
            'message'    => 'Please try again'
        );

         if($order = $this->get_order($order_id)){

            $client = $this->client->get_client_by_id($order['client_id']);

            if($client['email']){

                $this->data['order'] = $order;
                $invoice = $this->load->view('order/order_print', $this->data,true);

                $date = date('d-m-Y',strtotime($order['created_at']));
                $file_name = "Invoice #{$order['id']} {$order['client_name']} {$date}.pdf";
                $file_name = FCPATH.'uploads'.DIRECTORY_SEPARATOR.$file_name;

                $this->generate_pdf($invoice,$file_name,'F');
                if(file_exists($file_name)){
                    $this->load->library('mymailer');
                    $attachment = array($file_name);
                    $email_response = $this->mymailer->send_email("Invoice","Please Find Attached Invoice",$client['email'],null,null,$attachment);
                    if($email_response['status']){
                        $response = array(
                            'success'    => true,
                            'message'    => "Email sent successfully to {$client['email']}"
                        );
                    }else{
                        $response = array(
                            'success'    => false,
                            'message'    => "Email can't be send."
                        );
                    }
                    unlink($file_name);
                }else{
                    $response = array(
                        'success'    => false,
                        'message'    => "Can't generate Invoice"
                    );
                }
            }else{
                $response = array(
                    'success'    => false,
                    'message'    => 'No email is associated with this client'
                );
            }

         }else{
             $response = array(
                 'success'    => false,
                 'message'    => 'Order not found'
             );
         }

         echo json_encode($response);
     }

    private function generate_pdf($html,$file_name=NULL,$mode='I'){

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