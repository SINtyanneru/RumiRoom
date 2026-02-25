<?php
//いんくるーど
require("../../env.php");
require("../../session_login.php");

if ($login == false) {
	header("Location:./LOGIN/");
	exit;
}
?>
<!DOCTYPE html>
<HTML>
	<HEAD>
		<TITLE>記事の新規作成</TITLE>
	</HEAD>
	<BODY>
		<H1>記事の新規作成</H1>
		<HR>
		<FORM METHOD="POST" ACTION="./CREATE.php">
			<INPUT TYPE="text" NAME="TITLE" PLACEHOLDER="タイトル">
			<INPUT TYPE="text" NAME="TAG" PLACEHOLDER="タグ(/で区切る)">
			<BUTTON TYPE="submit">作成</BUTTON>
		</FORM>
	</BODY>
</HTML>