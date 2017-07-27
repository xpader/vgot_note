<?php

namespace app\controllers;

use app\components\User;
use vgot\Core\Controller;

/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/7/25
 * Time: 14:56
 */
class IndexController extends Controller
{

	public function index()
	{
		echo 'Hello World';

		$app = getApp();

		$data = $app->cache->get('test');

		if ($data === null) {
			$data = $app->db->from('notes')->fetchAll();
			$app->cache->set('test', $data, 3600);
			echo '---Refresh Cache---';
		}

		print_r($data);
	}

	public function user()
	{
		$app = getApp();

		echo $app->user->getId();

		print_r($this->user->info);
	}

	public function login()
	{
		$app = getApp();

		$user = User::findById(1);
		print_r($user);

		var_dump($app->user->login($user));
	}

}