<?php

namespace app\controllers;

use app\components\User;

/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/7/25
 * Time: 14:56
 */
class IndexController extends \app\components\Controller
{

	public function init()
	{
		$app = getApp();
		$action = $app->input->uri('action');

		if (in_array($action, ['login'])) {
			$this->requireLogin = false;
		}

		parent::init();
	}

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
		throw new \ErrorException('WTF');
		$this->render('index/login');
	}

}