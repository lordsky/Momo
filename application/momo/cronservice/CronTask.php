<?php

/** 
 * Copyright 2013, ETH Z�rich
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License. 
 */

// ------------------------------------------------------------------------

namespace momo\cronservice;

use momo\core\exceptions\MomoException;

/**
 * CronTask
 * 
 * All cron tasks must extend this class.
 * 
 * @author  Francesco Krattiger
 * @package momo.application.services.cronservice
 */
abstract class CronTask {
	
	private $ci = null;				// the CI instance
		
	public function __construct() {
		$this->ci = & get_instance();
	}
	
	public function getCI() {
		return $this->ci;
	}
	
	public function getCtx() {
		return \momo\core\application\ApplicationContext::getInstance();
	}
	
	/**
	 * Runs the cron task
	 * 
	 * @param CronService $cronService	- reference to the calling service
	 */
	public abstract function run($cronService);

}