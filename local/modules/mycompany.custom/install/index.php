<?php

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bex\D7dull\ExampleTable; //класс хранится в lib

Loc::loadMessages(__FILE__);

class mycompany_custom extends CModule
{
    public function __construct()
    {
        $arModuleVersion = array();

        include __DIR__ . '/version.php';

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_ID = 'mycompany.custom';
        $this->MODULE_NAME = Loc::getMessage('MYCOMPANY_CUSTOM_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('MYCOMPANY_CUSTOM_MODULE_DESCRIPTION');
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = Loc::getMessage('MYCOMPANY_CUSTOM_MODULE_NAME');
        $this->PARTNER_URI = 'http://bitrix.expert';
    }

    public function doInstall()
    {
//        CopyDirFiles(__DIR__ . '/admin/', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin');
        ModuleManager::registerModule($this->MODULE_ID);
        $this->installDB();
    }

    public function doUninstall()
    {
//        DeleteDirFiles(__DIR__ . '/admin/', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin');
        $this->uninstallDB();
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    public function installDB()
    {
        if (Loader::includeModule($this->MODULE_ID)) {
//            ExampleTable::getEntity()->createDbTable();//класс хранится в lib
        }
    }

    public function uninstallDB()
    {
        if (Loader::includeModule($this->MODULE_ID)) {
//            $connection = Application::getInstance()->getConnection();
//            $connection->dropTable(ExampleTable::getTableName());//класс хранится в lib
        }
    }
}
