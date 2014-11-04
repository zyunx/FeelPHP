<?php
/* Singleton.class.php
 *   A base class of all that implement singleton design pattern.
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
abstract class Singleton
{
	protected function __construct() {
	}

	final public static function getInstance()
	{
		static $allInstance = array();

		$calledClassName = get_called_class();

		if (!isset($allInstance[$calledClassName])) {
			$allInstance[$calledClassName] = new $calledClassName();
		}

		return $allInstance[$calledClassName];
	}

	final private function __clone() {}
}