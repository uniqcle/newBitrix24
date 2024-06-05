<?php

class simple_module extends CModule{
	public $MODULE_ID = 'simple.module';
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $MODULE_NAME;
	public $MODULE_DESCRIPTION;

	public function __construct(){
		$this->MODULE_NAME = 'Простой модуль';
		$this->MODULE_DESCRIPTION = 'Модуль для тестирования';
		$this->MODULE_VERSION = '1.0';
		$this->MODULE_VERSION_DATE='2024-24-05';
	}

	public function DoInstall(){
		RegisterModule($this->MODULE_ID);
	}

	public function DoUninstall(){
		UnRegisterModule($this->MODULE_ID);
	}
}