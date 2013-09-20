<?php
require_once(DOCUMENT_ROOT."lib/web/web_user_login.php");
?>

<div>

<?php
	if(web_isLogged()) {
		echo "logged";
	}
	else {
		echo "<a href='".SITE_URL_ROOT."login.php' class='btn'>登入/帳號</a>";
	}
?>


</div>