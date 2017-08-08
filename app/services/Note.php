<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/7/26
 * Time: 13:32
 */

namespace app\services;


class Note
{

	public static function getNotes($uid)
	{
		$db = UserData::db($uid);
		return $db->from('notes')->fetchAll();
	}

	public static function purifier($html)
	{
		static $purifier;

		if (empty($purifier)) {
			$config = \HTMLPurifier_Config::createDefault();
			$config->set('AutoFormat.RemoveEmpty', true);
			$config->set('AutoFormat.RemoveSpansWithoutAttributes', true);
			$config->set('AutoFormat.RemoveEmpty.Predicate', [
				'p' => [],
				'colgroup' => [],
				'th' => [],
				'td' => [],
				'iframe' => ['src'],
			]);

			$purifier = new \HTMLPurifier($config);
		}

		return $purifier->purify($html);
	}

}