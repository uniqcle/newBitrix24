<?php

// 1 вариант
//Bitrix\Main\EventManager::getInstance()->addEventHandler(
//    'crm',
//    'onEntityDetailsTabsInitialized',
//    static function(\Bitrix\Main\Event $event) {
//        $tabs = $event->getParameter('tabs');
//        $tabs[] = [
//            'id' => 'custom',
//            'name' => 'Кастомная',
//            'html' => '<b>Содержимое новой вкладки. ID Сделки: ' .'</b>'
//        ];
//        return new \Bitrix\Main\EventResult(\Bitrix\Main\EventResult::SUCCESS, [
//            'tabs' => $tabs,
//        ]);
//    }
//);


// 2 вариант
//Bitrix\Main\EventManager::getInstance()->addEventHandler(
//    'crm',
//    'onEntityDetailsTabsInitialized',
//    'myOnEntityDetailsTabsInitialized'
//);


//function myOnEntityDetailsTabsInitialized($event)
//{
//    $tabs = $event->getParameter('tabs');
//    // ID текущего элемента СРМ
//    $entityID = $event->getParameter('entityID');
//    // ID типа сущности: Сделка, Компания, Контакт и т.д.
//    $entityTypeID = $event->getParameter('entityTypeID');
//
//    // Проверяем, что открыта карточка именно Сделки
//    if ($entityTypeID == \CCrmOwnerType::Deal) {
//        // Добавляем свою вкладку в массив вкладок
//        $tabs[] = [
//            'id' => 'newTab',
//            'name' => 'Новая вкладка',
//            // Выведим в содержимое новой вкладки ID текущей сделки
//            'html' => '<b>Содержимое новой вкладки. ID Сделки: ' . $entityID . '</b>'
//        ];
//    }
//
//    // Возвращаем модифицированный массив вкладок
//    return new \Bitrix\Main\EventResult(\Bitrix\Main\EventResult::SUCCESS, [
//        'tabs' => $tabs,
//    ]);
//}



// 3 вариант
Bitrix\Main\EventManager::getInstance()->addEventHandler(
	'crm',
	'onEntityDetailsTabsInitialized',
	'myOnEntityDetailsTabsInitialized'
);

function myOnEntityDetailsTabsInitialized($event) {
    $tabs = $event->getParameter('tabs');
    // ID текущего элемента СРМ
    $entityID = $event->getParameter('entityID');
    // ID типа сущности: Сделка, Компания, Контакт и т.д.
    $entityTypeID = $event->getParameter('entityTypeID');

    // Проверяем, что открыта карточка именно Сделки
    if($entityTypeID == \CCrmOwnerType::Deal) {
        // Добавляем свою вкладку в массив вкладок
        $tabs[] = [
            'id' => 'newTab',
            'name' => 'Новая вкладка 2',
            'loader' => [
                // Указываем URL адрес обработчика
                'serviceUrl' => '/ajax/ajax.php',
                'componentData' => [
                    'template' => '',
                    // Передаем массив необходимых параметров
                    'params' => [
                        'ENTITY_ID' => $entityID,
                        'ENTITY_TYPE' => $entityTypeID,
                        'TAB_ID' => 'newTab'
                    ]
                ]
            ]
        ];
    }

    // Возвращаем модифицированный массив вкладок
    return new \Bitrix\Main\EventResult(\Bitrix\Main\EventResult::SUCCESS, [
        'tabs' => $tabs,
    ]);
}