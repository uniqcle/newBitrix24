<?php

namespace MyCompany\Custom\EventHandlers;

class Main
{
    static function redirectFromTestPage(): void
    {
        global $USER, $APPLICATION;
        $curPage = $APPLICATION->GetCurPage();
        if(str_ends_with($curPage, 'test.php'))
        {
            LocalRedirect('/');
        }
    }
static function setIsDevServerConstant(): void
{
    $isDevServ = \Bitrix\Main\Config\Option::get('main', 'update_devsrv');
    if($isDevServ == 'Y')
    {
        define('IS_DEV_SERV', true);
    }
}

}