<?php
/* 
TRUNCATE TABLE `vehicle`;
 */

$File = 'Excel Files/2. Vehicle.csv';
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

                $name = $row[0];
                $number = $row[1];
                $capacity_in_ton = $row[2];

                $stmt = $con->prepare("SELECT * FROM `vehicle` WHERE `vehicle`.`name` = :name AND `vehicle`.`number` = :number AND `vehicle`.`capacity_in_ton` = :capacity_in_ton");
                $stmt->execute([
                    ':name' => $name,
                    ':number' => $number,
                    ':capacity_in_ton' => $capacity_in_ton,
                ]);
                $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($vehicle) {
                    $vehicle_id = $vehicle['id'];
                } else {
                    $stmt = $con->prepare("INSERT INTO `vehicle` (`name`, `number`, `capacity_in_ton`, `created_at`, `created_by`) VALUES (:name, :number, :capacity_in_ton, :created_at, :created_by)");
                    $stmt->execute([
                        ':name' =>  $name,
                        ':number' =>  $number,
                        ':capacity_in_ton' =>  $capacity_in_ton,
                        ':created_at'   =>  $created_date,
                        ':created_by'   =>  $created_by
                    ]);

                    if ($stmt->rowCount() > 0) {
                        $vehicle_id = $con->lastInsertId();
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