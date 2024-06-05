<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Новая страница");
?>
<?php
use Bitrix\Main\Diag\Debug;

define('LOG_FILENAME', 'local/log/debug'. date("dmY"). '.log');

$arResult = [
        'URL' => 'ya.ru'
];
$debuggingInfo = date('d-m-Y'). ' отладочная информация';

// 1. в лог
Debug::writeToFile($arResult, $debuggingInfo, LOG_FILENAME);

// 2. по-умолчанию в файл /__bx_log.log
Bitrix\Main\Diag\Debug::dumpToFile($arResult, $debuggingInfo, LOG_FILENAME);

//3. По умолч. в const LOG_FILENAME
// https://dev.1c-bitrix.ru/api_help/main/functions/debug/addmessage2log.php
AddMessage2Log($arResult);

//4. На экран
Bitrix\Main\Diag\Debug::dump($arResult, $debuggingInfo);

?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>