<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/8/26
 * Time: 23:57
 */

namespace app\services;

class NoteShare
{

	public static function get($uid, $key)
	{
		$db = UserData::db($uid);
		$share = $db->from('note_share')->where(['key'=>$key])->get();

		if (!$share || ($share['expires'] > 0 && $share['expires'] < time())) {
			return null;
		} else {
			return $share;
		}
	}

	/**
	 * 分享指定笔记
	 *
	 * @param int $uid
	 * @param $noteId
	 * @param int $expires 设置分享的过期时间，0为永不过期
	 * @return array
	 */
	public static function share($uid, $noteId, $expires=0)
	{
		$db = UserData::db($uid);

		$share = $db->from('note_share')->where(['note_id'=>$noteId])->get();

		if (!$share) {
			$share = [
				'note_id' => $noteId,
				'key' => self::generateKey($noteId),
				'share_time' => time(),
				'expires' => $expires
			];
		} else {
			if ($share['expires'] > 0 && $share['expires'] < time()) {
				$share['key'] = self::generateKey($noteId);
				$share['share_time'] = time();
			}
			$share['expires'] = $expires;
		}

		$db->insert('note_share', $share, true);

		return $share;
	}

	public static function updateViewCount($uid, $noteId)
	{
		UserData::db($uid)->where(['note_id'=>$noteId])->update('note_share', ['^view_count'=>'view_count+1']);
	}

	/**
	 * 取消指定笔记的分享
	 *
	 * @param int $uid
	 * @param int $noteId
	 */
	public static function cancel($uid, $noteId)
	{
		$db = UserData::db($uid);
		$db->where(['note_id'=>$noteId])->delete('note_share');
	}

	/**
	 * 生成指定笔记用于分享的 key
	 *
	 * @param int $noteId
	 * @return string
	 */
	protected static function generateKey($noteId)
	{
		return md5($noteId.uniqid());
	}

}