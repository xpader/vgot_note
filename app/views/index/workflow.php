<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/8/9
 * Time: 02:09
 *
 * @var $cid int
 */
$this->render('common/header');
?>
<div class="wrapper">
	<?php $this->render('common/top'); ?>
	<?php $this->render('common/sidebar'); ?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<div class="row" style="height:100%;">
			<div class="col-xs-3 hidden-xs note-list">
				<div class="box box-note">
					<div class="box-header with-border">
						<h3 class="box-title">
							<span id="noteListTitle">我的笔记</span>
							<small><span id="noteListCount">*</span> 个笔记</small>
							<i class="fa fa-refresh fa-spin" id="noteLoading" style="color:#555;display:none;"></i>
						</h3>
					</div>
					<div class="box-body no-padding">
						<ul class="nav nav-pills nav-stacked" id="noteList"></ul>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
			<div class="col-xs-9" style="padding-left:0;height:100%;">
				<i class="fa fa-pencil-square editor-icon"></i>
				<div class="box box-note" id="noteBox" style="display:none;"></div>
			</div>
		</div>
	</div>
	<script src="<?=STATIC_URL?>lib/ckeditor/ckeditor.js"></script>
	<script src="<?=STATIC_URL?>js/noteside.js"></script>
	<script src="<?=STATIC_URL?>js/workflow.js"></script>
	<script type="text/javascript">
	var currentCateId = <?=$cid?>, currentNoteId = 0;
	</script>
</div>

<?php $this->render('common/footer'); ?>