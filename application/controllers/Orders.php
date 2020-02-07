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
                    'order_status',
                    'client_name',
                    'expected_delivery_date',
                    'payable_amount',
                    'effective_price',
                    'salesman_name',
                    'action'
                );
                    break;
                case 'ontheway':
                    $where .= " AND delivery_id IS NOT NULL AND actual_delivey_datetime IS NULL";
                    $colsArr = array(
                        'id',
                        'delivery_id',
                        'client_name',
                        'expected_delivery_date',
                        'payable_amount',
                        'effective_price',                        
                        'expected_delivey_datetime',
                        'delivery_team',
                        'action'
                    );
                    break;
                case 'completed':
                    $where .= " AND actual_delivey_datetime IS NOT NULL";
                    $colsArr = array(
                        'id',
                        'delivery_id',
                        'client_name',
                        'expected_delivery_date',
                        'payable_amount',
                        'effective_price',
                        'expected_delivey_datetime',
                        'actual_delivey_datetime',
                        'amount_recieved',
                        'delivery_team',
                        'notes',
                        'action'
                    );
                    break;
            }

            /*
            $query = "SELECT 
                    orders.*,
                    #`clients`.`id` AS `client_id`,
                    `clients`.`client_name`,
                    `salesman`.`id` AS `salesman_id`, 
                    CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                    `deliveryboy`.`id` AS `deliveryboy_id`, 
                    CONCAT(`deliveryboy`.`first_name`,' ',IFNULL(`deliveryboy`.`last_name`, '')) as `deliveryboy_name`,
                    #GROUP_CONCAT(tbl.id),
                    #GROUP_CONCAT(tbl.vehicle_details) as vehicles,
                    #GROUP_CONCAT(tbl.driver_details) as drivers,
                    #GROUP_CONCAT(tbl.delivery_boy_details) as delivery_boys,
                    #tbl.delivery_id,
                    DATE_FORMAT(tbl.expected_delivey_datetime,'%Y-%m-%d') as expected_delivey_datetime,
	                DATE_FORMAT(tbl.actual_delivey_datetime,'%Y-%m-%d') as actual_delivey_datetime,
                    tbl.pickup_location,
                    tbl.warehouse,
                    (CASE
                        WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                            WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                            ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                        END)
                        ELSE orders.payable_amount
                    END) AS `effective_price`,
                    (
                        SELECT
                            SUM(delivery_config_orders.amount)
                        FROM delivery_config_orders
                        WHERE delivery_config_orders.order_id = orders.id
                    ) AS `amount_recieved`
                FROM orders				
                LEFT JOIN clients ON clients.id = orders.client_id 
                LEFT JOIN users as salesman ON salesman.id = orders.created_by 
                LEFT JOIN users as deliveryboy ON deliveryboy.id = orders.delivery_boy_id
                LEFT JOIN schemes ON schemes.id = orders.scheme_id
                LEFT JOIN (
                    SELECT
                        delivery_config.id,		
                        delivery.id as delivery_id,
                        delivery.expected_delivey_datetime,
                        delivery.actual_delivey_datetime,
                        delivery.pickup_location,
                        delivery.warehouse,
                        #CONCAT_WS('##',vehicle.id,vehicle.name,vehicle.number,vehicle.capacity_in_ton) as vehicle_details,
                        #CONCAT_WS('##',driver.id,driver.first_name,driver.phone) as driver_details,
                        #CONCAT_WS('##',delivery_boy.id,delivery_boy.first_name,delivery_boy.phone) as delivery_boy_details,
                        GROUP_CONCAT(delivery_config_orders.order_id) as orders
                    FROM `delivery_config_orders`
                    LEFT JOIN `delivery_config` ON `delivery_config`.`id` = `delivery_config_orders`.`delivery_config_id`
                    LEFT JOIN `delivery` ON `delivery`.`id` = `delivery_config`.`delivery_id`
                    LEFT JOIN `vehicle` ON `vehicle`.`id` = `delivery_config`.`vehicle_id`
                    LEFT JOIN `users` as `driver` on `driver`.`id` = `delivery_config`.`driver_id`
                    LEFT JOIN `users` as `delivery_boy` on `delivery_boy`.`id` = `delivery_config`.`delivery_boy_id`
                    GROUP BY delivery_config.id
                ) as tbl ON FIND_IN_SET(orders.id,tbl.orders)
                GROUP BY `orders`.`id`";    //ORDER BY `orders`.`id`
                */

            $query = "SELECT 
                        orders.*,
                        #`clients`.`id` AS `client_id`,
                        `clients`.`client_name`,
                        `salesman`.`id` AS `salesman_id`, 
                        CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                        #`deliveryboy`.`id` AS `deliveryboy_id`, 
                        #CONCAT(`deliveryboy`.`first_name`,' ',IFNULL(`deliveryboy`.`last_name`, '')) as `deliveryboy_name`,	
                        DATE_FORMAT(delivery.expected_delivey_datetime,'%Y-%m-%d') as expected_delivey_datetime,
                        DATE_FORMAT(delivery_config_orders.delivery_datetime,'%Y-%m-%d') as actual_delivey_datetime,
                        delivery.pickup_location,
                        delivery.warehouse,
                        (CASE
                            WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                                WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                                ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                            END)
                            ELSE orders.payable_amount
                        END) AS `effective_price`,
                        delivery_config_orders.amount AS amount_recieved,
                        delivery_config_orders.notes,
                        (CASE
                            WHEN delivery.id IS NOT NULL
                            THEN (CASE
                                    WHEN delivery_boy.id IS NOT NULL
                                    THEN CONCAT(delivery_boy.first_name, ' ', delivery_boy.last_name, '<br/>',driver.first_name, ' ',driver.last_name)
                                    ELSE CONCAT(driver.first_name, ' ',driver.last_name)
                                END)
                            ELSE ''
                        END) AS `delivery_team`                        
                    FROM orders				
                    LEFT JOIN clients ON clients.id = orders.client_id 
                    LEFT JOIN users as salesman ON salesman.id = orders.created_by 
                    #LEFT JOIN users as deliveryboy ON deliveryboy.id = orders.delivery_boy_id
                    LEFT JOIN schemes ON schemes.id = orders.scheme_id                    
                    LEFT JOIN delivery_config_orders ON delivery_config_orders.order_id = orders.id
                    LEFT JOIN delivery_config ON delivery_config.id = delivery_config_orders.delivery_config_id
                    LEFT JOIN users AS delivery_boy ON delivery_boy.id = delivery_config.delivery_boy_id
                    LEFT JOIN users AS driver ON driver.id = delivery_config.driver_id
                    LEFT JOIN delivery ON delivery.id = delivery_config.delivery_id
                    GROUP BY `orders`.`id`";

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
        // echo "<pre>";print_r($order);die;
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

    private function get_order($id){    //order_id

        $order = $this->db
            ->select("
                orders.*,
                `clients`.`client_name`,
                CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                schemes.name as scheme_name,
                schemes.description,
                schemes.gift_mode,
                schemes.discount_mode,
                schemes.discount_value,
                schemes.free_product_id,
                schemes.free_product_qty,
                (CASE
                    WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                        WHEN schemes.discount_mode='amount' THEN schemes.discount_value
                        ELSE (orders.payable_amount*schemes.discount_value/100)
                    END)
                    ELSE 0
                END) AS `computed_disc`,
                (CASE
                    WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                        WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                        ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                    END)
                    ELSE orders.payable_amount
                END) AS `effective_amount`")                
            ->where("orders.id = {$id}")
            ->from("orders")
            ->join("schemes","schemes.id = orders.scheme_id","left")
            ->join("clients","clients.id = orders.client_id","left")
            ->join("users as salesman","salesman.id = orders.created_by","left")
            ->get()
            ->row_array();

        $client_id = $order['client_id'];
        
        if($order){
            $order['order_items'] = $this->db
                ->select("order_items.*,products.product_name,products.product_code,products.description,products.weight,products.dimension,products.sale_price as original_sale_price")
                ->where("order_id = {$order['id']}")
                ->from("order_items")
                ->join("products","products.id = order_items.product_id","left")
                ->get()
                ->result_array();

            $order['order_client'] = $this->db
                ->select("clients.*")
                ->where("id = {$client_id}")
                ->from("clients")
                ->get()
                ->row_array();

            if($order['free_product_id']){
                $order['free_product'] = $this->db->where("id",$order['free_product_id'])->get("products")->row_array();
                // echo "<pre>";print_r($order['free_product']);die;
            }else{
                $order['free_product'] = null;
            }
        }
        // echo "<pre>";print_r($order);die;
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

            // echo "<pre>";print_r($_POST);die;

            $client_id = $this->input->post('client_id');
            $product_to_remove = ($this->input->post('product_to_remove')) ? explode(",",$this->input->post('product_to_remove')) : null;
            
            $action = $this->input->post('action');
            $order_item = $this->input->post('order_item');

            $quantity_update_product = [];
            $new_order_value = 0;
            foreach($order_item  as $k=>$product){                
                $new_order_value += ( $product['effective_price'] * $product['quantity'] );
                if($product['actual_price'] != $product['effective_price']){
                    $quantity_update_product[] = array(
                        'order_id'  =>  $id,
                        'client_id' =>  $client_id,
                        'product_id'=>  $product['product_id'],
                        'sale_price'=>  $product['effective_price'],
                    );
                }
            }

            // echo "<pre>";print_r($product_to_remove);echo "</pre>";
            // echo "<pre>";print_r($quantity_update_product);echo "</pre>";
            // die;

            if ($this->order_model->order_approve($id,$action,$new_order_value,$quantity_update_product,$product_to_remove)) {
                
                $msg = ($action=='accept') ? 'Order accepted.' : 'Order rejected.';

                if ($id) {
                    $this->flash('success', $msg);
                } else {
                    $this->flash('success', $msg);
                }
            } else {
                $this->flash('error', 'Some error ocurred. Please try again later.');
            }
            redirect('orders', 'location');
            
        }
        $order = $this->get_order($id);
        // echo "<pre>";print_r($order);die;
        $this->data['id'] = $id;
        $this->data['order'] = $order;
        $this->data['page_title'] = 'Order - Admin Approval';
        $this->load_content('order/order_approval', $this->data);
    }

    public function order_edit($id=NULL) //$order_id
    {
        // Redirect to order list if order_id not provided
        if(!$id) {
            $this->flash("error", "Order not selected");
            redirect("orders");
        }

        $this->data['id'] = $id;

        $order_edit = $this->db->where("id",$id)->get("orders")->row_array();
        $this->data['order_edit'] =  $order_edit;
        // echo "<pre>";print_r($this->data['order_edit']);die;
        
        // Redirect to order is associated with a delivery (rare case)
        if($deliver_id = $order_edit['delivery_id']) {
            $this->flash("error", "Order is allocated in delivery no #{$deliver_id}, can't be edited.");
            redirect("orders");
        }

        $client_id = $this->data['order_edit']['client_id'];        
        // echo $client_id;die;

        $this->data['order_client'] = $this->db->where("id",$client_id)->get("clients")->row_array();
        // echo "<pre>";print_r($this->data['order_client']);die;

        $this->data['products'] =  $this->db
                                        ->select("products.*,client_product_price.sale_price as client_sale_price")
                                        ->join("client_product_price","client_product_price.product_id = products.id AND client_product_price.client_id={$client_id}","left")
                                        ->get("products")->result_array();

        // echo "<pre>";print_r($this->data['products']);die;
        // echo "<pre>".$this->db->last_query();die;        

        if($this->input->server("REQUEST_METHOD") == "POST"){

            // echo "<pre>";print_r($_POST);echo "</pre>";
            //die;

            $order_item = ($this->input->post('order_item')) ? $this->input->post('order_item') : [];

            $insert_order_items = [];
            $update_client_price_list = [];
            $product_prices = array_column($this->data['products'],'sale_price','id');
            $subtotal = 0;

            foreach($order_item as $k=>$item) {

                $product_subtotal = $item['new_price'] * $item['quantity'];
                $subtotal += $product_subtotal;
                
                $insert_order_items[] = array(
                    'order_id'      =>  $id,
                    'product_id'    =>  $item['product_id'],
                    'quantity'      =>  $item['quantity'],
                    'actual_price'  =>  $item['old_price'],  //Get Actual Price from product table
                    'effective_price'=> $item['new_price'],
                    'subtotal'      =>  $product_subtotal,
                    'created_at'    =>  date('Y-m-d H:i:s'),
                    'created_by'    =>  USER_ID,
                );

                // If there is price change for product, update new price in client_product_price as well
                if($item['old_price'] != $item['new_price']) {

                    $update_client_price_list[] = array(                            
                        'sale_price'    =>  $item['new_price'],
                        'updated_at'    =>  date('Y-m-d H:i:s'),
                        'updated_by'    =>  USER_ID,
                        'product_id'    =>  $item['product_id'],    //Used in where clause along with client_id
                    );

                }
            }

            // Order data
            $order_data = [
                // 'client_id'  =>  ($this->input->post('client_id')) ? trim($this->input->post('client_id')) : null,
                'delivery_address_id'  =>  ($this->input->post('delivery_address_id')) ? trim($this->input->post('delivery_address_id')) : 'Low',
                'scheme_id'  =>  ($this->input->post('scheme')) ? trim($this->input->post('scheme')) : null,
                'priority'  =>  ($this->input->post('priority')) ? trim($this->input->post('priority')) : 'Low',
                'expected_delivery_date'  =>  ($this->input->post('expected_delivery_date')) ? trim($this->input->post('expected_delivery_date')) : null,
                'payment_mode'  =>  ($this->input->post('payment_mode')) ? trim($this->input->post('payment_mode')) : 'Cash',
                'payment_schedule_date'  =>  ($this->input->post('payment_schedule_date')) ? trim($this->input->post('payment_schedule_date')) : null,
                'payable_amount'    =>  $subtotal,
                'updated_at'    =>  date('Y-m-d H:i:s'),
                'updated_by'    =>  USER_ID,
            ];


            /* echo "<pre>";print_r($insert_order_items);echo "</pre>";
            echo "<pre>";print_r($update_client_price_list);echo "</pre>";
            echo "<pre>";print_r($order_data);echo "</pre>";
            die; */

            // Start DB Transection
            $this->db->trans_start();


            // Remove all Order Items
            $this->db->where("order_id",$id)->delete("order_items");

            // Insert Order Items recieved in post
            if($insert_order_items) {
                $this->db->insert_batch("order_items",$insert_order_items);
            }

            // Update client price list
            if($update_client_price_list) {
                $this->db->where("client_id",$client_id)->update_batch("client_product_price",$update_client_price_list,'product_id');
                // echo "<pre>".$this->db->last_query()."</pre>";
            }            

            // Update Order table
            $this->db->where("id",$id)->update("orders",$order_data);

            // DB Transection End
            $this->db->trans_complete();
		
            if($this->db->trans_status()){
                $this->flash("success", "Updated Successfully");
            }else{
                $this->flash("error", "Not Updated");
            }
            redirect("orders");
        }

        $this->data['order_items'] =  $this->db->where("order_id",$id)->get("order_items")->result_array();
        // echo "<pre>";print_r($this->data['order_items']);die;

        $this->data['client_delivery_addresses'] = $this->db
                                                    ->select("client_delivery_addresses.id,client_delivery_addresses.title,client_delivery_addresses.address,zip_codes.zip_code")
                                                    ->join("zip_codes","zip_codes.id = client_delivery_addresses.zip_code_id")
                                                    ->where("client_delivery_addresses.client_id",$client_id)->get("client_delivery_addresses")->result_array();
        // echo "<pre>";print_r($this->data['client_delivery_addresses']);die;

        $scheme_id = $this->data['order_edit']['scheme_id'];        
        if($scheme_id) {
            $this->data['applied_scheme'] = $this->db->where("id",$scheme_id)->get("schemes")->row_array();
            // echo "<pre>";print_r($this->data['applied_scheme']);die;
        }

        $this->data['clients'] =  $this->db->get("clients")->result_array();
        // echo "<pre>";print_r($this->data['clients']);die;
        
        $this->data['page_title'] = 'Edit Order';
        $this->load_content('order/order_edit', $this->data);
    }

    public function get_applicable_scheme(){
        
        // sleep(3);
        // echo json_encode($_POST);die;

        $order_item = $this->input->post('order_item');

        if($order_item && is_array($order_item) && count($order_item) > 0) {

            $subtotal = 0;
            $order_products = array_column($order_item,'quantity','product_id');

            foreach($order_item as $k=>$item) {                
                $subtotal += ($item['quantity']) * $item['new_price'];
            }

            $today = date('Y-m-d');
            $applicable_scheme = [];

            // Get All Schemes
            $all_schemes = $this->db->where("'{$today}' BETWEEN `start_date` AND `end_date`")->get("schemes")->result_array();

            foreach($all_schemes as $scheme){

                $description = "";

                // Get friendly description of scheme
                if($scheme['gift_mode'] == 'cash_benifit'){
                    if($scheme['discount_mode'] == 'amount'){
                        $description = "Get discount of Rs. {$scheme['discount_value']}";
                    }else{
                        $description = "Get {$scheme['discount_value']} % discount on order value.";
                    }
                }else{
                    if($free_product = $this->db->where("id = {$scheme['free_product_id']}")->get("products")->row_array()){
                        $description = "Get {$scheme['free_product_qty']} {$free_product['product_name']} absolutely free.";
                    }                                        
                }

                if($scheme['type']=='price_scheme'){

                    if($subtotal >= $scheme['order_value']){

                        $applicable_scheme[] = array(
                            'id'             =>  $scheme['id'],
                            'name'           =>  $scheme['name'],
                            'description'    =>  $description,
                        );
                    }
                }else{

                    $scheme_products = $this->db->select("product_id,quantity")->where("scheme_id = {$scheme['id']}")->get("scheme_products")->result_array();

                    if($scheme['match_mode']=='all'){

                        $applicable = true;
                        foreach($scheme_products as $sp){
                            
                            if(!(array_key_exists($sp['product_id'],$order_products) && $order_products[$sp['product_id']] >= $sp['quantity']) ){
                                $applicable = false;
                            }
                        }

                        if($applicable){
                            $applicable_scheme[] = array(
                                'id'             =>  $scheme['id'],
                                'name'           =>  $scheme['name'],
                                'description'    =>  $description,
                            );
                        }

                    }else{

                        $applicable = false;
                        foreach($scheme_products as $sp){
                            
                            if(array_key_exists($sp['product_id'],$order_products) && $order_products[$sp['product_id']] >= $sp['quantity']){
                                $applicable = true;
                            }
                        }

                        if($applicable){
                            $applicable_scheme[] = array(
                                'id'             =>  $scheme['id'],
                                'name'           =>  $scheme['name'],
                                'description'    =>  $description,
                            );
                        }

                    }

                }                
            }

            if($applicable_scheme){

                echo json_encode([
                    'status'    =>  true,
                    'message'   =>  'Schemes Found',
                    'schemes'   =>  $applicable_scheme
                ]);

            } else {
                echo json_encode([
                    'status'    =>  false,
                    'message'   =>  'No Scheme Found',
                    'schemes'   =>  [],
                ]);
            }
            
        } else {
            echo json_encode([
                'status'    =>  false,
                'message'   =>  'Unable to handle data',
                'schemes'   =>  [],
            ]);
        }

        // if(mt_rand(0,10)%2==0) {
        /* if(true) {
            echo json_encode([
                'status'    =>  true,
                'message'   =>  'Schemes Found',
                'schemes'   =>  [
                    [
                        "id"    =>  1,
                        "name"  =>  "Buy 1 Get 1 Free",
                        "description"   => "Get discount of Rs. 500",
                    ],
                    [
                        "id"    =>  2,
                        "name"  =>  "Buy 1 Get 2 Free",
                        "description"   => "Get discount of Rs. 1000",
                    ],
                    [
                        "id"    =>  3,
                        "name"  =>  "Buy 1 Get 3 Free",
                        "description"   => "Get discount of Rs. 1500",
                    ],
                ]
            ]);
        } else {
            echo json_encode([
                'status'    =>  false,
                'message'   =>  'No Schemes Found',
                'schemes'   =>  null,
            ]);
        } */        
    }

    private function get_order_edit($id){    //order_id

        $order = $this->db
            ->select("
                orders.*,
                `clients`.`client_name`,
                CONCAT(`salesman`.`first_name`,' ',IFNULL(`salesman`.`last_name`, '')) as `salesman_name`,
                schemes.name as scheme_name,
                schemes.description,
                schemes.gift_mode,
                schemes.discount_mode,
                schemes.discount_value,
                schemes.free_product_id,
                schemes.free_product_qty,
                (CASE
                    WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                        WHEN schemes.discount_mode='amount' THEN schemes.discount_value
                        ELSE (orders.payable_amount*schemes.discount_value/100)
                    END)
                    ELSE 0
                END) AS `computed_disc`,
                (CASE
                    WHEN schemes.gift_mode='cash_benifit' THEN (CASE
                        WHEN schemes.discount_mode='amount' THEN orders.payable_amount-schemes.discount_value
                        ELSE orders.payable_amount-(orders.payable_amount*schemes.discount_value/100)
                    END)
                    ELSE orders.payable_amount
                END) AS `effective_amount`")                
            ->where("orders.id = {$id}")
            ->from("orders")
            ->join("schemes","schemes.id = orders.scheme_id","left")
            ->join("clients","clients.id = orders.client_id","left")
            ->join("users as salesman","salesman.id = orders.created_by","left")
            ->get()
            ->row_array();

        $client_id = $order['client_id'];
        
        if($order){
            $order['order_items'] = $this->db
                ->select("order_items.*,products.product_name,products.product_code,products.description,products.weight,products.dimension,products.sale_price as original_sale_price")
                ->where("order_id = {$order['id']}")
                ->from("order_items")
                ->join("products","products.id = order_items.product_id","left")
                ->get()
                ->result_array();

            $order['order_client'] = $this->db
                ->select("clients.*")
                ->where("id = {$client_id}")
                ->from("clients")
                ->get()
                ->row_array();

            if($order['free_product_id']){
                $order['free_product'] = $this->db->where("id",$order['free_product_id'])->get("products")->row_array();
                // echo "<pre>";print_r($order['free_product']);die;
            }else{
                $order['free_product'] = null;
            }
        }
        // echo "<pre>";print_r($order);die;
        return $order;
    }
}