<?php
$MySQLiClass = FEEL_LIB_CORE_PATH . '/FeelMySQLi.class.php';
//var_dump(file_get_contents($MySQLiClass));
require_once $MySQLiClass;

class DbAction
{
    public static $db_prefix = 'bl_';
    
    public function gen()
    {
        // create post table
        $sql = 'CREATE TABLE IF NOT EXISTS ' . self::$db_prefix . 'post ' .
                '(post_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, ' .
                ' title varchar(255) DEFAULT \'\' NOT NULL, ' 
                . 'content TEXT,'
                . 'created DATETIME)';
        //print_r($sql);
        /*
        if(FeelMySQLi::getInstance()->query('create table test(nu int);'))
        {
            echo "S";
        }
        else {
            echo FeelMySQLi::getInstance()->error;
        }*/
        
        // create user table
        $sql = 'CREATE TABLE IF NOT EXISTS ' . self::$db_prefix . 'user '
                . '(user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, '
                . 'user_name VARCHAR(50), '
                . 'user_password VARCHAR(50), '
                . 'email VARCHAR(50), '
                . 'real_name VARCHAR(50), '
                . 'bio TEXT, '
                . 'status ENUM(\'active\', \'inactive\'), '
                . 'role ENUM(\'administrator\', \'editor\', \'user\'), '
                . 'created INT'
                . ');';
        if(FeelMySQLi::getInstance()->query($sql))
        {
            echo "Creating user table succeed.<br/>";
        }
        else
        {
            echo "Creating user table fails.<br/>";
            echo FeelMySQLi::getInstance()->error;
            die;
        }
    }
}

