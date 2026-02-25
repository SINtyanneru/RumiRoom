<!DOCTYPE html>
<HTML>
	<HEAD>
		<TITLE>UA</TITLE>
		<?php
		include("http://cdn.rumia.me/LIB/OGP.php?V=LATEST");

		$OGP = new OGP_PHP();
		$OGP->SET_PAGENAME("ユーザーエージェント");
		$OGP->SET_TITLE("UA");
		$OGP->SET_DESC($_SERVER["HTTP_USER_AGENT"]);
		$OGP->BUILD();
		?>
	</HEAD>
	<BODY>
		<?=htmlspecialchars($_SERVER["HTTP_USER_AGENT"])?>
	</BODY>
</HTML>