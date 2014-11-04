<?php
error_reporting(E_ALL);
ini_set('display_errors','on');
//display_errors('stdout');

define('SITE_PATH', dirname(__FILE__));
define('APP_PATH', SITE_PATH . '/Setup');
define('FEEL_PHP_PATH', SITE_PATH . '/FeelPHP');


//echo "HELLO";
//echo SITE_PATH;
require FEEL_PHP_PATH . '/FeelPHP.php'; 