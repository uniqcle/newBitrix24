<?php
//подключаем основные классы для работы с модулем
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Entity\Base;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\EventManager;

use Uniqcle\Module\SalaryTable;

class uniqcle_module extends CModule{
	public $MODULE_ID = 'uniqcle.module';
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $MODULE_NAME;
	public $MODULE_DESCRIPTION;

	public function __construct(){
		$this->MODULE_NAME = 'Добавляет вкладку в CRM';
		$this->MODULE_DESCRIPTION = 'Добавляет вкладку в CRM и выведет данные в грид из произвольной таблицы в БД';
		$this->MODULE_VERSION = '1.0';
		$this->MODULE_VERSION_DATE='2024-06-03';
	}

	public function DoInstall(){
		RegisterModule($this->MODULE_ID);
		$this->InstallEvents();
		$this->installDB();
		$this->copyFiles();
	}

	public function DoUninstall(){
		$this->uninstallDB();
		$this->deleteFiles();
		$this->UnInstallEvents();
		UnRegisterModule($this->MODULE_ID);
	}


	//вызываем метод создания таблицы из выше подключенного класса
	public function installDB()
	{
		if (Loader::includeModule($this->MODULE_ID)) {
			SalaryTable::getEntity()->createDbTable();

		}
	}
	//вызываем метод удаления таблицы, если она существует
	public function uninstallDB()
	{
		if (Loader::includeModule($this->MODULE_ID)) {
			if (Application::getConnection()->isTableExists(Base::getInstance('\Uniqcle\Module\SalaryTable')->getDBTableName())) {
				$connection = Application::getInstance()->getConnection();
				$connection->dropTable(SalaryTable::getTableName());
			}
		}
	}


	public function copyFiles(){
		CopyDirFiles(
			__DIR__ . "/components",
			$_SERVER["DOCUMENT_ROOT"] . "/local/components",
			true, // перезаписывает файлы
			true  // копирует рекурсивно
		);

		CopyDirFiles(__DIR__ . '/admin/', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin');
	}

	public function deleteFiles(){
		DeleteDirFilesEx(
			"/local/components/uniqcle"
		);
		DeleteDirFiles(__DIR__ . '/admin/', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin');
	}

}