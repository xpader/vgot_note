<?php

namespace app\services;

use vgot\Database\QueryBuilder;

/**
 * User Data Service
 */
class UserData {

	private static $dbConnections = [];
	private static $userHashs = [];

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
	 * @param int $uid
	 * @return QueryBuilder
	 * @throws
	 */
	public static function db($uid)
	{
		if (!isset(self::$dbConnections[$uid])) {
			$userDir = self::dir($uid);

			$config = [
				'filename' => $userDir.'/note.db',
				'driver' => 'sqlite3',
				'query_builder' => true,
				'debug' => true
			];

			$createMode = false;

			if (!is_file($config['filename'])) {
				$db = getApp()->db;
				$user = $db->select('uid')->from('user')->where(['uid'=>$uid])->fetch();

				if (!$user) {
					throw new \ErrorException('该用户不存在，无法获取数据库连接！');
				}

				if (!is_dir($userDir)) {
					mkdir($userDir, 0775, true);
				}

				touch($config['filename']);
				chmod($config['filename'], 0755);
				$createMode = true;
			}

			$conn = new QueryBuilder($config);

			//create db
			if ($createMode) {
				DbHelper::executeSqlFile($conn, DATA_DIR . '/note.sql');
			}

			self::$dbConnections[$uid] = $conn;
		}

		return self::$dbConnections[$uid];
	}

}