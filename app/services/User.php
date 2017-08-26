<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/8/27
 * Time: 02:55
 */

namespace app\services;

class User
{

	public static function getName($uid)
	{
		$app = getApp();
		return $app->db->select('username')->from('user')->where(['uid'=>$uid])->fetchColumn();
	}

}