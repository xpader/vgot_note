BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS `notes` (
	`note_id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`cate_id`	INTEGER NOT NULL,
	`title`	TEXT NOT NULL,
	`summary`	TEXT NOT NULL,
	`content`	TEXT NOT NULL,
	`created_at`	INTEGER,
	`updated_at`	INTEGER
);
CREATE TABLE IF NOT EXISTS `note_share` (
	`note_id`	INTEGER NOT NULL,
	`key`	TEXT NOT NULL UNIQUE,
	`share_time`	INTEGER NOT NULL,
	`expires`	INTEGER NOT NULL DEFAULT 0,
	`view_count`	INTEGER NOT NULL DEFAULT 0,
	PRIMARY KEY(`note_id`)
);
CREATE TABLE IF NOT EXISTS `note_recylebin` (
	`note_id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`cate_id`	INTEGER NOT NULL,
	`title`	TEXT NOT NULL,
	`summary`	TEXT NOT NULL,
	`content`	TEXT NOT NULL,
	`created_at`	INTEGER NOT NULL,
	`updated_at`	INTEGER NOT NULL,
	`deleted_at`	INTEGER NOT NULL
);
CREATE TABLE IF NOT EXISTS `note_history` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`note_id`	INTEGER NOT NULL,
	`cate_id`	INTEGER NOT NULL,
	`title`	TEXT NOT NULL,
	`summary`	TEXT NOT NULL,
	`content`	TEXT NOT NULL,
	`updated_at`	INTEGER
);
CREATE TABLE IF NOT EXISTS `category` (
	`cate_id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`name`	TEXT NOT NULL,
	`parent_id`	INTEGER NOT NULL
);
CREATE TABLE IF NOT EXISTS `attachs` (
	`attach_id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`note_id`	INTEGER NOT NULL,
	`path`	TEXT NOT NULL,
	`add_time`	INTEGER NOT NULL
);
CREATE INDEX IF NOT EXISTS `note_cate_id` ON `notes` (
	`cate_id`
);
CREATE INDEX IF NOT EXISTS `history_note_id` ON `note_history` (
	`note_id`
);
CREATE INDEX IF NOT EXISTS `attach_note_id` ON `attachs` (
	`note_id`
);
COMMIT;
