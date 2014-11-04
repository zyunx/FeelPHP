<?php
/* Router.class.php
 *   A class for routing the url to specified action class.
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

/**
 * Description of Router
 *
 * @author cloud
 */
require_once dirname(__FILE__) . '/Singleton.class.php';

class Router extends Singleton {

    public function dispatch() {

//echo "Hello\n";
        //$route = $_REQUEST['s'];
        $route = $_SERVER['PATH_INFO'];
        
        $ra = explode('/', $route);
//array_shift($ra);
//var_dump($ra);
        define('ACTION_CLASS', $ra[1]);
        define('ACTION_METHOD', $ra[2]);

        $actionFilePath = APP_ACTION_PATH . '/' . ACTION_CLASS . 'Action.class.php';
//var_dump($actionFilePath);
        require_once $actionFilePath;

        $actionClass = ACTION_CLASS . 'Action';
//var_dump($actionClass);
        $action_obj = new $actionClass();
//var_dump($action_obj);
        $actionMethod = ACTION_METHOD;
        $action_obj->$actionMethod();
    }

}
