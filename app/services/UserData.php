<?php

namespace app\services;

use vgot\Database\QueryBuilder;

/**
 * User Data Service
 */
class UserData {

	private static $dbConnections = [];

	public static function getUserDir($uid)
	{
		return DATA_DIR.'/note/user/'.$uid;
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
			$userDir = self::getUserDir($uid);

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
				$createSql = file_get_contents(DATA_DIR . '/note.sql');
				$sqls = explode(';', $createSql);

				foreach ($sqls as $sql) {
					$sql = trim($sql);
					if ($sql) {
						$conn->exec($sql);
					}
				}
			}

			self::$dbConnections[$uid] = $conn;
		}

		return self::$dbConnections[$uid];
	}

}