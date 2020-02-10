<?php

include_once("DB_Config.php");

try{
 
    $dsn      = "mysql:dbname=". DATABASE ."; host=". HOST_NAME;
    
    $options  = array(
        PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
    ); 

    $con = new PDO($dsn, USRE_NAME, PASSWORD, $options);

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