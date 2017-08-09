<?php

namespace app\controllers;

use app\components\User;
use app\services\Category;

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

		if (in_array($action, ['login', 'loginPost'])) {
			$this->requireLogin = false;
		}

		parent::init();
	}

	public function index()
	{
		$app = getApp();
		$this->render('index/workflow', compact('categories'));
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

		if ($username == '' || $password == '') {
			ajaxError('请输入用户名密码!');
		}

		$user = $app->db->from('user')->where(['username'=>$username])->fetch();

		if (!$user || !password_verify($password, $user['password'])) {
			ajaxError('用户不存在或密码错误！');
		}

		$app->user->login($user);

		ajaxSuccess();
	}

}