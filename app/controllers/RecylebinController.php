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

	public function getList()
	{
		$app = getApp();
		$notes = Recylebin::fetchList($app->user->id);

		array_walk($notes, function(&$row) {
			$row['created_at'] = date('Y-m-d H:i:s', $row['created_at']);
			$row['updated_at'] = date('Y-m-d H:i:s', $row['updated_at']);
			$row['deleted_at'] = date('Y-m-d H:i:s', $row['deleted_at']);
		});

		$app->output->json($notes);
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