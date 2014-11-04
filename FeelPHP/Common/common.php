<?php

require_once FEEL_LIB_CORE_PATH . '/Config.class.php';

function C($name = NULL, $value = NULL)
{
    if (empty($value)) {
        return Config::getInstance()->get($name);
    } else {
        return Config::getInstance()->set($name, $value);
    }
    
}

function U($path) {
    return APP_URL . '/' . $path;
}

function fp_setcookie($name, $value, 
        $expire = 0, $path = APP_ROOT, $domain = '', 
        $secure = false, $httponly = false)
{
    return setcookie($name, $value, $expire, $domain, $secure, $httponly);
}