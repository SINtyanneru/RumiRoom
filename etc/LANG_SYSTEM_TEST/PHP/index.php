<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

include("./LANG_SYSTEM.php");
$LS = new LANG_SYSTEM("");
?>
<!DOCTYPE html>
<HTML>
	<HEAD>
		<TITLE>言語システムのテスト</TITLE>
	</HEAD>
	<BODY>
		<!--
		<A HREF="?LANG=JP_JAP"><BUTTON>標準日本語</BUTTON></A>
		<A HREF="?LANG=US_ENG"><BUTTON>アメリカ英語</BUTTON></A>
		<A HREF="?LANG=RU_RUS"><BUTTON>ロシア語</BUTTON></A>
		-->

		<DIV>
			<H1><?php echo $LS->GET("TITLE") ?></H1>
			<?php echo $LS->GET("TEXT") ?>
		</DIV>
	</BODY>
</HTML>