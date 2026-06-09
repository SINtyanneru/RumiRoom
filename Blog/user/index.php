<?php
require(__DIR__."/session_login.php");
$login = login();
if ($login == false) {
	header("Location: /user/login/");
	exit;
}
?>
作り中