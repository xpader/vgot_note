<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/9/1
 * Time: 00:39
 */

namespace app\services;

/**
 * 笔记历史记录服务
 * @package app\services
 */
class NoteHistory
{

	const TABLE = 'note_history';
	const MAX_NUM_PER_NOTE = 15; //每个笔记最多保存历史记录数量，超出后将删除多出的较早前的记录
	const HISTORY_INTERVAL = 1200; //保存历史记录的时间间隔秒数，上次修改距本次修改至少要达到这个间隔才会保存历史记录

	/**
	 * 将指定笔记添加到历史记录中
	 * 当该笔记历史记录总数超过设置的最大值会删除较老的多出的历史记录
	 *
	 * @param int $uid
	 * @param int $id
	 * @param int $updatedAt
	 * @return bool|false 成功返回历史记录ID，失败返回false
	 */
	public static function save($uid, $id, $updatedAt)
	{
		//有历史记录则以最后一条历史记录的时间作对比，否则用创建时间做对比
		$lastHistory = self::getLastHistory($uid, $id);

		if ($lastHistory) {
			$lastUpdated = $lastHistory['updated_at'];
		} else {
			$times = Note::getTime($uid, $id);
			$lastUpdated = $times['created_at'];
		}

		//必须在指定时间间隔外
		if ($updatedAt - $lastUpdated <= NoteHistory::HISTORY_INTERVAL) {
			return false;
		}

		$db = userDb($uid);
		$note = $db->select('note_id,cate_id,title,summary,content,updated_at')
			->from(Note::TABLE)->where(['note_id'=>$id])->fetch();

		if (!$note) return false;

		//对比若指定字段信息都未发生变化，则不增加历史记录
		if ($lastHistory) {
			$diffKeysIdx = ['title'=>'', 'summary'=>'', 'content'=>''];
			$diffNote = array_intersect_key($note, $diffKeysIdx);
			$diffHistory = array_intersect_key($lastHistory, $diffKeysIdx);
			if (!array_diff_assoc($diffNote, $diffHistory)) {
				return false;
			}
		}

		if ($db->insert(self::TABLE, $note)) {
			$historyId = $db->insertId();

			//如果超出最大数限制，则删除多出的
			$count = $db->from(self::TABLE)->where(['note_id'=>$id])->count();
			if ($count > self::MAX_NUM_PER_NOTE) {
				$firstOverflow = $db->select('id')->from(self::TABLE)->where(['note_id'=>$id])
					->orderBy(['id'=>SORT_DESC])->limit(self::MAX_NUM_PER_NOTE, 1)->fetchColumn();
				$db->where(['note_id'=>$id, 'id <='=>$firstOverflow])->delete(self::TABLE);
			}

			return $historyId;
		} else {
			return false;
		}
	}

	/**
	 * 获取指定笔记的最后一条历史记录数据
	 *
	 * @param int $uid
	 * @param int $id
	 * @return array|null
	 */
	public static function getLastHistory($uid, $id)
	{
		$db = userDb($uid);
		return $db->from(self::TABLE)->where(['note_id'=>$id])->orderBy(['id'=>SORT_DESC])->limit(1)->fetch();
	}

	public static function clearHistory($uid, $id)
	{
		$db = userDb($uid);
		$db->where(['note_id'=>$id])->delete(self::TABLE);
	}

}