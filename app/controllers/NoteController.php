<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/7/25
 * Time: 16:05
 */

namespace app\controllers;

use app\services\Note;
use app\services\UserData;
use vgot\Core\Controller;

class NoteController extends Controller
{

	public function userdb()
	{
		$db = UserData::db(2);
		print_r($db);
	}

	public function userNotes()
	{
		$notes = Note::getNotes(1);
		print_r($notes);
	}

}