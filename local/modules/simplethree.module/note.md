# [Главный модуль:EventManager](https://dev.1c-bitrix.ru/api_d7/bitrix/main/EventManager/index.php)
**EventManager** - класс кратко- и долгосрочной регистрации обработчиков событий. Класс реализует паттерн **Singleton** (Одиночка), обращаться к нему нужно через *getInstance()*.

В обработчики, зарегистрированные с помощью *\\Bitrix\\Main\\EventManager::AddEventHandler*, в качестве аргумента будет передан объект события (*Bitrix\\Main\\Event*). Если хотите, чтобы передавались старые аргументы, нужно использовать *\\Bitrix\\Main\\EventManager::addEventHandlerCompatible*. Аналогично с *\\Bitrix\\Main\\EventManager::registerEventHandler* и *\\Bitrix\\Main\\EventManager::registerEventHandlerCompatible*.

Аналогами класса в старом ядре являются функции:  
[RegisterModuleDependences](http://dev.1c-bitrix.ru/api_help/main/functions/module/registermoduledependences.php),  
[UnRegisterModuleDependences](http://dev.1c-bitrix.ru/api_help/main/functions/module/unregistermoduledependences.php),  
[AddEventHandler](http://dev.1c-bitrix.ru/api_help/main/functions/module/addeventhandler.php),  
[RemoveEventHandler](http://dev.1c-bitrix.ru/api_help/main/functions/module/removeeventhandler.php),  
[GetModuleEvents](http://dev.1c-bitrix.ru/api_help/main/functions/module/getmoduleevents.php).

#### Примеры ####

```
//версия 1
$eventManager = \Bitrix\Main\EventManager::getInstance();
$eventManager->registerEventHandlerCompatible("module","event","module2","class","function");
```

```
//версия 2 для событий в DataManager например
$eventManager = \Bitrix\Main\EventManager::getInstance();
$eventManager->registerEventHandler("module","event","module2","class","function");
```

Свои обработчики в своих модулях

```
$arMacros["PRODUCTS"]  = "";  
$basketId = "10";
```

```
$event = new \Bitrix\Main\Event("mymodule", "OnMacrosProductCreate",array($basketId));
	$event->send();
	if ($event->getResults()){
		foreach($event->getResults() as $evenResult){
			if($evenResult->getResultType() == \Bitrix\Main\EventResult::SUCCESS){
			$arMacros["PRODUCTS"] = $evenResult->getParameters();
			}
		}
}
```

```
$eventManager = \Bitrix\Main\EventManager::getInstance();
$eventManager->addEventHandler("mymodule", "OnMacrosProductCreate", "OnMacrosProductCreate");

function OnMacrosProductCreate(\Bitrix\Main\Event $event){
	$arParam = $event->getParameters();
	$basketId = $arParam[0];
	$result = new \Bitrix\Main\EventResult(1,$basketId);
	return $result;
}
```

```
use Bitrix\Main\EventManager;

$handler = EventManager::getInstance()->addEventHandler(
	"main",
	"OnUserLoginExternal",
	array(
		"Intervolga\\Test\\EventHandlers\\Main",
		"onUserLoginExternal"
	)
);
EventManager::getInstance()->removeEventHandler(
	"main",
	"OnUserLoginExternal",
	$handler
);
EventManager::getInstance()->registerEventHandler(
	"main",
	"OnProlog",
	$this->MODULE_ID,
	"Intervolga\\Test\\EventHandlers",
	"onProlog"
);
EventManager::getInstance()->unRegisterEventHandler(
	"main",
	"OnProlog",
	$this->MODULE_ID,
	"Intervolga\\Test\\EventHandlers",
	"onProlog"
);
$handlers = EventManager::getInstance()->findEventHandlers("main", "OnProlog");
```

```
// метод для создания обработчика событий
    function InstallEvents()
    {
        // для произвольной работы
        EventManager::getInstance()->registerEventHandler(
            // идентификатор модуля-источника события
            $this->MODULE_ID,
            // событие на которое мы подписываемся, OnSomeEvent для произвольной работы
            "OnSomeEvent",
            // идентификатор модуля, который подписывается
            $this->MODULE_ID,
            // класс выполняющий обработку (для callback-обработчика, если файловый - пустая строка)
            "\Hmarketing\d7\Main",
            // метод класса выполняющий обработку (для callback-обработчика, если файловый - пустая строка)
            'get'
        );
        // для работы с ORM, есть три типа событий: onBefore<Action> - перед вызовом запроса (можно изменить входные параметры), после следуют валидаторы. on<Action> - уже нельзя изменить входные параметры, после выполняется SQL-запрос. onAfter<Action> - после выполнения операции, операция уже совершена
        // три события <Action> итого 9 событий: Add, Update, Delete
        EventManager::getInstance()->registerEventHandler(
            // идентификатор модуля, для которого регистрируется событие
            $this->MODULE_ID,
            // тип события, класс называется DataTable, но должно передаваться по имени файла, то есть просто Data
            "\Hmarketing\d7\Data::OnBeforeUpdate",
            // идентификатор модуля к которому относится регистрируемый обработчик, из какого модуля берется класс, нужно если необходимо связать 2 модуля, если используем один, то дублируем поле с первым
            $this->MODULE_ID,
            // класс обработчика
            "\Hmarketing\d7\Events",
            // метод обработчика
            'eventHandler'
        );
        // для успешного завершения, метод должен вернуть true
        return true;
    }
    // метод для удаления обработчика событий
    function UnInstallEvents()
    {
        // удаление событий, аналогично установке
        EventManager::getInstance()->unRegisterEventHandler(
            $this->MODULE_ID,
            "OnSomeEvent",
            $this->MODULE_ID,
            "\Hmarketing\d7\Main",
            'get'
        );
        // удаление событий, аналогично установке
        EventManager::getInstance()->unRegisterEventHandler(
            $this->MODULE_ID,
            "\Hmarketing\d7\Data::OnBeforeUpdate",
            $this->MODULE_ID,
            "\Hmarketing\d7\Events",
            'eventHandler'
        );
        // для успешного завершения, метод должен вернуть true
        return true;
    }
```