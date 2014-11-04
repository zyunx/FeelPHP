<?php

class View
{
    protected $configs;
    protected $vars;
    
    // layout related variable
    protected $layoutVars;
    
    public function __constuct()
    {
        $this->vars = array();
        $this->configs = array();
    }
    
    public function config($name, $value)
    {
        $this->configs[$name] = $value;
    }
    
    public function display($templ=NULL)
    {
        if (empty($templ)) $templ = APP_TEMPLATE_PATH . '/' . ACTION_CLASS . '/' . ACTION_METHOD . '.template.php';
        
        if(!empty($this->vars)) extract($this->vars);
        
        if(isset($this->configs['layout']) && $this->configs['layout'])
        {
            if (empty($layout_content)) 
                $layout_content = $templ;
                    
            include APP_TEMPLATE_PATH . '/' . $this->configs['layout'];
        }
        else
        {
            
            include $templ;
        }
    }
    
    public function assign($name, $value = NULL)
    {
        if (is_array($name)) {
            foreach ($name as $k => $v)
            {
                $this->vars[$k] = $v;
            }
        } else {
            if (is_null($value)) {
                $this->unassign($name);
            } else {
                $this->vars[$name] = $value;
            }
        }
    }
    public function unassign($name)
    {
        unset($this->vars[$name]);
    }

}
