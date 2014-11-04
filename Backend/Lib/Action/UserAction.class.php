<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MemberAction
 *
 * @author cloud
 */
require_once FEEL_LIB_CORE_PATH . '/FeelMySQLi.class.php';
require_once FEEL_LIB_CORE_PATH . '/Input.class.php';
require_once FEEL_LIB_UTIL_PATH . '/Alert.class.php';
require_once APP_ACTION_PATH . '/AdminBaseAction.class.php';

class UserAction extends AdminBaseAction {

    // custom filter callback
    public function _filter_enum($var, $enumArray) {
        if (in_array($var, $enumArray)) {
            return $var;
        } else {
            return '';
        }
    }

    public function _filter_user_role($var) {
        return $this->_filter_enum($var, array_values(C('USER_ROLE')));
    }

    public function _filter_user_status($var) {
        return $this->_filter_enum($var, array_values(C('USER_STATUS')));
    }

    private function _getUserTableData() {
        $sql = "SELECT count(*) as total_rows FROM bl_user";
        $result = FeelMySQLi::getInstance()->query($sql);
        $totalRows = 0;
        if ($result) {
            $row = $result->fetch_assoc();
            if ($row) {
                $totalRows = $row['total_rows'];
            }
        }
        $page = new Page($totalRows);
        $page->setUrl(U('User/index'));
        //var_dump($page);
        //die;
        
        $sql = "SELECT user_id, email, real_name, user_name, role, status, created "
                . "FROM bl_user "
                . "LIMIT " . $page->firstRow() . ', ' . $page->listRows();
        $result = FeelMySQLi::getInstance()->query($sql);

        $userList = array();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $userList[] = $row;
            }
        } else {
            echo FeelMySQLi::getInstance()->error;
            die;
        }
        
        
        $this->assign('page', $page->show());
        
        return $userList;
    }

    //put your code here
    public function index() {

        $this->assign('users', $this->_getUserTableData());
        $this->display();
    }

    public function addForm() {
        $this->display();
    }

    public function add() {
        $inputValidations = array(
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
        
        $inputVars = $this->validate($inputValidations,
                APP_TEMPLATE_PATH . '/User/addForm.template.php');
        if (!$inputVars) return;
        
        // mysql escape
        $mysqlVars = array();
        foreach ($inputVars as $varName => $varValue) {
            $mysqlVars['p_' . $varName] = $varValue;
        }
        extract($mysqlVars);

        // add user
        $db = new Db();
        $insertId = $db->into('user')->insert(
                array(
                    'user_name' => $p_nickname,
                    'email' => $p_email,
                    'real_name' => $p_realname,
                    'bio' => $p_bio,
                    'status' => $p_status,
                    'role' => $p_role,
                    'created' => time(),
                ))->go();
        
        // add user authn entry.
        $insertId = Authn::getInstance()->signup($p_email, $p_password, intval($insertId));

        $alert = new Alert();
        if ($insertId) {
            $alert->alert('success', "Adding user succeed!");
            $this->assign('alert', $alert->show());
            $this->assign('users', $this->_getUserTableData());
            $this->display(APP_TEMPLATE_PATH . '/User/index.template.php');
        } else {
            $alert->alert('danger', FeelMySQLi::getInstance()->error);
            $this->assign('alert', $alert->show());
            $this->assign($inputVars);
            $this->display(APP_TEMPLATE_PATH . '/User/addForm.template.php');
        }
    }

    public function editForm() {
        $p_userId = $_GET['user_id'];

        $db = new Db();
        $rows = $db->from('user')
                ->where(array('user_id' => $p_userId))
                ->select(array('user_id', 'email', 'real_name', 'user_name', 'bio', 'role', 'status'))
                ->go();

        if ($rows) {
            $user = $rows[0];
        } else {
            trigger_error('No such user.', E_USER_ERROR);
        }

        $this->assign('user_id', $p_userId);
        $this->assign('email', $user['email']);
        $this->assign('realname', $user['real_name']);
        $this->assign('nickname', $user['user_name']);
        $this->assign('bio', $user['bio']);
        $this->assign('role', $user['role']);
        $this->assign('status', $user['status']);
        $this->display();
    }

    public function edit() {
        $inputValidations = array(
            'email' => array(
                'validation' => FILTER_VALIDATE_EMAIL,
                'message' => 'Email is not valid.',
            ),
            'password' => FALSE,
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
            'user_id' => array(
                'validation' => FILTER_VALIDATE_INT,
                'message' => 'user id is invalid.'
            ),
        );
        
        $inputVars = $this->validate($inputValidations,
                APP_TEMPLATE_PATH . '/User/editForm.template.php');
        if (!$inputVars) return;

        // mysql escape
        $mysqlVars = array();
        foreach ($inputVars as $varName => $varValue) {
            $mysqlVars['p_' . $varName] = $varValue;
        }
        extract($mysqlVars);
        
        // change password
        !empty($p_password) && authn::getInstance()->changePassword(
                authn::getInstance()->profileId2AuthnName($p_user_id),
                $p_password);
        
        
        $db = new Db();
        $setFields = array(
                    'user_name' => $p_nickname,
                    'real_name' => $p_realname,
                    'bio' => $p_bio,
                    'status' => $p_status,
                    'role' => $p_role
                );
        $ret = $db->update('user')
                ->set($setFields)->where(array('user_id' => $p_user_id))->go();

        $alert = new Alert();
        if ($ret) {
            
            $alert->alert('success', 'User modification succeed.');
            $this->assign('alert', $alert->show());

            $this->assign('users', $this->_getUserTableData());
            $this->display(APP_TEMPLATE_PATH . '/User/index.template.php');
        } else {
            $alert->alert('danger', 'User modification fails. '
                    . FeelMySQLi::getInstance()->error);
            $this->assign('alert', $alert->show());

            $this->display(APP_TEMPLATE_PATH . '/User/editForm.template.php');
        }
    }

    public function delete() {

        $p_userId = intval($_GET['user_id']);

        authn::getInstance()->disable(authn::getInstance()->profileId2AuthnName($p_userId));
        
        $alert = new Alert();
        $db = new Db();
        if ($db->from('user')->where(array('user_id' => $p_userId))->delete()->go()) {
            $alert->alert('success', 'User deletion succeed.');
            $this->assign('alert', $alert->show());
        } else {
            $alert->alert('warning', 'User deletion failed.');
            $this->assign('alert', $alert->show());
        }

        $this->assign('users', $this->_getUserTableData());
        $this->display(APP_TEMPLATE_PATH . '/User/index.template.php');
    }

}
