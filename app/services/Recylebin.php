<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/8/31
 * Time: 13:15
 */

namespace app\services;

use vgot\Database\DB;

/**
 * 回收站服务
 * @package app\services
 */
class Recylebin
{

	const TABLE = 'note_recylebin';

	public static function fetchList($uid)
	{
		$db = UserData::db($uid);
		return $db->select('n.note_id,n.cate_id,n.title,n.summary,n.created_at,n.updated_at,n.deleted_at')
			->from('note_recylebin', 'n')->orderBy(['n.deleted_at'=>SORT_DESC])->fetchAll();
	}

	public static function getNote($uid, $id)
	{
		$db = userDb($uid);
		return $db->from('note_recylebin')->where(['note_id'=>$id])->get();
	}

	/**
	 * 遍历回收站中所有笔记的ID
	 *
	 * @param $uid
	 * @param int $num 按删除时间从老到新获取指定数量
	 * @return array
	 */
	public static function fetchAllIds($uid, $num=0)
	{
		$db = userDb($uid);
		$db->from(self::TABLE)->select('note_id');

		if ($num > 0) {
			$db->limit($num)->orderBy(['deleted_at'=>SORT_ASC]);
		}

		$ids = [];

		while ($row = $db->fetch(DB::FETCH_NUM)) {
			$ids[] = $row[0];
		}

		return $ids;
	}

	/**
	 * 统计回收站中笔记的数量
	 *
	 * @param int $uid
	 * @return int
	 */
	public static function count($uid)
	{
		return userDb($uid)->from(self::TABLE)->count();
	}

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

		if ($db->exec('REPLACE INTO '.$db->tableName(self::TABLE).' '.$select)) {
			return $db->where(['note_id'=>$id])->delete('notes');
		}

		return false;
	}

	/**
	 * 将回收站中的指定内容移回笔记列表中
	 * 如果原分类不存在则移进默认分类中
	 *
	 * @param int $uid
	 * @param int $id
	 * @return bool
	 */
	public static function moveBack($uid, $id)
	{
		$db = UserData::db($uid);
		$note = $db->from(self::TABLE)->where(['note_id'=>$id])->get();

		if (!$note) {
			return false;
		}

		unset($note['deleted_at']);

		//如果原分类不存在了，则恢复到默认分类中
		$cate = Category::getCategory($uid, $note['cate_id']);
		if (!$cate) {
			$note['cate_id'] = 1;
		}

		if ($db->insert(Note::TABLE, $note)) {
			$db->where(['note_id'=>$id])->delete(self::TABLE);
			return true;
		}

		return false;
	}

	/**
	 * 彻底删除回收站中的笔记
	 *
	 * @param int $uid
	 * @param int $id
	 * @return bool
	 */
	public static function delete($uid, $id)
	{
		$db = userDb($uid);
		NoteShare::cancel($uid, $id);
		NoteHistory::clearHistory($uid, $id);

		//Todo: Delete Attachments

		return $db->where(['note_id'=>$id])->delete(self::TABLE);
	}

}