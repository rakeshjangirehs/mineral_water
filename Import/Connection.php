<?php

include_once("DB_Config.php");

try{
 
    $dsn      = "mysql:dbname={$dbname}; host={$host}";
    
    $options  = array(
        PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
    ); 

    $con = new PDO($dsn, $username, $password, $options);

    if($con){
        echo 'Connected to Database.<br/>';
    }
    else{
        echo $con;
    }
    
} catch (PDOException $ex) {
    echo $ex->getMessage();
}

?>