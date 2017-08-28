<?php
/**
 * Created by PhpStorm.
 * User: pader
 * Date: 2017/8/27
 * Time: 01:01
 *
 * @var $this \vgot\Core\View
 * @var $share array
 * @var $note array
 */

$this->title = $note['title'];
$this->render('common/header');
?>
<body class="skin-blue sidebar-collapse">

<div class="content-wrapper">
	<div class="container">
		<section class="content-header">
			<h1>
				<?=$note['title']?>
				<small><?=$share['name']?> shared at <?=date('Y/n/j', $share['share_time'])?></small>
			</h1>
		</section>

		<section class="content">
			<div class="box">
				<div class="box-body"><?=$note['content']?></div>
			</div>
		</section>
	</div>
</div>

<script src="<?=STATIC_URL?>lib/bootstrap/js/bootstrap.min.js"></script>
<script src="<?=STATIC_URL?>lib/alte/js/adminlte.min.js"></script>
</body>
</html>

