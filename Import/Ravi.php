<?php
/* 
TRUNCATE TABLE `vehicle`;
 */

$File = 'Excel Files/2. Vehicle.csv';

$created_date = date('Y-m-d H:i:s');
$created_by = 999;

include_once('Connection.php');

$stmt = $con->prepare("SELECT * FROM `team_master` where find_in_set('30',`members`)");
$stmt->execute();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($records as $record) {

    $members = $record['members'];
    
}