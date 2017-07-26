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

}