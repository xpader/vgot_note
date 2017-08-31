<?php
/**
 * Created by PhpStorm.
 * User: Pader
 * Date: 2017/8/26
 * Time: 0:12
 */

namespace app\controllers;

use app\components\Controller;
use app\services\Note;
use app\services\Recylebin;

class RecylebinController extends Controller {

	public function index()
	{
		$this->render('note/recylebin');
	}

	public function remove()
	{
		$app = getApp();
		$id = $app->input->post('id', null, FILTER_SANITIZE_NUMBER_INT);

		if (!$id) {
			ajaxError('参数错误');
		}

		if (Recylebin::moveIn($app->user->id, $id)) {
			ajaxSuccess();
		} else {
			ajaxError('移动到回收站失败');
		}
	}

}