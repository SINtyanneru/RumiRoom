<?php
require_once(__DIR__."/../const.php");
require_once(__DIR__."/../bgm.php");
require_once(__DIR__."/../path.php");
date_default_timezone_set("Asia/Tokyo");

$r = $_SERVER["QUERY_STRING"];
?>
<MARQUEE BEHAVIOR="alternate">
	<A HREF="/main.php"><IMG SRC="/Asset/logo.gif" ALT="るみさんのお部屋"></A>
</MARQUEE>
<BR>
SINCE 2020 <?php
if (date("n-j") == "1-1") {
	echo " - あけおめことよろ";
} else if (date("n-j") == "12-25") {
	echo " - メリクリ";
} else if (date("n-j") == "10-29") {
	echo " - 今日は誕生日です";
}
?>
<HR>

<A HREF="/bgm_seting.php?m=onoff&p=<?=$cur_path?>&r=<?=$r?>"><BUTTON>BGM ON/OFF</BUTTON></A>
<A HREF="/bgm_seting.php?m=up&p=<?=$cur_path?>&r=<?=$r?>"><BUTTON>音量を上げる</BUTTON></A>
<A HREF="/bgm_seting.php?m=down&p=<?=$cur_path?>&r=<?=$r?>"><BUTTON>音量を下げる</BUTTON></A>
<A HREF="/bgm_seting.php?m=change&p=<?=$cur_path?>&r=<?=$r?>"><BUTTON>BGMを変える</BUTTON></A>
<?php
//曲名表示
$now_id = bgm_get_id();
$toc = bgm_load_toc();
foreach ($toc as $track) {
	if ((string)$track["ID"] === $now_id) {
		echo "[".htmlspecialchars($track["ARTIST"])." - ".htmlspecialchars($track["TITLE"])."]";
		break;
	}
}

//音量表示
$setting = ["VOLUME" => 0.5];
if (!empty($_COOKIE[BGM_SETTING_COOKIE])) {
	$tmp = json_decode($_COOKIE[BGM_SETTING_COOKIE], true);
	if (is_array($tmp) && isset($tmp["VOLUME"])) {
		$setting = $tmp;
	}
}
echo "[".htmlspecialchars((round($setting["VOLUME"] * 100))."%")."]";
?>