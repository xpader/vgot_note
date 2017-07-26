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

	//The providers to register
	'providers' => [
		'security' => ['vgot\Core\Security', ['KF9cOBGhvVOekAK7n6Ei']],
		'cache' => [
			'vgot\Cache\FileCache', [
				[
					'stor_dir' => DATA_DIR.'/cache',
					'cache_in_memory' => true
				]
			]
		]
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
	'set_error_handler' => null
];