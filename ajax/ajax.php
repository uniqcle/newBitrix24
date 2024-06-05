<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

//echo 'Hello world!1111111111111111111';
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
