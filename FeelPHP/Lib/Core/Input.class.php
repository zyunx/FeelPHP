<?php

class Input {

    protected $inputValidations;

    /*
     * Example:
     * $inputValidations = array(
      'email' => array(
      'validation' => FILTER_VALIDATE_EMAIL,
      'message' => 'Email is not valid.',
      ),
      'password' => array(
      'validation' => FILTER_DEFAULT,
      'message' => 'Password can\'t be empty.',
      ),
      'role' => array(
      'validation' => array(
      'filter' => FILTER_CALLBACK,
      'options' => array($this, "_filter_user_role")),
      'message' => 'Role is invalid.',
      ),
      'status' => array(
      'validation' => array(
      'filter' => FILTER_CALLBACK,
      'options' => array($this, "_filter_user_status")),
      'message' => 'Status is invalid.',
      ),
      'nickname' => FALSE,
      'realname' => FALSE,
      'bio' => FALSE,
      );
     */

    public function __construct($inputValidations) {
        $this->inputValidations = $inputValidations;
    }

    public function validate($errorTemplate) {
        $orignalInputVars = array_intersect_key($_POST, $this->inputValidations);

        $validationErrorMessage = array();
        foreach ($this->inputValidations as $key => $value) {
            if (is_array($value)) {
                $validationErrorMessage[$key] = $value['message'];
            }
        }

        $validationArray = array();
        foreach ($this->inputValidations as $key => $value) {
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

}
