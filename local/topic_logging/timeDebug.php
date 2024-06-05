<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Новая страница");
?>

<?php
use Bitrix\Main\Diag\Debug;

Debug::startTimeLabel('SomeLabel');
$sum = 0;
for($i = 0; $i < 1000; $i++){
    $sum += $i;
}
echo $sum;

Debug::endTimeLabel('SomeLabel');

Debug::dump( Debug::getTimeLabels());


?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>