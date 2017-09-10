<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/9/1
 * Time: 02:25
 */
$this->render('common/header');
?>
<body class="hold-transition skin-blue sidebar-mini">

<style type="text/css">
.main-sidebar {padding-top:0; top:50px; bottom:0; min-height:0; overflow-y:auto;}
</style>
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
							<span id="noteListTitle">回收站</span>
							<small><span id="noteListCount">*</span> 个已删除的笔记</small>
							<i class="fa fa-circle-o-notch fa-spin" id="noteLoading" style="color:#555;display:none;"></i>
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
				<div class="box box-note" id="noteBox" style="display:none;">
					<div class="note-header" id="noteHeader">
						<span></span>
						<small title="最后修改时间"></small>
					</div>
					<div class="note-body">
						<iframe id="contentFrame" src="<?=\vgot\Web\Url::site('note/blank')?>" style="width:100%;height:100%;" frameborder="0" scrolling="auto"></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="<?=STATIC_URL?>js/noteside.js"></script>
	<script src="<?=STATIC_URL?>js/recylebin.js"></script>
	<script type="text/javascript">
	var currentNoteId = 0;
	</script>
</div>

<script type="text/javascript">
var blank = $("#contentFrame");

function setBlankHeight(h) {
}

function setContent(content) {
	if (blank[0].contentWindow.setContent) {
		blank[0].contentWindow.setContent(content);
	} else {
		blank.on("load", function() {
			blank[0].contentWindow.setContent(content);
		});
	}
}
</script>
<?php $this->render('common/footer'); ?>