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

		$data = $app->cache->get('test');

		if ($data === null) {
			$data = $app->db->from('notes')->fetchAll();
			$app->cache->set('test', $data, 3600);
			echo '---Refresh Cache---';
		}

		print_r($data);
	}

}