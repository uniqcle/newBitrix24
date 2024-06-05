<?php
Class simplefive_module extends CModule
{
    public $MODULE_ID = 'simplefive.module';
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;

    public function __construct() {
        $this->MODULE_NAME = 'Пользовательский модуль';
        $this->MODULE_DESCRIPTION = 'Модуль для тестирования';
        $this->MODULE_VERSION = '1.0';
        $this->MODULE_VERSION_DATE = '2024-24-25';
    }

    public function DoInstall() {
        CopyDirFiles(
            __DIR__ . "/components",
            $_SERVER["DOCUMENT_ROOT"] . "/local/components",
            true, // перезаписывает файлы
            true  // копирует рекурсивно
        );
        RegisterModule($this->MODULE_ID);
    }

    public function DoUninstall() {

            // удаляет папка из указанной директории, функция работает рекурсивно
            DeleteDirFilesEx(
                "/local/components/glavnyj.slajder"
            );

        UnRegisterModule($this->MODULE_ID);
    }
}