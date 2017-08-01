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

	public function __construct()
	{
		parent::__construct();

		$app = getApp();
		$app->config->load('setting');

		//static url
		$staticUrl = $app->config->get('static_url');

		if (!preg_match('#^(https?\:)?\/\/#', $staticUrl)) {
			$staticUrl = Url::base().$staticUrl;
		}

		define('STATIC_URL', $staticUrl);
	}

	public function init()
	{
		$this->requireLogin && $this->checkLogin();
	}

	protected function checkLogin()
	{
		$user = getApp()->user;

		if ($user->isGuest) {
			echo '[LOGIN REQUIRED]';
		}
	}

}