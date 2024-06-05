<?php

use Bitrix\Main\EventManager;

Class changevents_module extends CModule
{
	public $MODULE_ID = 'changevents.module';
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $MODULE_NAME;
	public $MODULE_DESCRIPTION;

	public function __construct() {
		$this->MODULE_NAME = 'Пользовательский модуль с событиями';
		$this->MODULE_DESCRIPTION = 'Модуль для тестирования';
		$this->MODULE_VERSION = '1.0';
		$this->MODULE_VERSION_DATE = '2024-24-25';
	}

	public function DoInstall() {
		$this->InstallEvents();
		RegisterModule($this->MODULE_ID);
	}

	public function DoUninstall() {
		$this->UnInstallEvents();
		UnRegisterModule($this->MODULE_ID);
	}


	public function InstallEvents()
	{

		echo 'debug';

		EventManager::getInstance()->registerEventHandler(
		// идентификатор модуля-источника события
			'crm',
			// событие на которое мы подписываемся, OnSomeEvent для произвольной работы
			"OnAfterCrmDealUpdate",
			// идентификатор модуля, который подписывается
			$this->MODULE_ID,
			// класс выполняющий обработку (для callback-обработчика, если файловый - пустая строка)
			"\Changevents\Module\Events::class",
			// метод обработчика
			'onAfterUpdate'
		);
		return true;
	}
	public function UnInstallEvents()
	{
		EventManager::getInstance()->unRegisterEventHandler(
			'crm',
			"OnAfterCrmDealUpdate",
			$this->MODULE_ID,
			"\Changevents\Module\Events::class",
			'onAfterUpdate'
		);
		return true;
	}



}