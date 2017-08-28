<html lang="zh-cn">
<head>
<link rel="stylesheet" href="<?=STATIC_URL?>/lib/font-awesome/css/font-awesome.min.css">
<link type="text/css" rel="stylesheet" href="<?=STATIC_URL?>lib/ckeditor/contents.css?t=H7HD">
<link type="text/css" rel="stylesheet" href="<?=STATIC_URL?>lib/ckeditor/plugins/tableselection/styles/tableselection.css">
<link type="text/css" rel="stylesheet" href="<?=STATIC_URL?>lib/ckeditor/plugins/codesnippet/lib/highlight/styles/default.css">
<script type="text/javascript">
var lastHeight = 0, htimer = null;

function setContent(content) {
	document.getElementById("blankContentWrapper").innerHTML = content;
	autoHeight();

	if (htimer == null) {
		htimer = setInterval(autoHeight, 1000);
	}
}

function autoHeight() {
	var h = document.getElementById("blankContentWrapper").offsetHeight + 35;
	if (h != lastHeight && window.top.setBlankHeight) {
		window.top.setBlankHeight(h);
		lastHeight = h;
	}
}

window.onresize = autoHeight;
</script>
<base target="_blank" />
</head>
<body class="cke_editable cke_editable_themed cke_contents_ltr">
<div id="blankContentWrapper">
	<i class="fa fa-refresh fa-spin" style="color:#CCC;font-size:50px;position:absolute;left:50%;margin-left:-25px;top:50%;margin-top:-25px;"></i>
</div>
</body>
</html>