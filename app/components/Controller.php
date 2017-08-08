<?php

namespace app\components;

use vgot\Web\Url;

/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/7/25
 * Time: 16:18
 */
class Controller extends \vgot\Core\Controller
{

	protected $requireLogin = true;

	public function init()
	{
		$this->requireLogin && $this->checkLogin();
	}

	protected function checkLogin()
	{
		$user = getApp()->user;

		if ($user->isGuest) {
			$loginUrl = Url::site('login');
			header('Location: '.$loginUrl);
			exit;
		}
	}

}