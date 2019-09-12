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

 	public function payment_post($client_id){

        if($this->input->server("REQUEST_METHOD") == "POST"){
//            echo "<pre>";print_r($_POST);
//            die;

            $client_id = $this->input->post('client_id');
            $original_credit_balance  =  ($this->input->post('original_credit_balance')) ? $this->input->post('original_credit_balance') : 0.00;
            $credit_balance  =  ($this->input->post('credit_balance')) ? $this->input->post('credit_balance') : 0.00;
            $payments  =  ($this->input->post('payments')) ? $this->input->post('payments') : 0.00;

            $paymnent_data = array(
                'payment_mode'  =>  ($this->input->post('payment_mode')) ? $this->input->post('payment_mode') : null,
                'check_no'  =>  ($this->input->post('check_no')) ? $this->input->post('check_no') : null,
                'check_date'  =>  ($this->input->post('check_date')) ? $this->input->post('check_date') : null,
                'transection_no'  =>  ($this->input->post('transection_no')) ? $this->input->post('transection_no') : null,
                'paid_amount'  =>  ($this->input->post('paid_amount')) ? $this->input->post('paid_amount') : null,
                'previous_credit_balance'  =>  ($this->input->post('original_credit_balance')) ? $this->input->post('original_credit_balance') : null,
                'new_credit_balance'  =>  ($this->input->post('credit_balance')) ? $this->input->post('credit_balance') : null,
            );

            if($this->db->insert("payments",$paymnent_data)){

                $payment_id = $this->db->insert_id();

                foreach($payments as $k=>$payment){

                    $amount_used = floatval($payment['amount_used']);
                    $credit_used = floatval($payment['credit_used']);
                    $total_payment = $amount_used + $credit_used;

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

                if($payments){
                    $this->db->insert_batch("payment_details",$payments);
                }

                if($credit_balance){
                    $this->db->update("clients",array('credit_balance'=>$credit_balance),array('id'=>$client_id));
                }
            }
            die;
        }

        $this->data['client_detail'] = $this->client->get_client_by_id($client_id);
//        echo "<pre>";print_r($this->data['client_detail']);die;
        $this->data['invoice_list'] = $this->order_model->get_invoice($client_id);
//        echo "<pre>";print_r($this->data['invoice_list']);die;
//        echo "<pre>".$this->db->last_query();die;
        $this->data['page_title'] = 'Post Payment';
        $this->load_content('payment/add', $this->data);
    }
}