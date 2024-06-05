<?php
/**
 * Bitrix vars
 *
 * @var CBitrixComponent $this
 * @var array            $arParams
 * @var array            $arResult
 * @var string           $componentPath
 * @var string           $templateName
 * @var string           $templateFile
 * @var array           $templateData
 *
 * @var string           $templateFolder
 * @var string           $componentPath
 * @var string           $component
 *
 * @var CDatabase        $DB
 * @var CUser            $USER
 * @var CMain            $APPLICATION
 */

//echo '<pre>';
////var_dump($arResult['LISTS']);
//var_dump($arParams);
//echo '</pre>';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$spreadSheet = new Spreadsheet();
$writer = new Xlsx($spreadSheet);
$activeSheet = $spreadSheet->getActiveSheet();

$column = 'A';
foreach ($arResult['COLUMNS'] as $value) {
	$activeSheet->setCellValue($column.'1', $value['name']);
	$column++;
}

$row = 2;
foreach ($arResult['LISTS'] as $value) {
	$column = 'A';
	foreach ($value['data'] as $itemText) {
		$activeSheet->setCellValue($column.$row, $itemText);
		$column++;
	}
	$row++;
}

// Сброс буфера вывода веб-страницы, чтобы начать вывод файла без какого-либо другого контента
$APPLICATION->RestartBuffer();

// Устанавливаем заголовок Content-Type для указания типа файла (Excel) для отправки веб-странице
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

// Сохраняем файл Excel, используя объект $writer, и отправляем его напрямую в выходной поток PHP
$writer->save('php://output');

// Завершаем выполнение скрипта, чтобы избежать вывода другого контента вместе с файлом Excel
exit();


