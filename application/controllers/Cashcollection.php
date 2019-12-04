<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property vehilcle $vehilcle
 */

class Cashcollection extends MY_Controller {

	public function __construct(){
        parent::__construct();
        
        //validation config
        $this->cash_collection_validation_config = array(
            array(
                'field' => 'salesman',
                'label' => 'Salesman',
                'rules' => 'required'
            ),
            array(
                'field' => 'amount_clearing',
                'label' => 'Amount',
                'rules' => 'required|regex_match[/^(\d*\.)?\d+$/]',
                'errors' => array(
                    'regex_match' =>'This Field can only contain positive numbers.'
                )
            ),
        );

	}

	public function index(){

        $this->data['user_id'] = $this->session->flashdata('user_id');

        if($this->input->is_ajax_request()){
            $salesman_id = $this->input->post('salesman_id');

            $client_where = ($salesman_id) ? "`delivery_config`.`delivery_boy_id` = {$salesman_id}" : " 1<>1";
        
            $client_payments_qry = "SELECT
                                    `clients`.`client_name`,
                                    `delivery_config_orders`.`order_id`,
                                    DATE_FORMAT(`delivery`.`actual_delivey_datetime`,'%Y-%m-%d') AS `delivey_date`,
                                    `delivery_config_orders`.`amount`	
                                FROM `delivery`
                                LEFT JOIN `delivery_config` ON `delivery_config`.`delivery_id` = `delivery`.`id`
                                LEFT JOIN `delivery_config_orders` ON `delivery_config_orders`.`delivery_config_id` = `delivery_config`.`id`
                                LEFT JOIN `orders` ON `orders`.`id` = `delivery_config_orders`.`order_id`
                                LEFT JOIN `clients` ON `clients`.`id` = `orders`.`client_id`
                                WHERE {$client_where}";

            $user_where = ($salesman_id) ? "user_id = {$salesman_id}" : " 1<>1";
                    
            $user_payments_qry = "SELECT
                            `cash_collection`.`id`,
                            `cash_collection`.`user_id`,
                            `cash_collection`.`amount`,
                            `cash_collection`.`created_at` AS `collection_date`
                        FROM `cash_collection`
                        WHERE {$user_where} AND `cash_collection`.`is_deleted`=0";

            $result = array(
                'client_payments' => $this->db->query($client_payments_qry)->result_array(),
                'user_payments' => $this->db->query($user_payments_qry)->result_array(),
            );
            echo json_encode($result);
            die;
        }

        if($this->input->server("REQUEST_METHOD") == "POST"){

            $this->form_validation->set_rules($this->cash_collection_validation_config);

            if ($this->form_validation->run() == TRUE) {

                $pending_amount_hidden = $this->input->post('pending_amount_hidden');
                $amount_clearing = $this->input->post('amount_clearing');
                $salesman = $this->input->post('salesman');

                $data = array(
                    'user_id'   =>  $salesman,
                    'amount'    =>  $amount_clearing,
                    'created_at'=>  date('Y-m-d'),
                    'created_by'=>  USER_ID,
                );

                if ($this->db->insert("cash_collection",$data)) {                ;
                    $this->flash("success", "Cash collected.");
                } else {
                    $this->flash('error', 'Some error ocurred. Please try again later.');
                }
                $this->flash("user_id", $salesman);
                redirect("cashcollection", 'location');

            }else{
                // echo "<pre>";print_r(validation_errors());die;
                $this->data['user_id'] = $this->input->post('salesman');
            }
        }


        $this->data['users'] = $this->db
                                    ->select("users.id,users.first_name,users.last_name,roles.role_name")
                                    ->join("roles","roles.id = users.role_id","left")
                                    ->where_in("role_id",[3,4])
                                    ->get("users")->result_array();   //2-Salesman
        // echo "<pre>";print_r($this->data['users']);die;

		$this->data['page_title'] = 'Cash Collection';
		$this->load_content('cash_collection/collection_list', $this->data);
    }

    public function delete($collection_id,$user_id){
        if($this->db->update("cash_collection",array('is_deleted'=>1),array('id'=>$collection_id))){
            $this->flash("success","Record deleted duccessfully");
        }else{
            $this->flash("error","Record not deleted");
        }
        $this->flash("user_id", $user_id);
        redirect("cashcollection");
    }

    public function int_and_float_check(){

    }

}