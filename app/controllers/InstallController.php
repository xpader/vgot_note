<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/8/17
 * Time: 13:23
 */

namespace app\controllers;


use vgot\Core\Controller;
use vgot\Exceptions\ExitException;

class InstallController extends Controller
{

	public function __construct()
	{
		parent::__construct();

		if (is_file(DATA_DIR.'/install.lock')) {
			throw new ExitException('You had installed it, can not install repeatedly.');
		}
	}

	public function index()
	{
		touch(DATA_DIR.'/install.lock');
		echo 'Install';
	}

}