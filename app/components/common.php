<?php
/**
 * Common functions
 */
use vgot\Exceptions\ExitException;

function ajaxError($msg=null, $data=null) {
	ajaxResponse(true, $msg, $data);
}

function ajaxSuccess($msg=null, $data=null) {
	ajaxResponse(false, $msg, $data);
}

function ajaxResponse($status, $msg=null, $data=null) {
	$app = getApp();
	$arr = ['status'=>$status];
	$msg !== null && $arr['msg'] = $msg;
	$data !== null && $arr['data'] = $data;
	$app->output->json($arr);
	throw new ExitException();
}