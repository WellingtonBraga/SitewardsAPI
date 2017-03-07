<?php

namespace App\Helpers;

Trait TraitConfig{

	public $config;

	/**
	 * This method is responsible to set the configuration settings.
	 */
	public function setUpConfiguration(){
		$mode =  file_get_contents(dirname(__FILE__). "/../core/config/mode.php");
		$this->config = include(dirname(__FILE__) . "/../core/config/$mode.php");

        $shouldInitializeDatabase = file_get_contents(dirname(__FILE__). "/../core/config/initializeDatabase.php");
        $this->config["initialize"] = ($shouldInitializeDatabase == "true") ? true : false;
	}

}