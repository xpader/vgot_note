<?php
use vgot\Web\Url;
$controller = getApp()->input->uri('controller');
?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar note-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- search form -->
		<form action="#" method="get" class="sidebar-form">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="Search...">
				<span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
			</div>
		</form>
		<!-- /.search form -->
		<div style="text-align:center;padding:5px 0 15px;">
			<div class="btn-group">
				<button type="button" class="btn btn-primary" id="newCate"><i class="fa fa-folder-o"></i> 新建分类</button>
				<button type="button" class="btn btn-primary" id="newNote"><i class="fa fa-edit"></i> 新建笔记</button>
			</div>
		</div>
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header" id="categoryFolders">笔记目录</li>

			<div id="folderLoading" style="padding:10px 0;text-align:center;">
				<i class="fa fa-refresh fa-spin" style="color:#FFF;"></i>
			</div>

			<li class="header">其它</li>
			<li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
			<li><a href="#"><i class="fa  fa-share-alt text-yellow"></i> <span>我的分享</span></a></li>
			<li<?php if ($controller == '\app\controllers\RecylebinController') {?> class="active"<?php } ?>><a href="<?=Url::site('recylebin')?>"><i class="glyphicon glyphicon-trash"></i> <span>回收站</span></a></li>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>