<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/8/31
 * Time: 13:15
 */

namespace app\services;

/**
 * 回收站服务
 * @package app\services
 */
class Recylebin
{

	/**
	 * 将指定笔记移进回收站
	 *
	 * @param int $uid
	 * @param int $id
	 * @return bool|int
	 */
	public static function moveIn($uid, $id)
	{
		$db = UserData::db($uid);
		$now = time();

		if (!Note::checkExists($uid, $id)) {
			return false;
		}

		$select = $db->select("note_id,cate_id,title,summary,content,created_at,updated_at,$now AS deleted_time")
			->from('notes')->where(['note_id'=>$id])->limit(1)->buildSelect();

		if ($db->exec('REPLACE INTO '.$db->tableName('note_recylebin').' '.$select)) {
			return $db->where(['note_id'=>$id])->delete('notes');
		}

		return false;
	}

}