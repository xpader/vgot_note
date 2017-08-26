<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/8/27
 * Time: 00:20
 */

namespace app\controllers;

use app\components\Controller;
use app\services\Note;
use app\services\NoteShare;
use vgot\Web\Url;

class ShareController extends Controller
{

	/**
	 * 分享笔记
	 */
	public function share()
	{
		$app = getApp();
		$id = $app->input->post('id');
		$expires = $app->input->post('expires', 0);

		if (!$id) {
			ajaxError('参数缺失');
		}

		if ($expires) {
			$expires = strtotime($expires);

			if ($expires < time()) {
				$expires = 0;
			}
		}

		if (!Note::checkExists($app->user->id, $id)) {
			ajaxError('笔记不存在，无法分享');
		}

		$share = NoteShare::share($app->user->id, $id, $expires);
		$share['url'] = Url::site(['note/view-share', 'uid'=>$app->user->id, 'id'=>$share['key']]);

		ajaxSuccess(null, $share);
	}

	/**
	 * 取消笔记分享
	 */
	public function cancel()
	{
		$app = getApp();
		$id = $app->input->post('id');

		if (!$id) {
			ajaxError('参数缺失');
		}

		if (!Note::checkExists($app->user->id, $id)) {
			ajaxError('笔记不存在');
		}

		NoteShare::cancel($app->user->id, $id);
		ajaxSuccess();
	}

}