<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/8/20
 * Time: 01:34
 *
 * @var array $note
 */
?>
<form method="post" name="note">
	<div class="note-header" id="noteHeader">
		<input class="form-control" type="text" name="title" value="<?=$note['title']?>" placeholder="标题">
		<small title="最后修改时间"><?=$note['updated_at']?></small>
	</div>
	<!-- /.box-header -->
	<div class="note-body">
		<textarea id="editor1" name="content" rows="10" cols="80"><?=htmlspecialchars($note['content'])?></textarea>
	</div>
	<input type="hidden" name="id" value="<?=($note['note_id'] ?: 0)?>">
	<input type="hidden" name="cate_id" value="<?=$note['cate_id']?>">
	<input type="hidden" name="changed" value="0">
</form>
