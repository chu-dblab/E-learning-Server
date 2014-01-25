<!-- 最上方導覽列 -->
<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<!-- 手機版 更多按鈕的按鈕 -->
			<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<!-- End- 手機版 更多按鈕的按鈕 -->
			
			<!-- 導覽列最左方標題 -->
			<a class="brand" href="<?php echo SITE_URL_ROOT ?>"><?php echo SITE_NAME_REFERRED ?></a>
			
			<div class="nav-collapse collapse">
			
				<!-- 導覽列右側 -->
				<div class="navbar-text pull-right">
					<?php template_admin_top_nav_login() ?>
				</div>
				
				<!-- 導覽列導覽連結 -->
				<ul class="nav">
					<li class="active"><a href="<?php echo SITE_URL_ROOT ?>admin/index.php">後台管理</a></li>
					<!-- <li><a href="#about">關於</a></li> -->
				</ul>
				
				
			</div><!--/.nav-collapse -->
		</div>
	</div>
</div>
<!-- End- 最上方導覽列 --> 
