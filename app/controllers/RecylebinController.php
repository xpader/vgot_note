<?php
/**
 * Created by PhpStorm.
 * User: Pader
 * Date: 2017/8/26
 * Time: 0:12
 */

namespace app\controllers;

use app\components\Controller;
use app\services\Category;
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

	/**
	 * 获取单个回收站中笔记详情
	 */
	public function getNote()
	{
		$app = getApp();
		$noteId = $app->input->get('id');
		$type = $app->input->get('type', 'html');

		$note = $noteId ? Recylebin::getNote($app->user->id, $noteId) : null;

		if ($note) {
			$note['updated_at'] = date('Y-m-d H:i:s', $note['updated_at']);
		}

		$app->output->json($note);
	}

	/**
	 * 移到回收站
	 */
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

	/**
	 * 恢复笔记
	 */
	public function restore()
	{
		$app = getApp();
		$id = $app->input->post('id', null, FILTER_SANITIZE_NUMBER_INT);

		if (!$id) {
			ajaxError('参数错误');
		}

		if (Recylebin::moveBack($app->user->id, $id)) {
			$category = Category::getNoteCategory($app->user->id, $id);
			ajaxSuccess('已恢复至'.$category['name']);
		} else {
			ajaxError('恢复失败');
		}
	}

	/**
	 * 彻底删除
	 */
	public function delete()
	{
		$app = getApp();
		$id = $app->input->post('id', null, FILTER_SANITIZE_NUMBER_INT);

		if (!$id) {
			ajaxError('参数错误');
		}

		if (Recylebin::delete($app->user->id, $id)) {
			ajaxSuccess();
		} else {
			ajaxError('删除失败！');
		}
	}

	/**
	 * 清空回收站
	 */
	public function clean()
	{
		$app = getApp();

		$recylebinIds = Recylebin::fetchAllIds($app->user->id);

		if (!$recylebinIds) {
			ajaxError('回收站是空的');
		}

		$failedIds = [];

		foreach ($recylebinIds as $id) {
			if (!Recylebin::delete($app->user->id, $id)) {
				$failedIds[] = $id;
			}
		}

		if (!$failedIds) {
			ajaxSuccess();
		} else {
			ajaxSuccess('笔记 '.join(',', $failedIds).' 删除失败');
		}
	}

}