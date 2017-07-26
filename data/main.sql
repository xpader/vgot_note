--
-- 由SQLiteStudio v3.1.1 产生的文件 周三 7月 26 12:50:01 2017
--
-- 文本编码：UTF-8
--
PRAGMA foreign_keys = off;
BEGIN TRANSACTION;

-- 表：user
DROP TABLE IF EXISTS user;
CREATE TABLE [user] (
  [uid] INTEGER NOT NULL, 
  [username] TEXT NOT NULL, 
  [password] TEXT NOT NULL, 
  [hash] TEXT NOT NULL, 
  [regip] TEXT NOT NULL, 
  [regtime] INTEGER NOT NULL, 
  [last_login_ip] TEXT NOT NULL, 
  [last_login_time] INTEGER NOT NULL);

COMMIT TRANSACTION;
PRAGMA foreign_keys = on;
