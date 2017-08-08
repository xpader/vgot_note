<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/8/9
 * Time: 03:10
 */

namespace app\services;


class Category
{

	public static function fetchCategories($uid)
	{
		$db = UserData::db($uid);
		return $db->from('category')->fetchAll();
	}

}