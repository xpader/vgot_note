<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/8/9
 * Time: 02:09
 */
$this->title = 'VgotNOTE';
$this->render('common/header');
?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	<?php $this->render('common/top'); ?>
	<?php $this->render('common/sidebar'); ?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Text Editors
				<small>Advanced form element</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li><a href="#">Forms</a></li>
				<li class="active">Editors</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-header">
							<h3 class="box-title">CK Editor
								<small>Advanced and full of features</small>
							</h3>
							<!-- tools box -->
							<div class="pull-right box-tools">
								<button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip"
								        title="Collapse">
									<i class="fa fa-minus"></i></button>
								<button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
								        title="Remove">
									<i class="fa fa-times"></i></button>
							</div>
							<!-- /. tools -->
						</div>
						<!-- /.box-header -->
						<div class="box-body pad">
							<form>
                    <textarea id="editor1" name="editor1" rows="10" cols="80">
                                            This is my textarea to be replaced with CKEditor.
                    </textarea>
							</form>
						</div>
					</div>
					<!-- /.box -->

					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Bootstrap WYSIHTML5
								<small>Simple and fast</small>
							</h3>
							<!-- tools box -->
							<div class="pull-right box-tools">
								<button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
								        title="Collapse">
									<i class="fa fa-minus"></i></button>
								<button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
								        title="Remove">
									<i class="fa fa-times"></i></button>
							</div>
							<!-- /. tools -->
						</div>
						<!-- /.box-header -->
						<div class="box-body pad">
							<form>
                <textarea class="textarea" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
							</form>
						</div>
					</div>
				</div>
				<!-- /.col-->
			</div>
			<!-- ./row -->
		</section>
		<!-- /.content -->
	</div>

	<?php $this->render('common/bottom'); ?>
</div>
<!-- ./wrapper -->

<!-- Bootstrap 3.3.7 -->
<script src="<?=STATIC_URL?>lib/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=STATIC_URL?>lib/alte/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- CK Editor -->
<script src="../../bower_components/ckeditor/ckeditor.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
$(function () {
	// Replace the <textarea id="editor1"> with a CKEditor
	// instance, using default configuration.
	CKEDITOR.replace('editor1')
	//bootstrap WYSIHTML5 - text editor
	$('.textarea').wysihtml5()
})
</script>
</body>
</html>