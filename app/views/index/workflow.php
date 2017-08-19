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
<div class="wrapper">

	<?php $this->render('common/top'); ?>
	<?php $this->render('common/sidebar'); ?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<section class="content-header">
			<h1>
				<span id="noteListTitle">我的笔记</span>
				<small>
					<span id="noteListCount">*</span> 个笔记 &nbsp;&nbsp;
					<i class="fa fa-refresh fa-spin" id="noteLoading" style="color:#555;"></i>
				</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Mailbox</li>
			</ol>
		</section>

		<section class="content">
			<div class="row">
				<div class="col-md-3">
					<div class="box box-solid">
						<div class="box-body no-padding">
							<ul class="nav nav-pills nav-stacked" id="noteList"></ul>
						</div>
						<!-- /.box-body -->
					</div>
				</div>
				<div class="col-md-9" style="padding-left:0;">
					<div class="box box-info">
						<form method="post" name="note">
							<div class="box-header">
								<h3 class="box-title" id="noteTitle">
									CK Editor
									<small>Advanced and full of features</small>
								</h3>
							</div>
							<!-- /.box-header -->
							<div class="box-body pad">
								<textarea id="editor1" name="content" rows="10" cols="80">This is my textarea to be replaced with CKEditor.</textarea>
							</div>
							<input type="hidden" name="id">
							<input type="hidden" name="cate_id">
						</form>
					</div>
					<!-- /.box -->
				</div>
			</div>
		</section>
	</div>
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
	<?php $this->render('common/bottom'); ?>
</div>
<!-- ./wrapper -->

<!-- Bootstrap 3.3.7 -->
<script src="<?=STATIC_URL?>lib/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=STATIC_URL?>lib/alte/js/adminlte.min.js"></script>
<!-- CK Editor -->
<script src="<?=STATIC_URL?>lib/ckeditor/ckeditor.js"></script>
<script>
$(function () {
	// Replace the <textarea id="editor1"> with a CKEditor
	// instance, using default configuration.
	CKEDITOR.replace('editor1');
})
</script>
</body>
</html>
