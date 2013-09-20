<?php
require_once(DOCUMENT_ROOT."lib/web/web_user_login.php");
?>

<div>

<!--<a href='#' class='btn dropdown-toggle' data-toggle='dropdown'>XX <span class='caret'></span></a>
<ul class='dropdown-menu'>
<li class='nav-header'>帳號資訊</li>"
<li class='nav-list'>帳號資訊</li>"
</ul>-->

<?php
	if(web_isLogged()) {
		echo "<a href='#' class='btn dropdown-toggle' data-toggle='dropdown'>".web_getLoggedUser()->getNickName()." <span class='caret'></span></a>";
		echo "<ul class='dropdown-menu'>";
			echo "<li class='nav-header'>帳號資訊</li>";
			echo "<li class='nav-list'>帳號名稱: ".web_getLoggedUser()->getUsername()."</li>";
			echo "<li class='nav-list'>所在群組: ".web_getLoggedUser()->getGroup()."</li>";
			echo "<li class='nav-list'>登入時間: ".web_getLoggedUser()->getLoginTime()."</li>";
			echo "<li class='divider'></li>";
			echo "<li><a href='#'><i class='icon-off'></i> 登出</a></li>";
		echo "</ul>";
	}
	else {
		echo "<a href='".SITE_URL_ROOT."login.php' class='btn'>登入/帳號</a>";
	}
?>


</div>