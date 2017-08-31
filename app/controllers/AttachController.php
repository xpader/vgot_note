<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/8/31
 * Time: 21:56
 */

namespace app\controllers;

use app\components\Controller;
use app\services\Recylebin;

class AttachController extends Controller
{

	public $requireLogin = false;
	public $requireLoginMustActions = [];

	public function index()
	{
		echo 'Attachment';
	}

	public function restore()
	{
		$ret = Recylebin::moveBack(1, 47);
		var_dump($ret);
	}

}