<?php
/**
 * @var $this \vgot\Core\View
 * @var $bodyClass string
 * @var $commonPlugins bool
 */
use vgot\Web\Url;

$app = getApp();

if (!isset($bodyClass)) {
	$bodyClass = 'skin-blue sidebar-mini';
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?=$this->title ? $this->title : $app->config->get('site_name')?></title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="<?=STATIC_URL?>lib/bootstrap/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?=STATIC_URL?>lib/font-awesome/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="<?=STATIC_URL?>lib/Ionicons/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?=STATIC_URL?>lib/alte/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
	 folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="<?=STATIC_URL?>lib/alte/css/skins/skin-blue.min.css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="<?=STATIC_URL?>lib/jquery.min.js"></script>
<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<?php if (!isset($commonPlugins) || $commonPlugins !== false) { ?>
<link rel="stylesheet" href="<?=STATIC_URL?>lib/pace/pace.css">
<script src="<?=STATIC_URL?>lib/pace/pace.min.js"></script>
<script src="<?=STATIC_URL?>lib/sweetalert2/sweetalert2.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=STATIC_URL?>lib/sweetalert2/sweetalert2.min.css">
<?php } ?>
<script type="text/javascript">
var BASE_URL = "<?=Url::base()?>";
</script>
</head>
<body class="hold-transition <?=$bodyClass?>">
