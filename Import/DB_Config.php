<?php

define('ENVIRONMENT', 'development');
// define('ENVIRONMENT', 'testing');
// define('ENVIRONMENT', 'production');

$config_file = "config-development.xml";
switch (ENVIRONMENT)
{
	case 'development':
		$config_file = "config-development.xml";
	break;

	case 'testing':
		$config_file = "config-testing.xml";
	case 'production':
		$config_file = "config-production.xml";
	    break;
    default:
        $config_file = "config-development.xml";
}

$config_path = "../".$config_file;
require_once "../load_config_xml.php";

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