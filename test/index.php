<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Новый раздел");
?>
<?php
//if(\Bitrix\Main\Loader::includeModule('simpletwo.module')){
//    \Simpletwo\Module\TestEcho::testTwo();
//
//    $test = new \Simpletwo\Module\TestEcho();
//    $test->test();
//}



use \Uniqcle\Module\SalaryTable as Salary;

if(\Bitrix\Main\Loader::includeModule('uniqcle.module')){

    $data = Salary::getList([
        'select' => ['ID', 'name'],
        'order' => ['ID' => 'ASC'],
        //'limit' => $limit,
        //'offset' =>$offset
    ]);

    while ($item = $data->fetch()) {
        Bitrix\Main\Diag\Debug::dump($item);
       // $list[] = array('data' => $item);
    }

    //Bitrix\Main\Diag\Debug::dump($list);

}


?>



<?$APPLICATION->IncludeComponent(
    "uniqcle:table.views",
    "list",
    array(
        "NUM_PAGE" => "3",
        "COMPONENT_TEMPLATE" => "list",
        "SHOW_CHECKBOXES" => "N"
    ),
    false
);
?>



<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>