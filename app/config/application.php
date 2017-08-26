<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/4/23
 * Time: 02:26
 */

return [
	'id' => 'Note',
	'base_url' => 'http://127.0.0.1/dev/vgot_note/',
	'entry_file' => '',

	//The providers to register
	'providers' => [
		'security' => ['vgot\Core\Security', ['KF9cOBGhvVOekAK7n6Ei']],
		'cache' => ['vgot\Cache\FileCache', [
				[
					'stor_dir' => DATA_DIR.'/cache',
					'cache_in_memory' => true
				]
			]
		],
		'user' => ['app\components\User', ['vnote_grant', 86400*7, true]]
	],

	//Output
	'output_gzip' => true,
	'output_gzip_level' => 7,
	'output_gzip_minlen' => 1024, //1KB
	'output_gzip_force_soft' => false, //是否强制使用框架自带的gzip压缩，否则会检测是否可以启用PHP内置压缩

	/**
	 * 设置系统的错误捕捉事件，如果不设此选项，则使用比方内置方法
	 *
	 * @var callable
	 */
	'set_error_handler' => null,

	'on_boot' => function() {
		$app = getApp();
		$app->config->load('setting');

		//static url
		$staticUrl = $app->config->get('static_url');

		if (!preg_match('#^(https?\:)?\/\/#', $staticUrl)) {
			$staticUrl = \vgot\Web\Url::base().$staticUrl;
		}

		define('STATIC_URL', $staticUrl);

		require_once __DIR__.'/../components/common.php';
	}
];