<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/7/26
 * Time: 13:32
 */

namespace app\services;


class Note
{

	public static function fetchList($uid, $cateId=null)
	{
		$db = UserData::db($uid);
		$cateId && $db->where(['cate_id'=>$cateId]);

		return $db->select('note_id,cate_id,title,summary,created_at,updated_at')
			->from('notes')->orderBy(['updated_at'=>SORT_DESC])->fetchAll();
	}

	public static function getNotes($uid)
	{
		$db = UserData::db($uid);
		return $db->from('notes')->fetchAll();
	}

	public static function getNote($uid, $noteId)
	{
		$db = UserData::db($uid);
		return $db->from('notes')->where(['note_id'=>$noteId])->fetch();
	}

	/**
	 * @param int $uid
	 * @param array $data
	 * @return int NoteId
	 */
	public static function setNote($uid, $data)
	{
		$db = UserData::db($uid);

		if (empty($data['summary'])) {
			$data['summary'] = mb_substr(strip_tags($data['content']), 0, 100, 'utf-8');
		}

		if (!empty($data['note_id'])) {
			$noteId = $data['note_id'];
			$db->where(['note_id'=>$noteId])->update('notes', $data);
			return $noteId;
		} else {
			unset($data['note_id']);
			$data['created_at'] = time();
			$db->insert('notes', $data);
			return $db->insertId();
		}
	}

	public static function purifier($html)
	{
		static $purifier;

		if (empty($purifier)) {
			$config = \HTMLPurifier_Config::createDefault();
			$config->set('AutoFormat.RemoveEmpty', true);
			$config->set('AutoFormat.RemoveSpansWithoutAttributes', true);
			$config->set('AutoFormat.RemoveEmpty.Predicate', [
				'p' => [],
				'colgroup' => [],
				'th' => [],
				'td' => [],
				'iframe' => ['src'], //remove iframe with empty src attribute
			]);

			//Allow image base64 data URI
			$config->set('URI.AllowedSchemes', [
				'data' => true
			]);

			$purifier = new \HTMLPurifier($config);
		}

		return $purifier->purify($html);
	}

}