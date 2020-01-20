<?php
/* 
TRUNCATE TABLE `vehicle`;
 */

$File = 'Excel Files/1. Products.csv';
$created_date = date('Y-m-d H:i:s');
$created_by = 999;

include_once('Connection.php');

$arrResult  = array();
$handle     = fopen($File, "r");
if(empty($handle) === false) {
    while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
        $arrResult[] = $data;
    }
    fclose($handle);
}

// echo "<pre>";print_r($arrResult);die;

if (!empty($arrResult)) {

    try {

        //We start our transaction.
        $con->beginTransaction();
            foreach($arrResult as $k=>$row) {
                
                // First Row is header row don't use it
                if ($k == 0) continue;


                // Insert Brand if not exist and get brand_id

                $brand_name = $row[0];

                $stmt = $con->prepare("SELECT * FROM `brands` WHERE `brands`.`brand_name` = :brand_name");
                $stmt->execute([
                    ':brand_name' => $brand_name,
                ]);
                $brand = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($brand) {
                    $brand_id = $brand['id'];
                } else {
                    $stmt = $con->prepare("INSERT INTO `brands` (`brand_name`, `created_at`, `created_by`) VALUES (:brand_name, :created_at, :created_by)");
                    $stmt->execute([
                        ':brand_name' =>  $brand_name,
                        ':created_at'   =>  $created_date,
                        ':created_by'   =>  $created_by
                    ]);

                    if ($stmt->rowCount() > 0) {
                        $brand_id = $con->lastInsertId();
                    }
                }

                if($brand_id) {

                    // Insert Product if not exist and get product_id

                    $product_name = $row[1];
                    $product_code = ($row[2]) ? $row[2] : NULL;
                    $description = ($row[3]) ? $row[3] : NULL;
                    $weight = ($row[4]) ? $row[4] : NULL;                
                    $cost_price = ($row[5]) ? $row[5] : NULL;
                    $sale_price = ($row[6]) ? $row[6] : NULL;
                    $manage_stock_needed = ($row[7] == 'Y') ? 1 : 0;


                    $stmt = $con->prepare("SELECT * FROM `products` WHERE `products`.`product_code` = :product_code");
                    $stmt->execute([
                        ':product_code' => $product_code,
                    ]);
                    
                    if ($stmt->rowCount() == 0) {
                        
                        $stmt = $con->prepare("INSERT INTO `products` (`brand_id`, `product_name`, `product_code`, `description`, `weight`, `cost_price`, `sale_price`, `manage_stock_needed`,  `created_at`, `created_by`) VALUES (:brand_id, :product_name, :product_code, :description, :weight, :cost_price, :sale_price, :manage_stock_needed, :created_at, :created_by)");
                        $stmt->execute([
                            ':brand_id' =>  $brand_id,
                            ':product_name' =>  $product_name,
                            ':product_code' =>  $product_code,
                            ':description' =>  $description,
                            ':weight' =>  $weight,
                            ':cost_price' =>  $cost_price,
                            ':sale_price' =>  $sale_price,
                            ':manage_stock_needed' =>  $manage_stock_needed,
                            ':created_at'   =>  $created_date,
                            ':created_by'   =>  $created_by
                        ]);
                    }
                }
            }

            echo "Date Imported Successfully<br/>";

            //We've got this far without an exception, so commit the changes.
            $con->commit();

    } catch (Exception $e) {

        echo "<pre>";print_r($row);
        echo "Execption : " . $e->getMessage() . "<br/>";

        //Rollback the transaction.
        $con->rollBack();
    }
}