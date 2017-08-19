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

	public function userdb()
	{
		$db = UserData::db(1);
		print_r($db);
	}

	public function userNotes()
	{
		$notes = Note::getNotes(1);
		print_r($notes);
	}

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

		$note = $noteId ? Note::getNote($app->user->id, $noteId) : null;
		$app->output->json($note);
	}

}