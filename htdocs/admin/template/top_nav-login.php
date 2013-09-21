<?php
require_once(DOCUMENT_ROOT."lib/web/web_user_login.php");
?>

<ul class="nav pull-right">
	<li class="dropdown">
	<?php
	if(web_isLogged()) {
		echo "<a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='icon-user'></i> ".web_getLoggedUser()->getName()." <span class='caret'></span></a>";
		echo "<ul class='dropdown-menu'>";
			echo "<li class='nav-header'>帳號資訊</li>";
			echo "<li class='nav-list'><i class='icon-user'></i> 帳號名稱: ".web_getLoggedUser()->getUsername()."</li>";
			echo "<li class='nav-list'><i class='icon-group'></i> 所在群組: ".web_getLoggedUser()->getGroupName()."</li>";
			echo "<li class='nav-list'><i class='icon-time'></i> 登入時間: ".web_getLoggedUser()->getLoginTime()."</li>";
			echo "<li class='divider'></li>";
			echo "<li><a href='#'><i class='icon-cog'></i> 帳號設定</a></li>";
			echo "<li><a href='".SITE_URL_ROOT."action/login.php?action=logout'><i class='icon-signout'></i> 登出</a></li>";
		echo "</ul>";
	}
	else {
		echo "<a href='".SITE_URL_ROOT."login.php'>登入/帳號</a>";
	}
	?>
	</li>
</ul>