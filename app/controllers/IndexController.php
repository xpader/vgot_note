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
		$this->render('index/login');
	}

	public function loginPost()
	{
		$app = getApp();
		$username = $app->input->post('username', '');
		$password = $app->input->post('password', '');

		$user = $app->db->from('user')->where(['username'=>$username])->fetch();

		if (!$user || !password_verify($password, $user['password'])) {
			ajaxError('用户不存在或密码错误！');
		}

		$app->user->login($user);

		ajaxSuccess();
	}

}