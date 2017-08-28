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
<input type="hidden" id="content" value="<?=htmlspecialchars($note['content'])?>">
<div class="content-wrapper" style="min-height: 1126px;">
	<div class="container">
		<section class="content-header">
			<h1>
				<?=$note['title']?>
				<small><?=$share['name']?> shared at <?=date('Y/n/j', $share['share_time'])?></small>
			</h1>
		</section>

		<section class="content">
			<div class="box">
				<div class="box-body" style="padding:0;">
					<iframe id="contentFrame" src="<?=\vgot\Web\Url::site('note/blank')?>" style="width:100%;height:300px;" frameborder="0" scrolling="auto"></iframe>
				</div>
			</div>
		</section>
	</div>
</div>
<script type="text/javascript">
var blank = $("#contentFrame");

function setBlankHeight(h) {
	blank.height(h+"px");
}

function setContent() {
	blank[0].contentWindow.setContent($("#content").val());
}

if (blank[0].contentWindow.setContent) {
	setContent();
} else {
	blank.on("load", setContent);
}
</script>
<script src="<?=STATIC_URL?>lib/bootstrap/js/bootstrap.min.js"></script>
<script src="<?=STATIC_URL?>lib/alte/js/adminlte.min.js"></script>
</body>
</html>

