<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */


// global $INTRANET_TOOLBAR;
// use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Context,
    Bitrix\Main\Application,
    Bitrix\Main\Type\DateTime,
    Bitrix\Main\Loader,
    Bitrix\Main\Localization\Loc,
    Bitrix\Main\Engine\Contract\Controllerable,
    Bitrix\Iblock;
use Bitrix\Main\Engine\Contract;
use \Uniqcle\Module\SalaryTable as Salary;



class TableViewsComponent extends \CBitrixComponent
{

    protected $request;

    public function onPrepareComponentParams($arParams) {
        // тут пишем логику обработки параметров, дополнение к параметрам по умолчанию
        return $arParams;
    }

    private function checkModules()
    {
        if(!Loader::includeModule('iblock') || !Loader::includeModule('uniqcle.module')){
            throw new \Exception("Не загружены модули необходимые для работы компонента");
        }
        return true;
    }


    private function getList($page = 1, $limit = 1)
    {

        $offset = $limit * ($page-1);
        $list = [];
        $data = Salary::getList([
            'select' => ['ID','name', 'age', 'summa', 'given'],
            'order' => ['ID' => 'ASC'],
            //'limit' => $limit,
            'offset' =>$offset
        ]);

        while ($item = $data->fetch()) {
            $list[] = array('data' => $item);
        }

        return $list;
    }

    private function getColumn()
    {
        $fieldMap = Salary::getMap();
        $columns = [];
        foreach ($fieldMap as $key => $field) {
            $columns[] = array(
                'id' => $field->getName(),
                'name' => $field->getTitle(),
//                'age' => $field->getAge(),
//                'summa' => $field->getSumma(),
//                'given' => $field -> getGiven()
            );
        }
        return $columns;
    }

    public function executeComponent() {

        try
        {

            $this->checkModules();
            // проверяем подключение модулей

            // получаем параметры методов GET и POST, из обьекта request который позволяет получить
            // данные о текущем запросе: метод и протокол, запрошенный URL, переданные параметры

            if(isset($this->$request['report_list'])){
                $page = explode('page-', $this->$request['report_list']);
                $page = $page[1];
            }else{
                $page = 1;
            }


            $this->arResult['COLUMNS'] = $this->getColumn(); // получаем названия полей таблицы
            $this->arResult['LISTS'] = $this->getList($page, $this->arParams['NUM_PAGE']); // получаем записи таблицы
            $this->arResult['COUNT'] =  Salary::getCount(); // количество записей

            // подключаем шаблон
            $this->IncludeComponentTemplate();
        }
        catch (SystemException $e)
        {
            ShowError($e->getMessage());
        }

    }



} 