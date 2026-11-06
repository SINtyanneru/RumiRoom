<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once(__DIR__."/../env.php");

$stmt = $sql->prepare("SELECT * FROM `RCK_ARTICLE` WHERE `ID` = :id");
$stmt->bindValue(":id", $_GET["RCK"], PDO::PARAM_STR);
$stmt->execute();
$article = $stmt->fetch();

if ($article == false) {
	http_response_code(404);
	echo "ありません。";
	header("Content-Type: text/plain; charset=UTF-8");
	exit;
}

$stmt = $sql->prepare("SELECT * FROM `RCK_VERSION` WHERE `ID` = :id");
$stmt->bindValue(":id", $_GET["V"], PDO::PARAM_STR);
$stmt->execute();
$verson = $stmt->fetch();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML LANG="ja-jp">
	<HEAD>
		<TITLE>RCK</TITLE>

		<LINK REL="stylesheet" HREF="Style/RST_Adomonition.css">
		<LINK REL="stylesheet" HREF="Style/RST_Codeblock.css">
		<LINK REL="stylesheet" HREF="Style/RST_Inlinecode.css">
		<LINK REL="stylesheet" HREF="Style/RST_Texteffect.css">
	</HEAD>
	<BODY>
		<A HREF="https://rumi-room.net/"><IMG SRC="/Asset/Haiku/png/32x32/Action_GoHome_2.png" ALT="ホームに戻る"></A>
		<A HREF="/"><IMG SRC="/Asset/Haiku/png/32x32/Action_GoBack_1.png" ALT="トップに戻る"></A>
		<HR>
		<H1 STYLE="text-align: center;">RCK-<?=htmlspecialchars($article["ID"])?>-<?=htmlspecialchars($verson["VERSION"])?> 「<?=htmlspecialchars($article["TITLE"])?>」</H1>
		<DIV STYLE="text-align: right;">作成日時: <?=$verson["CREATE_AT"]?></DIV>
		<DIV STYLE="text-align: right;"><A HREF="version.php?RCK=<?=htmlspecialchars($article["ID"])?>">バージョン一覧</A></DIV>
		<DIV STYLE="text-align: right;"><A HREF="view.php?RCK=<?=htmlspecialchars($article["ID"])?>&V=<?=htmlspecialchars($verson["ID"])?>">ビュワー</A></DIV>
		<HR>
		<?=nl2br(htmlspecialchars($verson["TEXT"]))?>
	</BODY>
</HTML>