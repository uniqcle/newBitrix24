<?php

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Text\HtmlFilter;

defined('ADMIN_MODULE_NAME') or define('ADMIN_MODULE_NAME', 'admin.panel');

if (!$USER->isAdmin()) {
    $APPLICATION->authForm('Nope');
}

$app = Application::getInstance();
$context = $app->getContext();
$request = $context->getRequest();

Loc::loadMessages($context->getServer()->getDocumentRoot() . "/bitrix/modules/main/options.php");
Loc::loadMessages(__FILE__);

$tabControl = new CAdminTabControl(
    "tabControl",
    array(
        array(
            "DIV" => "edit1",
            "TAB" => Loc::getMessage("MAIN_TAB_SET"),
            "TITLE" => Loc::getMessage("MAIN_TAB_TITLE_SET"),
        ),
    )
);

if ((!empty($save) || !empty($restore)) && $request->isPost() && check_bitrix_sessid()) {
    if (!empty($restore)) {
        Option::delete(ADMIN_MODULE_NAME);
        CAdminMessage::showMessage(
            array(
                "MESSAGE" => Loc::getMessage("REFERENCES_OPTIONS_RESTORED"),
                "TYPE" => "OK",
            )
        );
    } elseif ($request->getPost('max_image_size') && ($request->getPost('max_image_size') > 0) && ($request->getPost('max_image_size') < 100000)) {
        Option::set(
            ADMIN_MODULE_NAME,
            "max_image_size",
            $request->getPost('max_image_size')
        );
        /* данные хранятся в b_option */
        /* добавляем новое свойство */
        Option::set(
            ADMIN_MODULE_NAME,
            "IB_ID",
            $request->getPost('IB_ID')
        );
        /* данные хранятся в b_option */
        Option::set(
            ADMIN_MODULE_NAME,
            "ACCOUNT_NUMBER",
            $request->getPost('ACCOUNT_NUMBER')
        );
        /* добавляем новое свойство */
        /* данные хранятся в b_option */
        Option::set(
            ADMIN_MODULE_NAME,
            "BIK",
            $request->getPost('BIK')
        );
        /* добавляем новое свойство */

        CAdminMessage::showMessage(
            array(
                "MESSAGE" => Loc::getMessage("REFERENCES_OPTIONS_SAVED"),
                "TYPE" => "OK",
            )
        );
    } else {
        CAdminMessage::showMessage(Loc::getMessage("REFERENCES_INVALID_VALUE"));
    }
}

$tabControl->begin();
?>

<form method="post"
    action="<?= sprintf('%s?mid=%s&lang=%s', $request->getRequestedPage(), urlencode($mid), LANGUAGE_ID) ?>">
    <?php
    echo bitrix_sessid_post();
    $tabControl->beginNextTab();
    ?>
    <tr>
        <td width="40%">
            <label for="max_image_size"><?= Loc::getMessage("REFERENCES_MAX_IMAGE_SIZE") ?>:</label>
        <td width="60%">
            <input type="text" size="50" maxlength="5" name="max_image_size"
                value="<?= HtmlFilter::encode(Option::get(ADMIN_MODULE_NAME, "max_image_size", 2)); ?>" />
        </td>
    </tr>
    /* добавляем новое свойство */
    <tr>
        <td width="40%">
            <label for="ACCOUNT_NUMBER">Номер счета:</label>
        <td width="60%">
            <input type="text" size="50" maxlength="5" name="ACCOUNT_NUMBER"
                value="<?= HtmlFilter::encode(Option::get(ADMIN_MODULE_NAME, "ACCOUNT_NUMBER", 1)); ?>" />
        </td>
    </tr>
    /* данные хранятся в b_option */
    /* добавляем новое свойство */
    <tr>
        <td width="40%">
            <label for="BIK">БИК:</label>
        <td width="60%">
            <input type="text" size="50" maxlength="5" name="BIK"
                   value="<?= HtmlFilter::encode(Option::get(ADMIN_MODULE_NAME, "BIK", 3)); ?>" />
        </td>
    </tr>
    /* данные хранятся в b_option */
    /* добавляем новое свойство */
    <tr>
        <td width="40%">
            <label for="IB_ID">ID инфоблока:</label>
        <td width="60%">
            <input type="text" size="50" maxlength="5" name="IB_ID"
                   value="<?= HtmlFilter::encode(Option::get(ADMIN_MODULE_NAME, "IB_ID", 17)); ?>" />
        </td>
    </tr>
    /* данные хранятся в b_option */
    /* к примеру модуль интеграции с конутр эльба
    1. Номер счета с которого будут выставлятся счета
    2.Бик банка с которого будут выставлятся счета
    3.Логин
    4.Пароль
    5.Свойство счета которое будет хранить из Эльбы
    */
    <?php
    $tabControl->buttons();
    ?>
    <input type="submit" name="save" value="<?= Loc::getMessage("MAIN_SAVE") ?>"
        title="<?= Loc::getMessage("MAIN_OPT_SAVE_TITLE") ?>" class="adm-btn-save" />
    <input type="submit" name="restore" title="<?= Loc::getMessage("MAIN_HINT_RESTORE_DEFAULTS") ?>"
        onclick="return confirm('<?= AddSlashes(GetMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING")) ?>')"
        value="<?= Loc::getMessage("MAIN_RESTORE_DEFAULTS") ?>" />
    <?php
    $tabControl->end();
    ?>
</form>