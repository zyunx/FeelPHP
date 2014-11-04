<?php

define('FEEL_PATH', dirname(__FILE__));
define('FEEL_LIB_PATH', FEEL_PATH . '/Lib');
define('FEEL_LIB_CORE_PATH', FEEL_LIB_PATH . '/Core');
define('FEEL_LIB_UTIL_PATH', FEEL_LIB_PATH . '/Util');
define('FEEL_COMMON_PATH', FEEL_PATH . '/Common');

define('APP_LIB_PATH', APP_PATH . '/Lib');
define('APP_ACTION_PATH', APP_LIB_PATH . '/Action');
define('APP_TEMPLATE_PATH', APP_PATH . '/Template');
define('APP_CONFIG_FILE', APP_PATH . '/Conf/config.php');


// 
define('APP_URL', $_SERVER['SCRIPT_NAME']);
define('APP_ROOT', dirname(APP_URL));

define('PUBLIC_URL', APP_ROOT . '/Public');

function feelphp_error_handler($errno, $errstr, $errfile, $errline)
{
    debug_print_backtrace();
    echo "<h1>File: $errfile<br/>Line: $errline<br/>[$errno]:$errstr</h1>";
}
set_error_handler('feelphp_error_handler', E_ALL);

spl_autoload_register(function($className) {
    $fileName = $className . '.class.php';
    if(is_file(APP_ACTION_PATH . '/' . $fileName)) {
        include APP_ACTION_PATH . '/' . $fileName;
    } else if(is_file(FEEL_LIB_CORE_PATH . '/' . $fileName)) {
        include FEEL_LIB_CORE_PATH . '/' . $fileName;
    } else if (is_file(FEEL_LIB_UTIL_PATH . '/' . $fileName)) {
        include FEEL_LIB_UTIL_PATH . '/' . $fileName;
    }
});
    
session_start();

// init configuration
require_once FEEL_LIB_CORE_PATH . '/Config.class.php';
Config::getInstance()->init(include APP_CONFIG_FILE);

require_once FEEL_COMMON_PATH . '/common.php';

// route request
require_once FEEL_LIB_CORE_PATH . '/Router.class.php';
Router::getInstance()->dispatch();

