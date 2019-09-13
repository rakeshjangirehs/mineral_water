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
//            echo "<pre>";print_r($_POST);
//            die;

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

            if($this->db->insert("payments",$paymnent_data)){

                $payment_id = $this->db->insert_id();

                $total_credit_used = 0;
                foreach($payments as $k=>$payment){

                    $amount_used = floatval($payment['amount_used']);
                    $credit_used = floatval($payment['credit_used']);
                    $total_payment = $amount_used + $credit_used;

                    $total_credit_used += $credit_used;

                    $payable_amount = floatval($payment['payable_amount']);
                    unset($payments[$k]['payable_amount']);

                    $payments[$k]['payment_id'] = $payment_id;
                    $payments[$k]['total_payment'] = $total_payment;

                    if($total_payment == 0){
                        unset($payments[$k]);
                    }elseif($total_payment < $payable_amount){
                        $payments[$k]['status'] = 'PARTIAL';
                    }else{
                        $payments[$k]['status'] = 'PAID';
                    }
                }

                if($total_credit_used){
                    $this->db->update("payments",array('credit_balance_used'=>$total_credit_used),array('id'=>$payment_id));
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
//        echo "<pre>";print_r($this->data['invoice_list']);die;
//        echo "<pre>".$this->db->last_query();die;
        $this->data['page_title'] = 'Post Payment';
        $this->load_content('payment/post_payment', $this->data);
    }

    public function payments_list(){

        if($this->input->is_ajax_request()){
            $colsArr = array(
                'CONCAT_WS(" ", `clients`.`first_name`, `clients`.`last_name`)',
                '`payments`.`payment_mode`',
                '`payments`.`paid_amount`',
                '`payments`.`created_at`',
                'links'
            );

            $query = $this->model
                        ->common_select('`payments`.*,DATE_FORMAT(`payments`.`created_at`, "%d-%m-%Y %h:%i:%s") AS `payment_date`,`clients`.`id` AS `client_id`,CONCAT_WS(" ", `clients`.`first_name`, `clients`.`last_name`) AS `client_name`')
                        ->common_join("`clients`","`clients`.`id` = `payments`.`client_id`","left")
                        ->common_get('payments');
            echo $this->model->common_datatable($colsArr, $query);die;
        }
        $this->data['page_title'] = 'Payments';
        $this->load_content('payment/payments_list', $this->data);
    }

    public function view_payment($payment_id){

        $payment_data = $this->db
                        ->select('`payments`.*,DATE_FORMAT(`payments`.`created_at`, "%d-%m-%Y") AS `payment_date`,`clients`.`id` AS `client_id`,CONCAT_WS(" ", `clients`.`first_name`, `clients`.`last_name`) AS `client_name`,`clients`.`phone`,`clients`.`credit_limit`,`clients`.`address`')
                        ->join("`clients`","`clients`.`id` = `payments`.`client_id`","left")
                        ->where("`payments`.`id` = {$payment_id}")
                        ->get('payments')
                        ->row_array();

        if($payment_data){
            $payment_data['invoices'] = $this->db
                                ->select("payment_details.*,orders.payable_amount")
                                ->from("payment_details")
                                ->join("orders","orders.id = payment_details.order_id","left")
                                ->where("payment_details.payment_id = {$payment_data['id']}")
                                ->get()
                                ->result_array();

        }

//        echo "<pre>";print_r($payment_data);die;

        $this->data['payment_data'] = $payment_data;
        $this->data['page_title'] = 'Payment View';
        $this->load_content('payment/view_payment', $this->data);
    }

    public function delete_payment($payment_id){

        if($payment = $this->db->get_where("payments",array('id'=> $payment_id))->row_array()){

            $credit_balance_used = floatval($payment['credit_balance_used']);

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
            ->common_select('CONCAT_WS(" ", `clients`.`first_name`, `clients`.`last_name`) AS `client_name`,`payments`.`payment_mode`,`payments`.`paid_amount`,DATE_FORMAT(`payments`.`created_at`, "%d-%m-%Y %h:%i:%s") AS `payment_date`')
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