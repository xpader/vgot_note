<?php
use vgot\Web\Url;

$this->title = 'Login';
$this->render('common/header');
?>
<body class="hold-transition login-page">
<div class="login-box">
	<div class="login-logo">
		<a href="#"><b>Vgot</b>NOTE</a>
	</div>
	<!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg">Sign in to start your session</p>

		<form action="#" method="post">
			<div class="form-group has-feedback">
				<input type="text" name="username" class="form-control" placeholder="Username">
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<input type="password" name="password" class="form-control" placeholder="Password">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="row">
				<div class="col-xs-8">
					<div class="checkbox icheck">
						<label>
							<input type="checkbox"> Remember Me
						</label>
					</div>
				</div>
				<!-- /.col -->
				<div class="col-xs-4">
					<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
				</div>
				<!-- /.col -->
			</div>
		</form>

		<a href="#">I forgot my password</a><br>
		<a href="register.html" class="text-center">Register a new membership</a>

	</div>
	<!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- Bootstrap 3.3.7 -->
<script src="<?=STATIC_URL?>lib/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?=STATIC_URL?>lib/iCheck/icheck.min.js"></script>
<script>
$(function () {
	$('input').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
		increaseArea: '20%' // optional
	});

	$(document.forms[0]).submit(function() {
		var username = this.username.value;
		var password = this.password.value;
		$.post("<?=Url::site('index/login-post')?>", $(this).serialize(), function(res) {
			if (res.status) {
				location.href = "<?=Url::base()?>";
			} else {
				alert(res.msg);
			}
		});

		return false;
	});
});
</script>
</body>
</html>

