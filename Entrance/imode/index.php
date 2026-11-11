<?php
require_once(__DIR__."/../src/device_check.php");

$page = "";
$body = "";
if (isset($_GET["p"])) $page = $_GET["p"];

ob_start();
switch ($page) {
	case "profile": {
		if (is_smartphone() == false) {
			header("Location: /profile.html", true, 302);
			exit;
		}

		?>
		名前: 八木 瑠海 伸梧<BR>
		年齢: 今の西暦 - 2007 =<BR>
		その他の情報はPCで見てください。
		<?php
		break;
	}

	case "you": {
		if (is_smartphone() == false) {
			header("Location: /ÉG ER ALLTAF AÐ FYLGJAST MEÐ ÞÉR", true, 302);
			exit;
		}

		require(__DIR__."/../page/you_info.php");
		break;
	}

	default: {
		if (is_smartphone() == false) {
			header("Location: /main.php", true, 302);
			exit;
		}

		?>
		<A HREF="?p=profile">わたしについて</A><BR>
		<A HREF="?p=you">おまえについて</A><BR>
		<?php
		break;
	}
}
$body = ob_get_clean();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML LANG="ja-jp">
	<HEAD>
		<TITLE>るみさんのお部屋 For iﾓｰﾄﾞ</TITLE>

		<META NAME="viewport" CONTENT="width=device-width, initial-scale=1">
		<META NAME="theme-color" CONTENT="#DBFFF3">

		<STYLE>
			body{
				background-color: #DBFFF3;
			}
		</STYLE>
	</HEAD>
	<BODY>
		<H1>るみさんのお部屋<BR>For iﾓｰﾄﾞ</H1>
		iﾓｰﾄﾞ向けの簡易ﾍﾟｰｼﾞです。<BR>
		<HR>

		<?=$body?>

		<HR>
		(C) 2026 rumi-room.net
	</BODY>
</HTML>