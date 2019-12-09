<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/


$hook['pre_controller'] = function(){

    require_once(APPPATH.'libraries/debug.php');
    $isCli  =  is_cli();
    $isWeb  = !is_cli();
    $isAjax =  isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
                    && (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
                    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');

    if( ENVIRONMENT != 'production' && !$isCli && !$isAjax){        
        $debugbar = Debug::init();
    }
};

$hook['display_override'] = function(){

    $output = get_instance()->output->get_output();

    if(isset(get_instance()->db))
    {
        $queries = get_instance()->db->queries;

        if(!empty($queries))
        {
            Debug::addCollector(new \DebugBar\DataCollector\MessagesCollector('database'));
            foreach($queries as $query)
            {
                Debug::log($query, 'info', 'database');
            }
        }
    }

    Debug::prepareOutput($output);
    get_instance()->output->_display($output);
};