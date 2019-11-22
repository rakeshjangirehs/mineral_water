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

 	public function index($type=''){    //pending,ontheway,completed

        if($this->input->is_ajax_request()){

            $where = "status = 'Active'";

            switch($type){
                case 'pending':
                $where .= " AND delivery_id IS NULL";
                $colsArr = array(
                    'id',
                    'client_name',
                    'expected_delivery_date',
                    'payable_amount',
                    'salesman_name',
                    'action'
                );
                    break;
                case 'ontheway':
                    $where .= " AND delivery_id IS NOT NULL AND actual_delivey_datetime IS NULL";
                    $colsArr = array(
                        'id',
                        'client_name',
                        'expected_delivery_date',
                        'payable_amount',
                        'expected_delivey_datetime'
                    );
                    break;
                case 'completed':
                    $where .= " AND actual_delivey_datetime IS NOT NULL";
                    $colsArr = array(
                        'id',
                        'client_name',
                        'expected_delivery_date',
                        'payable_amount',
                        'expected_delivey_datetime',
                        'actual_delivey_datetime',
                        'action'
                    );
                    break;
            }

            $query = "SELECT 
                    orders.*,
                    #`clients`.`id` AS `client_id`,
                    `clients`.`client_name`,
                    `salesman`.`id` AS `salesman_id`, 
                    CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                    `deliveryboy`.`id` AS `deliveryboy_id`, 
                    CONCAT(`deliveryboy`.`first_name`,' ',IFNULL(`deliveryboy`.`last_name`, '')) as `deliveryboy_name`,
                    #GROUP_CONCAT(tbl.id),
                    GROUP_CONCAT(tbl.vehicle_details) as vehicles,
                    GROUP_CONCAT(tbl.driver_details) as drivers,
                    GROUP_CONCAT(tbl.delivery_boy_details) as delivery_boys,
                    #tbl.delivery_id,
                    DATE_FORMAT(tbl.expected_delivey_datetime,'%Y-%m-%d') as expected_delivey_datetime,
	                DATE_FORMAT(tbl.actual_delivey_datetime,'%Y-%m-%d') as actual_delivey_datetime,
                    tbl.pickup_location,
                    tbl.warehouse
                FROM orders				
                LEFT JOIN clients ON clients.id = orders.client_id 
                LEFT JOIN users as salesman ON salesman.id = orders.created_by 
                LEFT JOIN users as deliveryboy ON deliveryboy.id = orders.delivery_boy_id
                LEFT JOIN (
                    SELECT
                        delivery_config.id,		
                        delivery.id as delivery_id,
                        delivery.expected_delivey_datetime,
                        delivery.actual_delivey_datetime,
                        delivery.pickup_location,
                        delivery.warehouse,
                        CONCAT_WS('##',vehicle.id,vehicle.name,vehicle.number,vehicle.capacity_in_ton) as vehicle_details,
                        CONCAT_WS('##',driver.id,driver.first_name,driver.phone) as driver_details,
                        CONCAT_WS('##',delivery_boy.id,delivery_boy.first_name,delivery_boy.phone) as delivery_boy_details,
                        GROUP_CONCAT(delivery_config_orders.order_id) as orders
                    FROM `delivery_config_orders`
                    LEFT JOIN `delivery_config` ON `delivery_config`.`id` = `delivery_config_orders`.`delivery_config_id`
                    LEFT JOIN `delivery` ON `delivery`.`id` = `delivery_config`.`delivery_id`
                    LEFT JOIN `vehicle` ON `vehicle`.`id` = `delivery_config`.`vehicle_id`
                    LEFT JOIN `users` as `driver` on `driver`.`id` = `delivery_config`.`driver_id`
                    LEFT JOIN `users` as `delivery_boy` on `delivery_boy`.`id` = `delivery_config`.`delivery_boy_id`
                    GROUP BY delivery_config.id
                ) as tbl ON FIND_IN_SET(orders.id,tbl.orders)
                GROUP BY `orders`.`id`
                ORDER BY `orders`.`id`";

                $result = $this->model->common_datatable($colsArr, $query, $where,NULL,TRUE);                
                // echo "<pre>".$this->db->last_query();die;
                echo $result;die;
        }

        $this->data['delivery_boys'] = $this->user->get_user_by_role(3);

        $this->data['page_title'] = 'Order List';
        $this->load_content('order/order_list', $this->data);
 	}

 	public function get_deliveryboy_by_order_id(){
 	    $order_id = $this->input->post('order_id');
        $order = $this->get_order($order_id);
        $zip_code_id = $order['order_client']['zip_code_id'];
        $users = $this->user->get_user_by_role_and_zip_code(3,null,$zip_code_id);   //3-salesman
         
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
            'expected_delivery_date' => ($this->input->post('expected_delivery_date')) ? $this->input->post('expected_delivery_date') : NULL,
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
            ->select("orders.*,`clients`.`client_name`,CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`")
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

            $email = ($client['contact_person_1_email']) ? $client['contact_person_1_email'] : $client['contact_person_2_email'];

            if($email){

                $this->data['order'] = $order;
                $invoice = $this->load->view('order/order_print', $this->data,true);

                $date = date('d-m-Y',strtotime($order['created_at']));
                $file_name = "Invoice #{$order['id']} {$order['client_name']} {$date}.pdf";
                $file_name = FCPATH.'uploads'.DIRECTORY_SEPARATOR.$file_name;

                $this->generate_pdf($invoice,$file_name,'F');
                if(file_exists($file_name)){
                    $this->load->library('mymailer');
                    $attachment = array($file_name);
                    $email_response = $this->mymailer->send_email("Invoice","Please Find Attached Invoice",$email,null,null,$attachment);
                    if($email_response['status']){
                        $response = array(
                            'success'    => true,
                            'message'    => "Email sent successfully to {$email}"
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

    public function order_prodcuts($id){    //$order_id
        
        if($this->input->server("REQUEST_METHOD") == "POST"){

            $client_id = $this->input->post('client_id');
            $product_to_remove = ($this->input->post('product_to_remove')) ? explode(",",$this->input->post('product_to_remove')) : null;
            
            $action = $this->input->post('action');
            $order_item = $this->input->post('order_item');

            $quantity_update_product = [];
            foreach($order_item  as $k=>$product){
                if($product['effective_price_old'] != $product['effective_price']){
                    $quantity_update_product[] = array(
                        'order_id'  =>  $id,
                        'client_id' =>  $client_id,
                        'product_id'=>  $product['product_id'],
                        'sale_price'=>  $product['effective_price'],
                    );
                }
            }

            echo "<pre>";print_r($product_to_remove);echo "</pre>";
            echo "<pre>";print_r($quantity_update_product);echo "</pre>";
            die;

            if ($this->order_model->order_approve($id,$action,$quantity_update_product,$product_to_remove)) {
                
                $msg = ($action=='accept') ? 'Order accepted.' : 'Order rejected.';

                if ($id) {
                    $this->flash('success', $msg);
                } else {
                    $this->flash('success', $msg);
                }
            } else {
                $this->flash('error', 'Some error ocurred. Please try again later.');
            }
            die;
            redirect('orders', 'location');
            
        }
        $order = $this->get_order($id);
        // echo "<pre>";print_r($order);die;
        $this->data['id'] = $id;
        $this->data['order'] = $order;
        $this->data['page_title'] = 'Order - Admin Approval';
        $this->load_content('order/order_approval', $this->data);
    }
}