<?php
/**
 * Common functions
 */
use vgot\Exceptions\ExitException;

function ajaxError($msg=null, $data=null) {
	ajaxResponse(false, $msg, $data);
}

function ajaxSuccess($msg=null, $data=null) {
	ajaxResponse(true, $msg, $data);
}

function ajaxResponse($status, $msg=null, $data=null) {
	$app = getApp();
	$arr = ['status'=>$status];
	$msg !== null && $arr['msg'] = $msg;
	$data !== null && $arr['data'] = $data;
	$app->output->json($arr);
	throw new ExitException();
}

/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source https://gravatar.com/site/implement/images/php/
 */
function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
	$url = 'https://www.gravatar.com/avatar/';
	$url .= md5( strtolower( trim( $email ) ) );
	$url .= "?s=$s&d=$d&r=$r";
	if ( $img ) {
		$url = '<img src="' . $url . '"';
		foreach ( $atts as $key => $val )
			$url .= ' ' . $key . '="' . $val . '"';
		$url .= ' />';
	}
	return $url;
}

function userDb($uid=null) {
	$uid === null && $uid = getApp()->user->id;
	return \app\services\UserData::db($uid);
}
