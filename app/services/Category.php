<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/8/9
 * Time: 03:10
 */

namespace app\services;


class Category
{

	public static function fetchCategories($uid)
	{
		$db = UserData::db($uid);
		return $db->from('category')->fetchAll();
	}

	public static function getCategory($uid, $cid)
	{
		$db = UserData::db($uid);
		return $db->from('category')->where(['cate_id'=>$cid])->get();
	}

	public static function addCategory($uid, $name)
	{
		$db = UserData::db($uid);

		$db->insert('category', ['name'=>$name, 'parent_id'=>0]);
		$id = $db->insertId();

		return $db->from('category')->where(['cate_id'=>$id])->get();
	}

	public static function update($uid, $cid, $data)
	{
		$db = UserData::db($uid);
		$db->where(['cate_id'=>$cid])->update('category', $data);
	}

	/**
	 * 根据指定笔记ID找到该笔记所属分类的数据
	 *
	 * @param int $uid
	 * @param int $noteId
	 * @return array
	 */
	public static function getNoteCategory($uid, $noteId)
	{
		$db = userDb($uid);
		return $db->from('category', 'c')->leftJoin(Note::TABLE.' n', 'cate_id')->where(['n.note_id'=>$noteId])->get();
	}

}