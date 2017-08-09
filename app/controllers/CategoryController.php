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

}