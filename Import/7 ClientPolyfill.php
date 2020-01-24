<?php
/* 
TRUNCATE TABLE `vehicle`;
 */

$File = 'Excel Files/2. Vehicle.csv';
$created_date = date('Y-m-d H:i:s');
$created_by = 999;

include_once('Connection.php');

try {

    //We start our transaction.
    $con->beginTransaction();
    
    //Get Products
    $stmt = $con->prepare("SELECT * FROM `products` WHERE `products`.`is_deleted` = 0");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // echo "<pre>";print_r($products);die;   

    if($products) {

        // Get Clients
        $stmt = $con->prepare("SELECT * FROM `clients`");
        $stmt->execute();
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // echo "<pre>";print_r($clients);die;

        foreach($clients as $k=>$client) {

            $client_id = $client['id'];

            // echo "<pre>";print_r($client);die;

            if($products){

                foreach($products as $prodc) {

                    $product = array(
                        'product_id'    =>  $prodc['id'],
                        'sale_price'    =>  $prodc['sale_price'],
                        'client_id'     =>  $client_id,
                        'created_at'    =>  date('Y-m-d H:i:s'),
                        'created_by'    =>  999,
                        'status'        =>  'Active'
                    );

                    // echo "<pre>";print_r($product);die;


                    // Check if product not exist already
                    $stmt = $con->prepare("SELECT * FROM `client_product_price` WHERE `client_product_price`.`client_id` = :client_id AND `client_product_price`.`product_id` = :product_id");
                    $stmt->execute([
                        ':client_id' => $product['client_id'],
                        ':product_id' => $product['product_id'],
                    ]);
                    
                    if ($stmt->rowCount() == 0) {

                        $stmt = $con->prepare("INSERT INTO `client_product_price` (`product_id`, `sale_price`, `client_id`, `created_at`, `created_by`, `status`) VALUES (:product_id, :sale_price, :client_id, :created_at, :created_by, :status)");

                        $stmt->execute([
                            ':product_id' => $product['product_id'],
                            ':sale_price' => $product['sale_price'],
                            ':client_id' => $product['client_id'],
                            ':created_at' => $product['created_at'],
                            ':created_by' => $product['created_by'],
                            ':status' => $product['status'],
                        ]);
                    }
                }                
            }            
        }

        echo "Date Imported Successfully<br/>";
    } else {
        echo "No Products to Import<br/>";
    }

    //We've got this far without an exception, so commit the changes.
    $con->commit();

} catch (Exception $e) {

    echo "<pre>";print_r($row);
    echo "Execption : " . $e->getMessage() . "<br/>";

    //Rollback the transaction.
    $con->rollBack();
}