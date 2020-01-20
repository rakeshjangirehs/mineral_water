<?php
/* 
TRUNCATE TABLE `roles`;
TRUNCATE TABLE `users`;
TRUNCATE TABLE `user_zip_code_groups`;
TRUNCATE TABLE `user_zip_codes`;
 */

$File = 'Excel Files/4. Users.csv';
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


                // Insert Role if not exist and get role_id

                $role_name = $row[4];

                $stmt = $con->prepare("SELECT * FROM `roles` WHERE `roles`.`role_name` = :role_name");
                $stmt->execute([':role_name' => $role_name]);
                $role = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($role) {
                    $role_id = $role['id'];
                } else {
                    $stmt = $con->prepare("INSERT INTO `roles` (`role_name`, `created_at`, `created_by`) VALUES (:role_name, :created_at, :created_by)");
                    $stmt->execute([
                        ':role_name' =>  $role_name,
                        ':created_at'   =>  $created_date,
                        ':created_by'   =>  $created_by
                    ]);

                    if ($stmt->rowCount() > 0) {
                        $role_id = $con->lastInsertId();
                    }
                }

                if($role_id) {

                    // Insert User if not exist and get user_id

                    $first_name = $row[0];
                    $last_name = ($row[1]) ? $row[1] : NULL;
                    $username = $row[5];
                    $password = $row[6];

                    $email = $row[2];
                    $phone = $row[3];

                    $stmt = $con->prepare("SELECT * FROM `users` WHERE `users`.`email` = :email AND `users`.`phone` = :phone");
                    $stmt->execute([
                        ':email' => $email,
                        ':phone' => $phone,
                    ]);

                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($user) {
                        $user_id = $user['id'];
                    } else {
                        $stmt = $con->prepare("INSERT INTO `users` (`first_name`, `last_name`, `email`, `phone`, `role_id`, `username`, `password`, `created_at`, `created_by`) VALUES (:first_name, :last_name, :email, :phone, :role_id, :username, :password, :created_at, :created_by)");
                        $stmt->execute([
                            ':first_name' =>  $first_name,
                            ':last_name' =>  $last_name,
                            ':email' =>  $email,
                            ':phone' =>  $phone,
                            ':role_id' =>  $role_id,
                            ':username' =>  $username,
                            ':password' =>  $password,
                            ':created_at'   =>  $created_date,
                            ':created_by'   =>  $created_by
                        ]);

                        if ($stmt->rowCount() > 0) {
                            $user_id = $con->lastInsertId();
                        }
                    }     
                    
                    if($user_id) {

                        // Insert into user_zip_code_groups if zip_code_Group found

                        $group_name = $row[7];
                        
                        if ($group_name == "All") {

                            $stmt = $con->prepare("SELECT * FROM `zip_code_groups`");
                            $stmt->execute();

                            $zip_code_groups = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach($zip_code_groups AS $zip_code_group) {

                                $zip_code_group_id = $zip_code_group['id'];

                                $stmt = $con->prepare("SELECT * FROM `user_zip_code_groups` WHERE `user_zip_code_groups`.`user_id` = :user_id AND `user_zip_code_groups`.`zip_code_group_id` = :zip_code_group_id");
                                $stmt->execute([
                                    ':user_id' => $user_id,
                                    ':zip_code_group_id' => $zip_code_group_id,
                                ]);
                                
                                if ($stmt->rowCount() == 0) {

                                    $stmt = $con->prepare("INSERT INTO `user_zip_code_groups` (`user_id`, `zip_code_group_id`, `created_at`, `created_by`) VALUES (:user_id, :zip_code_group_id, :created_at, :created_by)");
                                    $stmt->execute([
                                        ':user_id' =>  $user_id,
                                        ':zip_code_group_id' =>  $zip_code_group_id,
                                        ':created_at'   =>  $created_date,
                                        ':created_by'   =>  $created_by
                                    ]);
                                }
                            }

                        } else {

                            $stmt = $con->prepare("SELECT * FROM `zip_code_groups` WHERE `zip_code_groups`.`group_name` = :group_name");
                            $stmt->execute([':group_name' => $group_name]);

                            $zip_code_group = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($zip_code_group) {
                                
                                $zip_code_group_id = $zip_code_group['id'];

                                $stmt = $con->prepare("SELECT * FROM `user_zip_code_groups` WHERE `user_zip_code_groups`.`user_id` = :user_id AND `user_zip_code_groups`.`zip_code_group_id` = :zip_code_group_id");
                                $stmt->execute([
                                    ':user_id' => $user_id,
                                    ':zip_code_group_id' => $zip_code_group_id,
                                ]);

                                if ($stmt->rowCount() == 0) {

                                    $stmt = $con->prepare("INSERT INTO `user_zip_code_groups` (`user_id`, `zip_code_group_id`, `created_at`, `created_by`) VALUES (:user_id, :zip_code_group_id, :created_at, :created_by)");
                                    $stmt->execute([
                                        ':user_id' =>  $user_id,
                                        ':zip_code_group_id' =>  $zip_code_group_id,
                                        ':created_at'   =>  $created_date,
                                        ':created_by'   =>  $created_by
                                    ]);
                                }
                            }
                        }

                        // Insert into user_zip_codes if zip_code_id found

                        $zip_code_array = ($row[8]) ? explode(",",$row[8]) : NULL;

                        if ($zip_code_array) {

                            foreach($zip_code_array AS $zip_code) {
                                
                                $zip_code = trim($zip_code);

                                $stmt = $con->prepare("SELECT * FROM `zip_codes` WHERE `zip_codes`.`zip_code` = :zip_code");
                                $stmt->execute([':zip_code' => $zip_code]);
                                $zip_code_rs = $stmt->fetch(PDO::FETCH_ASSOC);

                                if ($zip_code_rs) {
                                    
                                    $zip_code_id = $zip_code_rs['id'];

                                    $stmt = $con->prepare("SELECT * FROM `user_zip_codes` WHERE `user_zip_codes`.`user_id` = :user_id AND `user_zip_codes`.`zip_code_id` = :zip_code_id");
                                    $stmt->execute([
                                        ':user_id' => $user_id,
                                        ':zip_code_id' => $zip_code_id,
                                    ]);

                                    if ($stmt->rowCount() == 0) {
                                        $stmt = $con->prepare("INSERT INTO `user_zip_codes` (`user_id`, `zip_code_id`, `created_at`, `created_by`) VALUES (:user_id, :zip_code_id, :created_at, :created_by)");
                                        $stmt->execute([
                                            ':user_id' =>  $user_id,
                                            ':zip_code_id' =>  $zip_code_id,
                                            ':created_at'   =>  $created_date,
                                            ':created_by'   =>  $created_by
                                        ]);
                                    }                                    
                                }
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