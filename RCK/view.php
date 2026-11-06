<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once(__DIR__."/../env.php");
require_once(__DIR__."/../lib/RST/rst.php");
require_once(__DIR__."/../lib/SizeiB/convert_byte.php");

$rst = new RST();

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

$rck_id = $article["ID"];
$title = $article["TITLE"];
$version_id = $verson["ID"];
$version_name = $verson["VERSION"];

$rst_text = $verson["TEXT"];
$rhf = $verson["RHF"];

if ($rhf != null) {
	$rhf_line_list = preg_split("/\R/u", $rhf);
	$rst_line_list = preg_split("/\R/u", $rst_text);

	foreach ($rhf_line_list as $rhf_line) {
		$parsed = rhf_line_parse($rhf_line);
		if ($parsed == null) continue;
		$line_number = $parsed[0] - 1;
		$target = $parsed[1];
		$rubi = $parsed[2];

		//指定された行はあるか？
		if (empty($rst_line_list[$line_number])) continue;

		$rst_line_list[$line_number] = str_replace($target, "\u{E000}".$target."\u{E001}".$rubi."\u{E002}", $rst_line_list[$line_number]);
	}

	$rst_text = join("\n", $rst_line_list);
}

$html = $rst->to_html($rst_text);

if ($rhf != null) {
	$html_line_list = preg_split("/\R/u", $html);

	for ($i = 0; $i < count($html_line_list) ; $i ++) { 
		$line = $html_line_list[$i];
		$replace = preg_replace('/\x{E000}(.+?)\x{E001}(.+?)\x{E002}/u', '<RUBY>$1<RT>$2</RT></RUBY>', $line);
		$html_line_list[$i] = $replace;
	}

	$html = join("\n", $html_line_list);
}

function rhf_line_parse(string $line): array|null {
	$q = '"((?:[^"\\\\]|\\\\.)*)"';
	$re = '/^(\d+):' . $q . '=' . $q . '$/su';

	if (!preg_match($re, $line, $m)) {
		return null;
	}

	//\" や \\ をエスケープ解除
	$un = fn(string $s): string => preg_replace('/\\\\(.)/su', '$1', $s);

	return [
		(int)$m[1],
		$un($m[2]),
		$un($m[3]),
	];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML LANG="ja-jp">
	<HEAD>
		<TITLE>RCK</TITLE>

		<LINK REL="stylesheet" HREF="Style/RST_Adomonition.css">
		<LINK REL="stylesheet" HREF="Style/RST_Codeblock.css">
		<LINK REL="stylesheet" HREF="Style/RST_Inlinecode.css">
		<LINK REL="stylesheet" HREF="Style/RST_Texteffect.css">
		<LINK REL="stylesheet" HREF="Style/RST_Reference.css">
	</HEAD>
	<BODY>
		<A HREF="https://rumi-room.net/"><IMG SRC="/Asset/Haiku/png/32x32/Action_GoHome_2.png" ALT="ホームに戻る"></A>
		<A HREF="/"><IMG SRC="/Asset/Haiku/png/32x32/Action_GoBack_1.png" ALT="トップに戻る"></A>
		<HR>
		<H1 STYLE="text-align: center;">RCK-<?=htmlspecialchars($rck_id)?>-<?=htmlspecialchars($version_name)?> 「<?=htmlspecialchars($title)?>」</H1>
		<DIV STYLE="text-align: right;">作成日時: <?=$verson["CREATE_AT"]?></DIV>
		<DIV STYLE="text-align: right;"><A HREF="version.php?RCK=<?=htmlspecialchars($rck_id)?>">バージョン一覧</A></DIV>
		<DIV STYLE="text-align: right;"><A HREF="source.php?RCK=<?=htmlspecialchars($rck_id)?>&V=<?=htmlspecialchars($version_id)?>">ソース</A></DIV>
		<?php
			echo $html;
		?>
		<HR>
	</BODY>
</HTML>