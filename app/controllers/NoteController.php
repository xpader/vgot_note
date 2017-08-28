<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/7/25
 * Time: 16:05
 */

namespace app\controllers;

use app\services\Category;
use app\services\Note;
use app\services\NoteShare;
use app\services\User;
use vgot\Exceptions\HttpNotFoundException;
use vgot\Web\Url;

class NoteController extends \app\components\Controller
{

	protected $requireLoginExceptActions = ['viewShare', 'blank'];

	/**
	 * 查看分享的笔记
	 *
	 * @return string
	 * @throws
	 */
	public function viewShare()
	{
		$app = getApp();
		$uid = $app->input->get('uid');
		$key = $app->input->get('id');

		if (!$uid || !$key) {
			throw new \ErrorException('参数错误');
		}

		$share = NoteShare::get($uid, $key);

		if (!$share) {
			throw new HttpNotFoundException('该笔记不存在！');
		}

		$note = Note::getNote($uid, $share['note_id']);

		if (!$note) {
			throw new HttpNotFoundException('数据异常，该笔记不存在');
		}

		$share['name'] = User::getName($uid);

		NoteShare::updateViewCount($uid, $share['note_id']);

		return $this->render('note/viewShare', compact('share', 'note'));
	}

	/**
	 * 获取笔记列表
	 */
	public function getList()
	{
		$app = getApp();
		$cid = $app->input->get('cid');

		$notes = Note::fetchList($app->user->id, $cid);

		if ($cid) {
			$category = Category::getCategory($app->user->id, $cid);
		} else {
			$category = null;
		}

		$now = time();

		array_walk($notes, function(&$row) use ($now, $app) {
			$row['created_at'] = date('Y-m-d H:i:s', $row['created_at']);
			$row['updated_at'] = date('Y-m-d H:i:s', $row['updated_at']);

			if ($row['share']) {
				if ($row['share_expires']) {
					$row['share'] = $row['share_expire'] > $now ? 2 : -1; //2 尚未过期，-1 已经过期
					$row['share_expires'] = date('Y-m-d H:i:s', $row['share_expires']);
				} else {
					$row['share'] = 1;
				}
				$row['share_url'] = Url::site(['note/view-share', 'uid'=>$app->user->id, 'id'=>$row['share_key']]);
			}

			unset($row['share_key']);
		});

		$app->output->json(compact('category', 'notes'));
	}

	/**
	 * 获取单个笔记详情
	 */
	public function getNote()
	{
		$app = getApp();
		$noteId = $app->input->get('id');
		$type = $app->input->get('type', 'html');

		$note = $noteId ? Note::getNote($app->user->id, $noteId) : null;

		if ($note) {
			$note['updated_at'] = date('Y-m-d H:i:s', $note['updated_at']);
		}

		if ($type == 'json') {
			$app->output->json($note);
		} else {
			$this->render('note/form', compact('note'));
		}
	}

	/**
	 * 保存/创建笔记
	 */
	public function save()
	{
		$app = getApp();
		$id = $app->input->post('id', 0, FILTER_SANITIZE_NUMBER_INT);
		$cateId = $app->input->post('cate_id', null, FILTER_SANITIZE_NUMBER_INT);
		$title = $app->input->post('title', 'strip_tags');
		$content = $app->input->post('content', '');

		if (trim($title) == '' && trim($content) == '') {
			$app->output->json(null);
		}

		$data = [
			'note_id' => $id,
			'cate_id' => $cateId ?: 1,
			'title' => $title,
			//'content' => Note::purifier($content),
			'content' => $content,
			'updated_at' => time()
		];

		$id = Note::setNote($app->user->id, $data);

		$app->output->json(['id'=>$id]);
	}

	/**
	 * 笔记展示空白页
	 */
	public function blank()
	{
		$expires = 86400;

		header('Cache-Control: public, max-age='.$expires);
		header('Pragma: cache');
		header('Expires: '.gmdate('D, d M Y H:i:s', time() + $expires).' GMT');
		$this->render('note/blank');
	}

}