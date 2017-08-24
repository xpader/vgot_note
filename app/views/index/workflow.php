<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/8/9
 * Time: 02:09
 */
$this->render('common/header');
?>
<body class="hold-transition skin-blue sidebar-mini">
<style type="text/css">
.box-note, .box-info {border-top:none; border-radius:0;}
.box-info {border-bottom:none; border-top:none; margin:0;}
.note-list {padding-right:0; background-color:#F7F7F7; border-right:1px solid #eaeaea;}
.note-list, .box-note, .box-info,.editor-init {min-height:100%;}
.editor-icon {font-size:120px; color:#AAA; position:absolute; left:50%; top:50%; margin-left:-60px; margin-top:-60px;}
.box-note {border:none; min-height:100%; margin:0;}
.note-header {position:relative;}
.note-header small {position:absolute; right:10px; top:8px; color:#b3b3b3;}
.note-header .form-control {border:none;}
.note-body {}
.cke_reset {border-left:none; border-right:none; border-bottom:none;}
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
							<span id="noteListTitle">我的笔记</span>
							<small><span id="noteListCount">*</span> 个笔记</small>
							<i class="fa fa-refresh fa-spin" id="noteLoading" style="color:#555;"></i>
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
	<!-- CK Editor -->
	<script src="<?=STATIC_URL?>lib/ckeditor/ckeditor.js"></script>
	<script src="<?=STATIC_URL?>js/workflow.js"></script>
	<script type="text/javascript">
	var currentCateId = 1, currentNoteId = 0;

	$(function() {
		var noteList = $("#noteList");

		showCategoryFolders();

		noteList.on("click", "a", function() {
			var id = $(this).data("id");
			var nav = $(this).parent("li");

			if (nav.is(".active")) {
				return;
			}

			noteList.find(">.active").removeClass("active");
			nav.addClass("active");
			loadNote(id);
		});
	});
	</script>
	<?php //$this->render('common/bottom'); ?>
</div>
<!-- ./wrapper -->

<!-- Bootstrap 3.3.7 -->
<script src="<?=STATIC_URL?>lib/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=STATIC_URL?>lib/alte/js/adminlte.min.js"></script>
</body>
</html>
