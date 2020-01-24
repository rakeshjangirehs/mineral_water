<?php

/* 
TRUNCATE TABLE `client_delivery_addresses`;
 */

$File = 'Excel Files/6. Client Delivery Addresses.csv';
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

                // Get Client Id and insert client delivery address

                $sr_no = $row[3];

                $stmt = $con->prepare("SELECT * FROM `clients` WHERE `clients`.`sr_no` = :sr_no");
                $stmt->execute([
                    ':sr_no' => $sr_no,
                ]);

                $client = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($client) {
                 
                    $client_id = $client['id'];

                    // Get Zip Code ID
                    $zip_code_id = NULL;
                    $zip_code = ($row[2]) ? $row[2] : NULL;


                    $stmt = $con->prepare("SELECT * FROM `zip_codes` WHERE `zip_codes`.`zip_code` = :zip_code");
                    $stmt->execute([
                        ':zip_code' => $zip_code,
                    ]);

                    $zip_code_arr = $stmt->fetch(PDO::FETCH_ASSOC);

                    if($zip_code_arr) {
                        $zip_code_id = $zip_code_arr['id'];
                    }

                    $title = ($row[0]) ? $row[0] : NULL;
                    $address = ($row[1]) ? $row[1] : NULL;

                    // Insert into client_delivery_addresses if not exist

                    $stmt = $con->prepare("SELECT * FROM `client_delivery_addresses` WHERE `client_delivery_addresses`.`address` = :address");
                    $stmt->execute([
                        ':address' => $address,
                    ]);

                    $client_delivery_address_arr = $stmt->fetch(PDO::FETCH_ASSOC);

                    if(!$client_delivery_address_arr) {
                        
                        $stmt = $con->prepare("INSERT INTO `client_delivery_addresses` (`client_id`, `title`, `address`, `zip_code_id`, `created_at`, `created_by`) VALUES (:client_id, :title, :address, :zip_code_id, :created_at, :created_by)");
                       
                        $stmt->execute([
                            ':client_id' => $client_id,
                            ':title' => $title,
                            ':address' => $address,
                            ':zip_code_id' => $zip_code_id,
                            ':created_at'   =>  $created_date,
                            ':created_by'   =>  $created_by,
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