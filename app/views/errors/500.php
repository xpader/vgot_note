<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/5/1
 * Time: 03:23
 *
 * @var $exception Exception
 */

$this->title = htmlspecialchars($exception->getMessage());
$this->render('common/header', ['bodyClass'=>'sidebar-collapse', 'commonPlugins'=>false]);
?>
<div class="wrapper">

	<div class="content-wrapper">
		<section class="content">

			<div class="error-page">
				<h2 class="headline text-red">500</h2>

				<div class="error-content">
					<h3><i class="fa fa-warning text-red"></i> Oops! Something went wrong.</h3>

					<p>
						We will work on fixing that right away.
						Meanwhile, you may <a href="../../index.html">return to dashboard</a> or try using the search form.
					</p>
				</div>
			</div>

		</section>
		<pre><?php throw $exception; ?></pre>
	</div>

</div>

<script src="<?=STATIC_URL?>lib/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
