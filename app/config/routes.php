<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 17-4-23
 * Time: 下午11:29
 */
return [
	'default_controller' => 'IndexController',
	'default_action' => 'index',
	'404_override' => false,
	'404_view' => 'errors/404',

	/**
	 * Router method
	 *
	 * Router base on uri params, this configure is setting what type of params use for router.
	 * PATH_INFO, QUERY_STRING, GET
	 */
	'route_method' => 'GET',
	/**
	 * Set route param name when router_method is GET.
	 * Get value only allow a-z0-9\-_
	 */
	'route_param' => 'app',
	'suffix' => '',

	/**
	 * Set case symbol in url
	 * @var string|false
	 */
	'case_symbol' => '-',
	'ucfirst' => false,
	'route_maps' => [
		'login' => 'index/login'
	]
];