<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/8/17
 * Time: 14:00
 */

namespace app\services;

use vgot\Database\QueryBuilder;

class DbHelper
{

	/**
	 * 执行 SQL 文件
	 *
	 * @param QueryBuilder $db
	 * @param string $sqlFile
	 */
	public static function executeSqlFile($db, $sqlFile)
	{
		$createSql = file_get_contents($sqlFile);
		$sqls = explode(';', $createSql);

		foreach ($sqls as $sql) {
			$sql = trim($sql);
			if ($sql) {
				$db->exec($sql);
			}
		}
	}

}