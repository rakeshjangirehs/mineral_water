<?php

// ALTER TABLE `clients` ADD `sr_no` VARCHAR(20) NULL DEFAULT NULL AFTER `category_id`;

/* 
TRUNCATE TABLE `clients`;
TRUNCATE TABLE `client_categories`;
 */

$File = 'Excel Files/5. Clients.csv';
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

                // Insert Client Category if not exist and get category_id

                $name = $row[12];

                $stmt = $con->prepare("SELECT * FROM `client_categories` WHERE `client_categories`.`name` = :name");
                $stmt->execute([
                    ':name' => $name,
                ]);
                $client_category = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($client_category) {
                    $category_id = $client_category['id'];
                } else {

                    $stmt = $con->prepare("INSERT INTO `client_categories` (`name`, `created_at`, `created_by`) VALUES (:name, :created_at, :created_by)");
                    $stmt->execute([
                        ':name' =>  $name,
                        ':created_at'   =>  $created_date,
                        ':created_by'   =>  $created_by
                    ]);

                    if ($stmt->rowCount() > 0) {
                        $category_id = $con->lastInsertId();
                    }
                }

                if($category_id) {

                    // Get ZipCodeId

                    $zip_code_id = NULL;
                    $zip_code = $row[6];

                    $stmt = $con->prepare("SELECT * FROM `zip_codes` WHERE `zip_codes`.`zip_code` = :zip_code");
                    $stmt->execute([
                        ':zip_code' => $zip_code,
                    ]);

                    $zip_code_arr = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($zip_code_arr) {
                        $zip_code_id = $zip_code_arr['id'];
                    }

                    // Get State and City Id
                    $city_id = NULL;
                    $state_id = NULL;
                    $city_name = $row[4];

                    $stmt = $con->prepare("SELECT * FROM `cities` WHERE `cities`.`name` = :city_name");
                    $stmt->execute([
                        ':city_name' => $city_name,
                    ]);

                    $city = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($city) {
                        $city_id = $city['id'];
                        $state_id = $city['state_id'];
                    }                    

                    // Insert Client If not exist and get client_id

                    $sr_no = $row[0];
                    $client_name = $row[1];
                    $credit_limit = ($row[2] && $row[2]!='_') ? $row[2] : 0;
                    $address = ($row[3] && $row[3]!='_') ? $row[3] : NULL;                    
                    $contact_person_name_1 = ($row[7] && $row[7]!='_') ? $row[7] : NULL;
                    $contact_person_1_phone_1 = ($row[8] && $row[8]!='_') ? $row[8] : NULL;
                    $contact_person_1_phone_2 = ($row[9] && $row[9]!='_') ? $row[9] : NULL;
                    $contact_person_1_email = ($row[10] && $row[10]!='_') ? $row[10] : NULL;
                    $gst_no = ($row[11] && $row[11]!='_') ? $row[11] : NULL;
                    

                    $stmt = $con->prepare("SELECT * FROM `clients` WHERE `clients`.`client_name` = :client_name AND `clients`.`zip_code_id` = :zip_code_id");
                    $stmt->execute([
                        ':client_name' => $client_name,
                        ':zip_code_id' => $zip_code_id,
                    ]);

                    if ($stmt->rowCount() == 0) {

                        $stmt = $con->prepare("INSERT INTO `clients` (`sr_no`, `client_name`, `credit_limit`, `address`, `city_id`, `state_id`, `zip_code_id`, `contact_person_name_1`, `contact_person_1_phone_1`, `contact_person_1_phone_2`, `contact_person_1_email`, `gst_no`, `category_id`, `created_at`, `created_by`) VALUES (:sr_no, :client_name, :credit_limit, :address, :city_id, :state_id, :zip_code_id, :contact_person_name_1, :contact_person_1_phone_1, :contact_person_1_phone_2, :contact_person_1_email, :gst_no, :category_id, :created_at, :created_by)");
                        
                        $stmt->execute([
                            ':sr_no' =>  $sr_no,
                            ':client_name' =>  $client_name,
                            ':credit_limit' =>  $credit_limit,
                            ':address' =>  $address,
                            ':city_id' =>  $city_id,
                            ':state_id' =>  $state_id,
                            ':zip_code_id' =>  $zip_code_id,
                            ':contact_person_name_1' =>  $contact_person_name_1,
                            ':contact_person_1_phone_1' =>  $contact_person_1_phone_1,
                            ':contact_person_1_phone_2' =>  $contact_person_1_phone_2,
                            ':contact_person_1_email' =>  $contact_person_1_email,
                            ':gst_no' =>  $gst_no,
                            ':category_id' =>  $category_id,
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