<?php
require_once FEEL_LIB_CORE_PATH . '/Action.class.php';

class AdminBaseAction extends Action
{
    public function __construct() {
        parent::__construct();
        
        $this->view->config('layout', 'layout.template.php');
        
        $this->_initialize();
    }
    
    protected function _initialize() {
        if(Authn::getInstance()->isSignin()) {
            
        } else {
            $this->redirect(U('Sign/signinForm'));
        }
    }
}
