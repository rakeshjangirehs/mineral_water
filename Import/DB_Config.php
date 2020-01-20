<?php

// Database Configuration
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'letsolnx_neervana';


function clean($string) {
    $clean_code = preg_replace('/[^a-zA-Z0-9]/', '', $string);
    return $clean_code;
}

function date_convert($str = NULL) {
	$from_date_array = explode('/', $str);
    return $from_date_array[2] . '-' . $from_date_array[0] . '-' . $from_date_array[1];
}


function date_convert_doj($str = NULL) {
	
    $from_date_array = explode('-', $str);
    return $from_date_array[0] . '-' . $from_date_array[1] . '-' . $from_date_array[2];
}