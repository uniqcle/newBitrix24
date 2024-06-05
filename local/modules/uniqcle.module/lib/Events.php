<?php

namespace Uniqcle\Module;

use Bitrix\Crm\DealTable;

class Events
{
	/**
	 * @throws \Exception
	 */
	public static function onAfterUpdate(array $deal): bool
	{

		DealTable::update($deal['ID'], ['TITLE' => 'Обновлено']);
	}
}