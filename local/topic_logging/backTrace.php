<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Новая страница");
?>

<?php
// в init.php Отслеживает каким файлы подключаются
use Bitrix\Main\Diag\Helper;
use Bitrix\Main\Diag\Debug;

$trace = Helper::getBackTrace();
Debug::dump($trace);


?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>