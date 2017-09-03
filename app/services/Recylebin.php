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

	const TABLE = 'note_recylebin';

	public static function fetchList($uid)
	{
		$db = UserData::db($uid);
		return $db->select('n.note_id,n.cate_id,n.title,n.summary,n.created_at,n.updated_at,n.deleted_at')
			->from('note_recylebin', 'n')->orderBy(['n.updated_at'=>SORT_DESC])->fetchAll();
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
		$note = $db->from(self::TABLE)->where(['note_id'=>$id])->fetch();

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

		$db->where(['note_id'=>$id])->delete(self::TABLE);
	}

}