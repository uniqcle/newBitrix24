<?php
function is404Page(): bool
{
    global $APPLICATION;
    $curPage = $APPLICATION->GetCurPage();
    return $curPage == '/404.php';
}


