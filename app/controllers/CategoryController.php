<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/8/9
 * Time: 13:06
 */

namespace app\controllers;

use app\services\Category;

class CategoryController extends \app\components\Controller
{

	public function getCategories()
	{
		$app = getApp();
		$categories = Category::fetchCategories($app->user->id);
		$app->output->json($categories);
	}

	public function create()
	{
		$name = $this->input->post('name');

		if (!$name) {
			ajaxError('请输入分类名称');
		}

		$category = Category::addCategory($this->user->id, $name);

		ajaxSuccess(null, $category);
	}

	/**
	 * 修改分类名称
	 */
	public function rename()
	{
		$app = getApp();
		$cid = $app->input->post('cid', FILTER_SANITIZE_NUMBER_INT);
		$name = $app->input->post('name', 'trim');

		if (!$cid || !$name) {
			ajaxError('参数缺失');
		}

		if ($cid == 1) {
			ajaxError('不可修改默认分类名称');
		}

		$category = Category::getCategory($app->user->id, $cid);

		if (!$category) {
			ajaxError('该分类不存在');
		}

		if ($category['name'] != $name) {
			Category::update($app->user->id, $cid, ['name'=>$name]);
		}

		ajaxSuccess();
	}

}