<?php

use DebugBar\StandardDebugBar as DebugBar;

class Debug
{
    private static $debugBar;
    private static $ci;

    public static function init()
    {
        self::$debugBar = new DebugBar();
        self::$ci &= get_instance();
    }

    public static function getDebugBar()
    {
        return self::$debugBar;
    }

    public static function log($message, $type = 'info', $collector = 'messages')
    {
        if(ENVIRONMENT == 'production' || self::$debugBar === null)
        {
            return;
        }

        if($message instanceof \Exception)
        {
            self::getDebugBar()->getCollector('exceptions')->addException($message);
            return;
        }

        self::getDebugBar()->getCollector($collector)->addMessage($message, $type, is_string($message));
    }

    public static function logFlash($message, $type = 'info', $collector = 'messages')
    {
        if(ENVIRONMENT == 'production' || self::$debugBar === null)
        {
            return;
        }

        $messages   = self::$ci->session->flashdata('_debug_bar_flash');
        $messages[] = [ $message, $type, $collector ];
        
        self::$ci->session->set_flashdata('_debug_bar_flash', $messages);
    }

    public static function addCollector($dataCollector)
    {
        if(ENVIRONMENT == 'production' || self::$debugBar === null)
        {
            return;
        }

        self::getDebugBar()->addCollector($dataCollector);
    }

    public static function prepareOutput(&$output)
    {
        if(ENVIRONMENT != 'production' && !get_instance()->input->is_ajax_request() && !is_cli() && self::$debugBar !== null)
        {            
            $debugbarRenderer = self::$debugBar->getJavascriptRenderer()->setBaseUrl(base_url().'vendor/maximebf/debugbar/src/DebugBar/Resources/');
            $output = str_ireplace('</head>', $debugbarRenderer->renderHead() . '</head>', $output);
            $output = str_ireplace('</body>', $debugbarRenderer->render() . '</body>', $output);
        }
    }
}