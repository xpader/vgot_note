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
use app\services\UserData;

class NoteController extends \app\components\Controller
{

	public function html()
	{
		$dirty_html = 'sdsadfsfsdfsafs<script>alert(\'asdf\');</script>&lt;script&gt;<p></p>aaa';

		$clean_html = Note::purifier($dirty_html);

		echo $clean_html;
	}

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

		array_walk($notes, function(&$row) {
			$row['created_at'] = date('Y-m-d H:i:s', $row['created_at']);
			$row['updated_at'] = date('Y-m-d H:i:s', $row['updated_at']);
		});

		$app->output->json(compact('category', 'notes'));
	}

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
			return $this->render('note/form', compact('note'));
		}
	}

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
			'content' => Note::purifier($content),
			'updated_at' => time()
		];

		$id = Note::setNote($app->user->id, $data);

		$app->output->json(['id'=>$id]);
	}

}