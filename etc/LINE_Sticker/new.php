<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
require("https://cdn.rumia.me/LIB/SQL.php?V=LATEST");
require("http://plain-cdn.rumia.me/LIB/OGP.php?V=LATEST");

$id = null;
$nama = false;
$thumbnail = false;

if (!isset($_GET["ID"])) {
	http_response_code(410);
	return;
}

//値をセット
$id = $_GET["ID"];
if (isset($_GET["nama"])) {
	if ($_GET["nama"] == "true") {
		$nama = true;
	}
}
if (isset($_GET["thumbnail"])) {
	if ($_GET["thumbnail"] == "true") {
		$thumbnail = true;
	}
}

//SQL
$pdo = new PDO(
	"mysql:host=192.168.0.130;dbname=rumisan_room;",
	"rumi_room",
	"aqaz12345569apapapa14463229",
	[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
);

$result = SQL_RUN($pdo,
	"SELECT
		IMG.*,
		STAMP.LINE_ID,
		STAMP.TITLE,
		STAMP.SALE,
		CREATOR.NAME AS CREATOR_NAME
	FROM
		`LINESTAMP_IMAGE` AS IMG
	JOIN
		`LINESTAMP_STAMP` AS STAMP
		ON STAMP.ID = IMG.STAMP
	JOIN
		`LINESTAMP_CREATOR` AS CREATOR
		ON CREATOR.ID = STAMP.CREATOR
	WHERE
		IMG.ID = :ID;
	",[["KEY" => "ID", "VAL" => $id]]);
if ($result["STATUS"] == false) {
	http_response_code(500);
	exit;
}
if (count($result["RESULT"]) == 0) {
	http_response_code(404);
	exit;
}

$row = $result["RESULT"][0];

if (check_ua() || $nama || $thumbnail) {
	//生画像表示が許可されたモノ
	output_image($row);
} else {
	output_html();
}

function check_ua() {
	$ua = $_SERVER["HTTP_USER_AGENT"];
	switch (strtoupper($ua)) {
		case strtoupper("Mozilla/5.0 (Macintosh; Intel Mac OS X 11.6; rv:92.0) Gecko/20100101 Firefox/92.0"): return true;
		case strtoupper("Mozilla/5.0 (compatible; Discordbot/2.0; +https://discordapp.com)"): return true;
		default: return false;
	}
}

function output_image($data) {
	$file = __DIR__."/Stamp/".$data["ID"];

	if ($data["ANIMATION"] == 1) {
		header("Content-Type: image/gif");
	} else {
		header("Content-Type: image/png");
	}

	echo file_get_contents($file);

	/*if ($data["ANIMATION"] == 1) {
		//アニメーション
		header("Content-Type: image/gif");
		echo file_get_contents($file);
	} else {
		//静止画
		$src = imagecreatefrompng($file);

		//色変換(GIFの仕様)
		imagepalettetotruecolor($src);
		imagetruecolortopalette($src, false, 256);

		header("Content-Type: image/gif");
		imagegif($src);
		imagedestroy($src);
	}*/
}

function output_html() {
	global $id, $row;
	header("Content-Type: text/html");
	?>
	<!DOCTYPE html>
	<HTML>
		<HEAD>
			<TITLE>スタンプ</TITLE>
			<?php
			$OGP = new OGP_PHP();
			$OGP->SET_PAGENAME("LineスタンプをLine以外でも使えるようにするやつ");
			$OGP->SET_TITLE("");
			$OGP->SET_DESC("使用しているスタンプは全て購入したものです");
			$OGP->SET_IMAGE("https://rumi-room.net/etc/LINE_Sticker/thmbnail?ID=".$id."&nama=true");
			$OGP->BUILD();
			?>
		</HEAD>
		<BODY>
			<DIV>タイトル：<?=htmlspecialchars($row["TITLE"])?></DIV>
			<DIV>ﾊﾟｹｰｼﾞの作成者：<?=htmlspecialchars($row["CREATOR_NAME"])?></DIV>
			<DIV>名：<?=htmlspecialchars($row["NAME"])?></DIV>
			<?php
			if ($row["SALE"] == 1) {
				?>
				<DIV><A HREF="https://store.line.me/stickershop/product/<?=htmlspecialchars($row["LINE_ID"])?>/ja">販売URL</A></DIV>
				<?php
			}
			?>

			<IMG SRC="<?="https://rumi-room.net/etc/LINE_Sticker/thmbnail?ID=".$id."&nama=true"?>" STYLE="pointer-events: none;">

			<DIV STYLE="color: red;">※コピーガードを技術的に回避しようとすると捕まるので、頑張って画像をDLしようとするなよ※</DIV>
		</BODY>
	</HTML>
	<?php
}