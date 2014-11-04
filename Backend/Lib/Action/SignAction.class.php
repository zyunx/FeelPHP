<?php

class SignAction extends Action {
    
    public function signinForm() {
        $this->display();
    }
    public function signin() {
        $inputValidations = array(
            'email' => FALSE,
            'password' => FALSE,
            'remember_me' => FALSE,
        );
        
        $inputVars = $this->validate($inputValidations, APP_TEMPLATE_PATH . '/Sign/signinForm.template.php' );
        
        $myVars = array();
        foreach($inputVars as $k => $v)
        {
            $myVars[$k] = FeelMySQLi::getInstance()->escape_string($v);
        }
        
        $alert = new Alert();
        if (Authn::getInstance()->signin($myVars['email'], $myVars['password'], isset($myVars['remember_me']))) {
            $this->redirect(U('User/index'));
        } else {
            $alert->alert('danger', 'Email or Password is invalid.');
            $this->assign('email', $inputVars['email']);
            $this->assign('remember_me', isset($inputVars['remember_me']) ? $inputValidations['remember_me'] : NULL);
            $this->assign('alert', $alert->show());
            $this->display(APP_TEMPLATE_PATH . '/Sign/signinForm.template.php');
        }
        
    }
    
    public function logout()
    {
        Authn::getInstance()->logout();
        $this->redirect(APP_URL . '/Sign/signinForm');
    }
    /*
    public function isSignin()
    {
        echo Authn::getInstance()->isSignin() ? 'TRUE' : 'FALSE';
    }*/
}