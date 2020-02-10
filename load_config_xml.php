<?php

if(file_exists($config_path)){
    $xml=simplexml_load_file($config_path) or die("Error: Cannot load {$config_file}.");
    defined('BASE_URL')        OR define('BASE_URL', $xml->BASE_URL);
    defined('HOST_NAME')        OR define('HOST_NAME', $xml->MYSQL->HOST_NAME);
    defined('DATABASE')        OR define('DATABASE', $xml->MYSQL->DATABASE);
    defined('USRE_NAME')        OR define('USRE_NAME', $xml->MYSQL->USRE_NAME);
    defined('PASSWORD')        OR define('PASSWORD', $xml->MYSQL->PASSWORD);

}else{
    echo "Configuration Missing";
    die;
}