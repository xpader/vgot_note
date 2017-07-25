<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/7/25
 * Time: 14:52
 */

use vgot\Boot;

define('BASE_PATH', __DIR__); //constant only for app

ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);

require __DIR__.'/../vgot_framework/src/vgot/Boot.php';

Boot::addNamespaces([
	'app' => BASE_PATH.'/app',
]);

//Boot::addAutoloadStructs([BASE_PATH, BASE_PATH.'/src']);

Boot::systemConfig([
	'controller_namespace' => '\app\controllers',
	'config_path' => BASE_PATH.'/app/config',
	'views_path' => BASE_PATH.'/app/views',
	'common_config_path' => null,
	'common_views_path' => null,
]);

Boot::run();
