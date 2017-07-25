<?php

namespace app\controllers;

use vgot\Core\Controller;

/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/7/25
 * Time: 14:56
 */
class IndexController extends Controller
{

	public function index()
	{
		echo 'Hello World';

		$app = getApp();
		$data = $app->db->from('notes')->fetchAll();
		print_r($data);
	}

}