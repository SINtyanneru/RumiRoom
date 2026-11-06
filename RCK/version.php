<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once(__DIR__."/../env.php");
require_once(__DIR__."/../lib/SizeiB/convert_byte.php");

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

$stmt = $sql->prepare("SELECT `ID`, `VERSION`, LENGTH(`TEXT`) AS `SIZE` FROM `RCK_VERSION` ORDER BY `CREATE_AT` DESC;");
$stmt->execute();
$verson_list = $stmt->fetchAll();
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
		<H1 STYLE="text-align: center;">RCK-<?=htmlspecialchars($article["ID"])?>-*.*.* 「<?=htmlspecialchars($article["TITLE"])?>」</H1>
		<HR>
		<TABLE>
			<?php
			foreach ($verson_list as $version) {
				?>
				<TR>
					<TD><A HREF="view.php?RCK=<?=htmlspecialchars($article["ID"])?>&V=<?=htmlspecialchars($version["ID"])?>"><?=htmlspecialchars($version["VERSION"])?></A></TD>
					<TD><?=htmlspecialchars(convert_byte($version["SIZE"]))?></TD>
				</TR>
				<?php
			}
			?>
		</TABLE>
	</BODY>
</HTML>