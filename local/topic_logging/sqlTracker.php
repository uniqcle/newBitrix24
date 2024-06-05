<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Новая страница");
?>
<?php
use  Bitrix\Main\Diag\Debug;

$connection = Bitrix\Main\Application::getConnection();
$tracker = $connection->startTracker();

$query1 = Bitrix\Iblock\ElementTable::getList([
        'select' => array('ID', 'NAME'),
        'filter' => array('IBLOCK_ID' => 6)
]);

$connection->stopTracker();

Debug::dumpToFile($query1->getTrackerQuery()->getSql(), "sql_dump", '/local/logs/sql_dump.log');
Debug::dumpToFile($query1->getTrackerQuery()->getTime(), "sql_dump", '/local/logs/sql_dump.log');

//или так. Если несколько запросов нужно отследить
foreach ($tracker->getQueries() as $query) {
	Debug::dumpToFile($query->getSql(), "sql_dump", '/local/logs/sql_dump.log'); // текст запроса
	Debug::dumpToFile($query->getTrace(), "sql_dump", '/local/logs/sql_dump.log'); // стек вызовов функций
	Debug::dumpToFile($query->getTime(), "sql_dump", '/local/logs/sql_dump.log'); // время выполнения запроса
}

?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>