<?php

class Action
{
    protected $view;
    
    public function __construct()
    {
        $this->view = new View();
    }
    
    public function display($templ=NULL)
    {
        $this->view->display($templ);
    }
    
    public function assign($name, $value = NULL)
    {
        $this->view->assign($name, $value);
    }
    
    
    public function validate($inputValidations, $errorTemplate)
    {
        $orignalInputVars = array_intersect_key($_POST, $inputValidations);

        $validationErrorMessage = array();
        foreach ($inputValidations as $key => $value) {
            if (is_array($value)) {
                $validationErrorMessage[$key] = $value['message'];
            }
        }

        $validationArray = array();
        foreach ($inputValidations as $key => $value) {
            if (is_array($value)) {
                $validationArray[$key] = $value['validation'];
            }
        }

        $filteredInputVars = filter_var_array($orignalInputVars, $validationArray);
        $isInputValid = TRUE;
        $alert = new Alert();
        $invalidInputVars = array();
        foreach ($filteredInputVars as $varName => $varValue) {
            if (empty($varValue)) {
                $isInputValid = FALSE;
                $invalidInputVars[$varName] = $varValue;
                $alert->alert('danger', $validationErrorMessage[$varName]);
            }
        }

        if (!$isInputValid) {
            $this->assign('invalid_input', $invalidInputVars);
            $this->assign('alert', $alert->show());
            $this->assign($orignalInputVars);
            $this->display($errorTemplate);
            return FALSE;
        } else {

            $inputVars = array();
            foreach ($orignalInputVars as $varName => $varValue) {
                if (in_array($varName, array_keys($filteredInputVars))) {
                    $inputVars[$varName] = $filteredInputVars[$varName];
                } else {
                    $inputVars[$varName] = filter_input(INPUT_POST, $varName);
                }
            }

            return $inputVars;
        }
    }
    
    
    public function redirect($url)
    {
        header("Location: $url");
    }

}

