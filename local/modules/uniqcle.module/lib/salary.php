<?php

namespace Uniqcle\Module;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;

Loc::loadMessages(__FILE__);

/**
 * Class SalaryTable
 *
 * Fields:
 * <ul>
 * <li> id int mandatory
 * <li> name string(50) optional
 * <li> age int optional
 * <li> summa int optional
 * <li> given int optional
 * </ul>
 *
 * @package Bitrix\Salary
 **/

class SalaryTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'uniqcle_salary';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return [
			new IntegerField(
				'id',
				[
					'primary' => true,
					'autocomplete' => true,
					'title' => Loc::getMessage('SALARY_ENTITY_ID_FIELD')
				]
			),
			new StringField(
				'name',
				[
					'validation' => [__CLASS__, 'validateName'],
					'title' => Loc::getMessage('SALARY_ENTITY_NAME_FIELD')
				]
			),
			new IntegerField(
				'age',
				[
					'title' => Loc::getMessage('SALARY_ENTITY_AGE_FIELD')
				]
			),
			new IntegerField(
				'summa',
				[
					'title' => Loc::getMessage('SALARY_ENTITY_SUMMA_FIELD')
				]
			),
			new IntegerField(
				'given',
				[
					'title' => Loc::getMessage('SALARY_ENTITY_GIVEN_FIELD')
				]
			),
		];
	}

	/**
	 * Returns validators for name field.
	 *
	 * @return array
	 */
	public static function validateName()
	{
		return [
			new LengthValidator(null, 50),
		];
	}
}