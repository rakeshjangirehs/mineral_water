<?php
/* 
TRUNCATE TABLE `states`;
TRUNCATE TABLE  `cities`;
TRUNCATE TABLE  `zip_codes`;
TRUNCATE TABLE  `zip_code_groups`;
TRUNCATE TABLE  `group_to_zip_code`;
 */

// Why is there Address field

$File = 'Excel Files/3. ZIP Codes.csv';
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


                // Insert State if not exist and get state_id

                $state_name = $row[3];
                $stmt = $con->prepare("SELECT * FROM `states` WHERE `states`.`name` = :name");
                $stmt->execute([':name' => $state_name]);
                $state = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($state) {
                    $state_id = $state['id'];
                } else {
                    $stmt = $con->prepare("INSERT INTO `states` (`name`, `created_at`, `created_by`) VALUES (:name, :created_at, :created_by)");
                    $stmt->execute([
                        ':name' =>  $state_name,
                        ':created_at'   =>  $created_date,
                        ':created_by'   =>  $created_by
                    ]);

                    if ($stmt->rowCount() > 0) {
                        $state_id = $con->lastInsertId();
                    }
                }

                if($state_id) {

                    // Insert City if not exist and get city_id

                    $city_name = $row[2];
                    $stmt = $con->prepare("SELECT * FROM `cities` WHERE `cities`.`name` = :name");
                    $stmt->execute([':name' => $city_name]);
                    $city = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($city) {
                        $city_id = $city['id'];
                    } else {
                        $stmt = $con->prepare("INSERT INTO `cities` (`state_id`, `name`, `created_at`, `created_by`) VALUES (:state_id, :name, :created_at, :created_by)");
                        $stmt->execute([
                            ':state_id' =>  $state_id,
                            ':name' =>  $city_name,
                            ':created_at'   =>  $created_date,
                            ':created_by'   =>  $created_by
                        ]);

                        if ($stmt->rowCount() > 0) {
                            $city_id = $con->lastInsertId();
                        }
                    }

                    if($city_id) {

                        // Insert ZipCode Group if not exist and get zipcode_group_id

                        $group_name = $row[5];
                        $stmt = $con->prepare("SELECT * FROM `zip_code_groups` WHERE `zip_code_groups`.`group_name` = :group_name");
                        $stmt->execute([':group_name' => $group_name]);
                        $zip_code_group = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($zip_code_group) {
                            $zip_code_group_id = $zip_code_group['id'];
                        } else {
                            $stmt = $con->prepare("INSERT INTO `zip_code_groups` (`group_name`, `state_id`, `city_id`, `created_at`, `created_by`) VALUES (:group_name, :state_id, :city_id, :created_at, :created_by)");            
                            $stmt->execute([
                                ':group_name' =>  $group_name,
                                ':state_id' =>  $state_id,
                                ':city_id' =>  $city_id,
                                ':created_at'   =>  $created_date,
                                ':created_by'   =>  $created_by
                            ]);

                            if ($stmt->rowCount() > 0) {
                                $zip_code_group_id = $con->lastInsertId();
                            }
                        }

                        // Insert ZipCode if not exist and get zipcode_id

                        $zip_code = $row[1];
                        $area = $row[4];
                        $stmt = $con->prepare("SELECT * FROM `zip_codes` WHERE `zip_codes`.`zip_code` = :zip_code");
                        $stmt->execute([':zip_code' => $zip_code]);
                        $zip = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($zip) {
                            $zip_code_id = $zip['id'];
                        } else {
                            $stmt = $con->prepare("INSERT INTO `zip_codes` (`zip_code`, `city_id`, `state_id`, `area`, `created_at`, `created_by`) VALUES (:zip_code, :city_id, :state_id, :area, :created_at, :created_by)");            
                            $stmt->execute([
                                ':zip_code' =>  $zip_code,
                                ':city_id' =>  $city_id,
                                ':state_id' =>  $state_id,
                                ':area' =>  $area,
                                ':created_at'   =>  $created_date,
                                ':created_by'   =>  $created_by
                            ]);

                            if ($stmt->rowCount() > 0) {
                                $zip_code_id = $con->lastInsertId();
                            }
                        }

                        if($zip_code_group_id && $zip_code_id) {

                            //Insert ZipCodeGroup to ZipCode mapping if not exist

                            $stmt = $con->prepare("SELECT * FROM `group_to_zip_code` WHERE `group_to_zip_code`.`zip_code_group_id` = :zip_code_group_id AND `group_to_zip_code`.`zip_code_id` = :zip_code_id");
                            $stmt->execute([
                                ':zip_code_group_id' => $zip_code_group_id,
                                ':zip_code_id' => $zip_code_id
                            ]);
                            $group_to_zip_code = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($group_to_zip_code) {

                            } else {

                                $stmt = $con->prepare("INSERT INTO `group_to_zip_code` (`zip_code_group_id`, `zip_code_id`, `created_at`, `created_by`) VALUES (:zip_code_group_id, :zip_code_id, :created_at, :created_by)");            
                                $stmt->execute([
                                    ':zip_code_group_id' =>  $zip_code_group_id,
                                    ':zip_code_id' =>  $zip_code_id,
                                    ':created_at'   =>  $created_date,
                                    ':created_by'   =>  $created_by
                                ]);
                            }
                        }
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