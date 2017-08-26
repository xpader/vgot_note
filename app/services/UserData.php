<?php

namespace app\services;

use vgot\Database\QueryBuilder;

/**
 * User Data Service
 */
class UserData {

	private static $dbConnections = [];
	private static $userHashs = [];

	/**
	 * 获取用户的数据文件根目录
	 *
	 * @param int $uid
	 * @return string
	 * @throws \vgot\Exceptions\ApplicationException
	 */
	public static function dir($uid)
	{
		$app = getApp();

		if (!isset(self::$userHashs[$uid])) {
			if ($uid == $app->user->id) {
				$hash = $app->user->info['hash'];
			} else {
				$hash = $app->db->select('hash')->from('user')->where(['uid' => $uid])->fetchColumn();

				if (!$hash) {
					throw new \vgot\Exceptions\ApplicationException('用户不存在');
				}
			}

			self::$userHashs[$uid] = $hash;
		}

		return DATA_DIR.'/'.$app->config->get('note_dir').'/user/'.$uid.'_'.self::$userHashs[$uid];
	}

	/**
	 * Get user DB connection
	 *
	 * @param int|null $uid 指定 null 则为当前登录用户
	 * @return QueryBuilder
	 * @throws
	 */
	public static function db($uid=null)
	{
		$uid === null && $uid = getApp()->user->id;

		if (!isset(self::$dbConnections[$uid])) {
			$config = self::getDbConfig($uid);

			if (!is_file($config['filename'])) {
				throw new \ErrorException('用户数据库文件丢失！');
			}

			self::$dbConnections[$uid] = new QueryBuilder($config);
		}

		return self::$dbConnections[$uid];
	}

	/**
	 * 创建用户数据库
	 *
	 * @param int $uid
	 * @throws \ErrorException
	 */
	public static function createDatabase($uid)
	{
		$config = self::getDbConfig($uid);

		if (is_file($config['filename'])) {
			throw new \ErrorException('用户数据库文件已经存在，无法重复创建！');
		}

		//创建目录与文件
		$dir = dirname($config['filename']);

		if (!is_dir($dir)) {
			mkdir($dir, 0775, true);
		}

		touch($config['filename']);
		chmod($config['filename'], 0755);

		$db = new QueryBuilder($config);

		//创建数据库结构
		DbHelper::executeSqlFile($db, DATA_DIR . '/note.sql');

		self::$dbConnections[$uid] = $db;
	}

	protected static function getDbConfig($uid)
	{
		$userDir = self::dir($uid);

		return [
			'filename' => $userDir.'/note.db',
			'driver' => 'sqlite3',
			'query_builder' => true,
			'debug' => true
		];
	}

}