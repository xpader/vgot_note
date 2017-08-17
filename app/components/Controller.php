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
		if (!is_file(DATA_DIR.'/install.lock')) {
			header('Location:'.Url::site('install'));
			exit;
		}

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