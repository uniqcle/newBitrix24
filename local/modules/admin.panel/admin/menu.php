<?php

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
AddEventhandler('main', 'OnBuildGlobalMenu', 'OnBuildGlobalMenuHandlerMax');

function OnBuildGlobalMenuHandlerMax(&$arGlobalMenu, &$arModuleMenu)
{

    $menu = array(
        array(
            'sort' => 400,
            'text' => 'наш модуль',
            'items_id' => 'menu_ourModule',
            'items' => array(
                array(
                    'text' => Loc::getMessage('BEX_D7DULL_SUBMENU_TITLE'),
                    'url' => 'd7dull_index.php?param1=paramval',
                    'more_url' => array('d7dull_index.php?param1=paramval'),
                    'title' => Loc::getMessage('BEX_D7DULL_SUBMENU_TITLE'),
                ),
                array(
                    'text' => 'Настройки',
                    'url' => 'settings.php?lang=ru&mid=admin.panel&mid_menu=1',
                ),
                array(
                    'text' => 'Любая таблица',
                    'url' => 'perfmon_table.php?lang=ru&table_name=b_option',
                ),
                array(
                    'text' => 'Командная строка',
                    'url' => 'php_command_line.php?lang=ru',
                ),
            ),
        ),
    );

    return $menu;
}