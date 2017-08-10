BEGIN TRANSACTION;
CREATE TABLE "notes" (
	`note_id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`cate_id`	INTEGER NOT NULL,
	`title`	TEXT NOT NULL,
	`summary`	TEXT NOT NULL,
	`content`	TEXT NOT NULL,
	`created_at`	INTEGER,
	`updated_at`	INTEGER
);
CREATE TABLE "note_share" (
	`note_id`	INTEGER NOT NULL,
	`key`	TEXT NOT NULL UNIQUE,
	`share_time`	INTEGER NOT NULL,
	PRIMARY KEY(`note_id`)
);
CREATE TABLE "category" (
	`cate_id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`name`	TEXT NOT NULL,
	`parent_id`	INTEGER NOT NULL
);
CREATE TABLE "attachs" (
	`attach_id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`note_id`	INTEGER NOT NULL,
	`path`	TEXT NOT NULL,
	`add_time`	INTEGER NOT NULL
);
CREATE INDEX `note_cate_id` ON `notes` (`cate_id` )


;
CREATE INDEX `attach_note_id` ON `attachs` (`note_id` )


;
COMMIT;
