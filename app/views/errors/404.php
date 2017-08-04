<?php
$this->title = '404 Page not found';
$this->render('common/header');
?>
<body class="hold-transition skin-blue sidebar-collapse">
<div class="wrapper">
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Main content -->
		<section class="content">
			<div class="error-page">
				<h2 class="headline text-yellow"> 404</h2>
				<div class="error-content" style="padding-top:15px;">
					<h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
					<p>
						We could not find the page you were looking for.
						Meanwhile, you may <a href="/">return to home</a> or try using the search form.
					</p>
				</div>
				<!-- /.error-content -->
			</div>
			<!-- /.error-page -->
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- Bootstrap 3.3.7 -->
<script src="<?=STATIC_URL?>lib/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
