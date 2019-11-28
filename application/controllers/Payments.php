<?php  
 defined('BASEPATH') OR exit('No direct script access allowed'); 
 /** Developer: Milan Soni 
  * Created Date: 2019-09-11 11:17:03 
  * Created By : CLI 
 */ 
 
class Payments extends MY_Controller {
 
 	public function __construct() {
 		parent::__construct();
 		$this->load->model('order_model');
 		$this->load->model('client');
 	}

 	public function index(){

 	}

 	public function payment_post($client_id = NULL ){
         
 		if(!$client_id){ 
 			redirect('clients','location'); 
 		}

        if($this->input->server("REQUEST_METHOD") == "POST"){

            // echo "<pre>";print_r($_POST);die;

            $client_id = $this->input->post('client_id');
            $original_credit_balance  =  ($this->input->post('original_credit_balance')) ? $this->input->post('original_credit_balance') : 0.00;
            $credit_balance  =  ($this->input->post('credit_balance')) ? $this->input->post('credit_balance') : 0.00;
            $payments  =  ($this->input->post('payments')) ? $this->input->post('payments') : 0.00;

            $paymnent_data = array(
                'client_id'  =>  ($this->input->post('client_id')) ? $this->input->post('client_id') : null,
                'payment_mode'  =>  ($this->input->post('payment_mode')) ? $this->input->post('payment_mode') : null,
                'check_no'  =>  ($this->input->post('check_no')) ? $this->input->post('check_no') : null,
                'check_date'  =>  ($this->input->post('check_date')) ? $this->input->post('check_date') : null,
                'transection_no'  =>  ($this->input->post('transection_no')) ? $this->input->post('transection_no') : null,
                'paid_amount'  =>  ($this->input->post('paid_amount')) ? $this->input->post('paid_amount') : 0,
                'previous_credit_balance'  =>  ($this->input->post('original_credit_balance')) ? $this->input->post('original_credit_balance') : 0,
                'new_credit_balance'  =>  ($this->input->post('credit_balance')) ? $this->input->post('credit_balance') : 0,
            );

            $this->db->trans_start();

            $order_status_update = [];

            if($this->db->insert("payments",$paymnent_data)){

                $payment_id = $this->db->insert_id();

                $total_credit_used = 0;
                foreach($payments as $k=>$payment){

                    $amount_used = floatval($payment['amount_used']);
                    $credit_used = floatval($payment['credit_used']);
                    $total_payment = $amount_used + $credit_used;

                    $total_credit_used += $credit_used;

                    $outstanding_amount = floatval($payment['outstanding_amount']);
                    unset($payments[$k]['outstanding_amount']);

                    $payments[$k]['payment_id'] = $payment_id;
                    $payments[$k]['total_payment'] = $total_payment;

                    if($total_payment == 0){
                        unset($payments[$k]);
                    }elseif($total_payment < $outstanding_amount){
                        $payments[$k]['status'] = 'PARTIAL';
                        $order_status_update[] = array(
                            'id'  =>  $payment['order_id'],
                            'payment_status' => 'Partial'
                        );
                    }else{
                        $payments[$k]['status'] = 'PAID';
                        $order_status_update[] = array(
                            'id'  =>  $payment['order_id'],
                            'payment_status' => 'Paid'
                        );
                    }
                }

                if($total_credit_used){
                    $this->db->update("payments",array('credit_balance_used'=>$total_credit_used),array('id'=>$payment_id));
                }

                if($order_status_update){
                    $this->db->update_batch("orders",$order_status_update,'id');
                }

                if($payments){
                    $this->db->insert_batch("payment_details",$payments);
                }

                $this->db->update("clients",array('credit_balance'=>$credit_balance),array('id'=>$client_id));

            }
            $this->db->trans_complete();

            if($this->db->trans_status()){
                $this->flash('success','Payment processed successfully.');
            }else{
                $this->flash('error','Payment not processed.');
            }
            redirect("payments/view_payment/{$payment_id}");
        }

        $this->data['client_detail'] = $this->client->get_client_by_id($client_id);
//        echo "<pre>";print_r($this->data['client_detail']);die;
        $this->data['invoice_list'] = $this->order_model->get_invoice($client_id);
    //    echo "<pre>";print_r($this->data);die;
//        echo "<pre>".$this->db->last_query();die;
        $this->data['page_title'] = 'Post Payment';
        $this->load_content('payment/post_payment', $this->data);
    }

    public function payments_list(){

        if($this->input->is_ajax_request()){
            $colsArr = array(
                '`clients`.`client_name`',
                '`payments`.`payment_mode`',
                '`payments`.`paid_amount`',
                '`payments`.`created_at`',
                '`clients`.`contact_person_1_email`',
                'links'
            );

            $query = $this->model
                        ->common_select('`payments`.*,DATE_FORMAT(`payments`.`created_at`, "%d-%m-%Y %h:%i:%s") AS `payment_date`,`clients`.`id` AS `client_id`,`clients`.`client_name`,`clients`.`contact_person_1_email` AS `client_email`')
                        ->common_join("`clients`","`clients`.`id` = `payments`.`client_id`","left")
                        ->common_get('payments');
            echo $this->model->common_datatable($colsArr, $query);die;
        }
        $this->data['page_title'] = 'Payments';
        $this->load_content('payment/payments_list', $this->data);
    }

    public function view_payment($payment_id){

        $payment_data = $this->get_payments($payment_id);

        $this->data['payment_data'] = $payment_data;
        $this->data['id'] = $payment_id;
        $this->data['page_title'] = 'Payment View';
        $this->load_content('payment/view_payment', $this->data);
    }

    public function print_payment_invoice($payment_id){

        $payments = $this->get_payments($payment_id);
//        echo "<pre>";print_r($payments);die;

        $this->data['order'] = $payments;
        $invoice = $this->load->view('payment/payment_print', $this->data,true);

//echo $invoice;die;
        $date = date('d-m-Y',strtotime($payments['created_at']));
        $file_name = "Invoice #{$payments['id']} {$payments['client_name']} {$date}.pdf";
        $this->generate_pdf($invoice,$file_name);
    }

    public function email_reciept($payment_id){

        $response = array(
            'success'    => false,
            'message'    => 'Please try again'
        );

        if($payment = $this->get_payments($payment_id)){
            $client = $this->client->get_client_by_id($payment['client_id']);

            $email = $client['contact_person_1_email'];
            
            if($email){

                $this->data['order'] = $payment;
                $invoice = $this->load->view('payment/payment_print', $this->data,true);

                $date = date('d-m-Y',strtotime($payment['created_at']));
                $file_name = "Reciept #{$payment['id']} {$payment['client_name']} {$date}.pdf";
                $file_name = FCPATH.'uploads'.DIRECTORY_SEPARATOR.$file_name;

                $this->generate_pdf($invoice,$file_name,'F');
                if(file_exists($file_name)){
                    $this->load->library('mymailer');
                    $attachment = array($file_name);
                    $email_response = $this->mymailer->send_email("Reciept","Please Find Attached Payment Reciept",$email,null,null,$attachment);
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

    private function get_payments($payment_id){

        $query = "SELECT
                    `payments`.*,
                    DATE_FORMAT(`payments`.`created_at`, '%d-%m-%Y') AS `payment_date`,
                    `clients`.`id` AS `client_id`,
                    `clients`.`client_name`,
                    `clients`.`contact_person_1_phone_1`,
                    `clients`.`credit_limit`,
                    `clients`.`address`,
                    `clients`.`contact_person_1_email`,
                    `clients`.`contact_person_name_1`
                FROM `payments`
                LEFT JOIN `clients` ON `clients`.`id` = `payments`.`client_id`
                WHERE `payments`.`id` = {$payment_id}";

        $payment_data = $this->db->query($query)->row_array();

        if($payment_data){
            $invoice_query = "SELECT
                                `payment_details`.*,
                                `orders`.`payable_amount`,
                                (
                                    SELECT
                                        #GROUP_CONCAT(`pd_sub`.`id`)
                                        IFNULL(SUM(`pd_sub`.`total_payment`),0) AS `paid_amount`
                                    FROM `payment_details` AS `pd_sub`
                                    WHERE `pd_sub`.`order_id` = `payment_details`.`order_id`
                                    AND `pd_sub`.`id` < `payment_details`.`id`
                                ) AS `previously_paid`
                            FROM `payment_details`
                            LEFT JOIN `orders` ON `orders`.`id` = `payment_details`.`order_id`
                            WHERE `payment_details`.`payment_id` = {$payment_data['id']}";

            $payment_data['invoices'] = $this->db->query($invoice_query)->result_array();

        }
        // echo "<pre>";print_r($payment_data);die;
        return $payment_data;
    }

    public function delete_payment($payment_id){

        if($payment = $this->db->get_where("payments",array('id'=> $payment_id))->row_array()){

            $credit_balance_used = floatval($payment['credit_balance_used']);
echo $credit_balance_used;die;
            $this->db->trans_start();

            if($credit_balance_used){

                $client_id = $payment['client_id'];
                $client = $this->db->get_where("clients",array('id'=> $client_id))->row_array();

                $client_credit_balance = floatval($client['credit_balance']);

                $client_credit_balance += $credit_balance_used;

                $this->db->update("clients",array('credit_balance'=>$client_credit_balance),array('id'=>$client_id));


            }

            $this->db->delete("payment_details",array('payment_id'=>$payment_id));
            $this->db->delete("payments",array('id'=>$payment_id));

            $this->db->trans_complete();

            if($this->db->trans_status()){
                $this->flash('success','Payment deleted successfully.');
            }else{
                $this->flash('error','Payment not deleted.');
            }
        }else{
            $this->flash('error','Payment record not found.');
        }

        redirect("payments/payments_list");
    }

    public function payments_list_export(){

        $query = $this->model
            ->common_select('CONCAT_WS(" ", `clients`.`first_name`, `clients`.`last_name`) AS `client_name`,`payments`.`payment_mode`,`payments`.`paid_amount`,DATE_FORMAT(`payments`.`created_at`, "%d-%m-%Y %h:%i:%s") AS `payment_date`,`clients`.`email` AS `client_email`')
            ->common_join("`clients`","`clients`.`id` = `payments`.`client_id`","left")
            ->common_get('payments');

        $resultData = $this->db->query($query)->result_array();
        $headerColumns = implode(',', array_keys($resultData[0]));
        $filename = 'payment_list-'.time().'.xlsx';
        $title = 'Payment List';
        $sheetTitle = 'Payment List';
        $this->export( $filename, $title, $sheetTitle, $headerColumns,  $resultData );
    }
}