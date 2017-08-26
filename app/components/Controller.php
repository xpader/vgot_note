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

	/**
	 * 是否强制要求登录
	 *
	 * @var bool
	 */
	protected $requireLogin = true;

	/**
	 * 设置绝对要求登录的动作方法列表
	 * 当 requireLogin 关闭时，此列表中的动作强制要求登录
	 *
	 * @var array
	 */
	protected $requireLoginMustActions = [];

	/**
	 * 设置免登录的动作方法名列表
	 * 当 requireLogin 开启时，在此列表中的动作不要求登录
	 *
	 * @var array
	 */
	protected $requireLoginExceptActions = [];

	public function __init()
	{
		if (!is_file(DATA_DIR.'/install.lock')) {
			header('Location:'.Url::site('install'));
			exit;
		}

		//登录检查
		if ($this->requireLogin) {
			if (count($this->requireLoginExceptActions) > 0) {
				$action = getApp()->input->uri('action');
				if (in_array($action, $this->requireLoginExceptActions)) {
					return;
				}
			}
			$this->checkLogin();
		} elseif (count($this->requireLoginMustActions) > 0) {
			$action = getApp()->input->uri('action');
			if (in_array($action, $this->requireLoginExceptActions)) {
				$this->checkLogin();
			}
		}
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