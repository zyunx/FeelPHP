<?php
/* FeelMySQLi.class.php
 *   A singleton for accessing mysql database using mysqli.
 *
 * Copyright [2014] Cloud Zhang(cloud2han9@163.com)
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *		  http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
require_once dirname(__FILE__) . '/Singleton.class.php';

class FeelMySQLi extends Singleton
{
	private $mysqli;

	// config
	private $db_host = 'localhost';
	private $db_user = 'root';
	private $db_password = '123456';
	private $db_name = 'feelblog';
	private $db_charset = "utf8";

	protected function __construct()
	{       
                $this->mysqli = new mysqli($this->db_host, $this->db_user,
		                    $this->db_password, $this->db_name);
                if ($this->mysqli)
                {
                    //echo 'mysql success';
                    $this->mysqli->set_charset($this->db_charset);
                    //var_dump(get_class_methods($this->mysqli));
                }
                else 
                {
                    echo "mysqli fails";
                }
	}

	public function __destruct()
	{
		$this->mysqli->close();
	}

        public function __call($name, $args)
        {
            return call_user_func_array(array($this->mysqli, $name), $args);
            //echo "Call method: " . $name . '(' . implode(',', $args) . ')';
        }
        public function __set($name, $value)
        {
            $this->mysqli->$name = $value;
        }
        public function __get($name)
        {
            return $this->mysqli->$name;
        }
}

