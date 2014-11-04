<?php
require_once FEEL_LIB_CORE_PATH . '/Singleton.class.php';

class Config extends Singleton
{
    protected $_config;
    
    public function init($cfg = array())
    {
        
        $this->_config = $cfg;
    }
    
    public function set($name, $value)
    {
        if(empty($name)) {
            return FALSE;
        }
        
        $fields = explode('.', $name);
        $c = &$this->_config;
        
        while (count($fields) > 1)
        {
            $f = array_shift($fields);
            
            if (!is_array($c[$f])) {
                $c[$f] = array();
            }
            $c = &$c[$f];
        }
        
        $c[$fields[0]] = $value;
        //$c = array_merge($c, array($fields[0] => $value));
    }
    
    public function get($name = NULL)
    {
        if (empty($name)) {
            return $this->_config;
        }
        
        $fields = explode('.', $name);
        //print_r($fields);
        $c = &$this->_config;
        while (isset($c) && !empty($fields))
        {
            $c = &$c[array_shift($fields)];
            
        }
        return $c;
    }
}
