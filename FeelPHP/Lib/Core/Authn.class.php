<?php

class Authn extends Singleton {

    private $tokenCookieKey = 'authn_token';
    private $authnNameCookieKey = 'cookie_authn_id';
    private $authnNameSessionKey = 'authn_id';

    public function signin($authnName, $authnPassword, $rememberMe = FALSE) {
        $authnName = FeelMySQLi::getInstance()->escape_string($authnName);
        $authnPassword = FeelMySQLi::getInstance()->escape_string($authnPassword);

        $db = new Db();
        $rows = $db->from('authn')
                ->where(array(
                    'authn_name' => $authnName,
                    'authn_password' => $authnPassword,
                    'status' => 'active',
                ))
                ->select()
                ->go();

        if ($rows) {
            $row = $rows[0];
            $row['last_authn'] = $row['this_authn'];
            $row['this_authn'] = time();
            $_SESSION[$this->authnNameSessionKey] = $row['authn_id'];

            // if remember-me
            if ($rememberMe) {
                $row['token'] = $this->_generateToken(40);
                fp_setcookie($this->tokenCookieKey, $row['token'], time() + 30 * 24 * 60 * 60);
                fp_setcookie($this->authnNameCookieKey, $row['authn_id'], time() + 30 * 24 * 60 * 60);

                if ($db->update('authn')
                                ->set(array(
                                    'last_authn' => $row['last_authn'],
                                    'this_authn' => $row['this_authn'],
                                    'token' => $row['token'],
                                ))
                                ->where(array('authn_name' => $row['authn_name']))
                                ->go()) {

                    echo "Remembered Me<br/>";
                } else {
                    echo FeelMySQLi::getInstance()->error;
                }
            }

            return $row;
        } else {
            return FALSE;
        }
    }

    public function isSignin() {
        //var_dump($_COOKIE);
        if (isset($_SESSION[$this->authnNameSessionKey])) {
            // Still in current session
            return TRUE;
        } else if (isset($_COOKIE[$this->tokenCookieKey]) &&
                isset($_COOKIE[$this->authnNameCookieKey])) {
            //var_dump($_COOKIE);
            // Outside session, but in remember-me duration.
            $token = $_COOKIE[$this->tokenCookieKey];
            $authnName = $_COOKIE[$this->authnNameCookieKey];

            $db = new Db();
            if (count($db->from('authn')
                                    ->where(array(
                                        'authn_name' => $authnName, 
                                        'token' => $token,
                                        'status' => 'active'
                                        ))
                                    ->select('*')->go()) > 0) {

                return $db->update('authn')
                                ->set(array(
                                    'token' => $this->_generateToken(40),
                                    'last_authn' => '[this_authn]',
                                    'this_authn' => time()))
                                ->where(array(
                                    'token' => $token,
                                    'authn_id' => $authnName,
                                    'status' => 'active',
                                ))->go();
            }
        } else {
            return FALSE;
        }
    }

    public function logout() {
        unset($_SESSION[$this->authnNameSessionKey]);
        setcookie($this->tokenCookieKey, '', 0);
        setcookie($this->authnNameCookieKey, '', 0);
    }

    public function signup($authnName, $authnPassword, $profileId) {
        $db = new Db();
        return $db->into('authn')
            ->insert(array(
                    'authn_name' => $authnName,
                    'authn_password' => $authnPassword,
                    'profile_id' => $profileId,
            ))
            ->go();
    }

    public function changePassword($authnName, $authnPassword) {
        $db = new Db();
        return $db->update('authn')
                        ->where(array('authn_name' => $authnName))
                        ->set(array('authn_password' => $authnPassword))
                        ->go();
    }

    public function disable($authnName) {
        $db = new Db();
        return $db->update('authn')
                        ->where(array('authn_name' => $authnName))
                        ->set(array('status' => 'inactive'))
                        ->go();
        
    }
    
    public function profileId2AuthnName($profileId)
    {
        static $_profileId2AuthnIdList = array();
        
        if (!isset($_profileId2AuthnIdList[$profileId])) {
            $db = new Db();
            $rows = $db->from('authn')
                ->select('authn_name')
                ->where(array('profile_id' => $profileId))
                ->go();
            
            if ($rows) {
                $_profileId2AuthnIdList[$profileId] = $rows[0]['authn_name'];
            }
        }
        
        return $_profileId2AuthnIdList[$profileId];
    }

    private function _generateToken($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < $length; $i++) {
            $randstring .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randstring;
    }

}
