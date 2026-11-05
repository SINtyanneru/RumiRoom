<?php
require(__DIR__."/const.php");
require(__DIR__."/bgm.php");

$p = htmlspecialchars(isset($_GET["P"]) ? $_GET["P"] : "");
$r = htmlspecialchars(isset($_GET["R"]) ? $_GET["R"] : "");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
	<HEAD>
		<TITLE>ヘッダー</TITLE>
	</HEAD>
	<BODY BACKGROUND="/Asset/Entrance_Bg.png">
		<MARQUEE BEHAVIOR="alternate">
			<A HREF="/" TARGET="_parent"><IMG SRC="/Asset/logo.gif"></A>
		</MARQUEE>
		<BR>
		SINCE 2020
		<DIV>
			<A HREF="/bgm_seting.php?m=onoff&p=<?=$p?>&r=<?=$r?>" TARGET="_parent"><BUTTON>BGM ON/OFF</BUTTON></A>
			<A HREF="/bgm_seting.php?m=up&p=<?=$p?>&r=<?=$r?>" TARGET="_parent"><BUTTON>音量を上げる</BUTTON></A>
			<A HREF="/bgm_seting.php?m=down&p=<?=$p?>&r=<?=$r?>" TARGET="_parent"><BUTTON>音量を下げる</BUTTON></A>
			<A HREF="/bgm_seting.php?m=change&p=<?=$p?>&r=<?=$r?>" TARGET="_parent"><BUTTON>BGMを変える</BUTTON></A>
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
		</DIV>
	</BODY>
</HTML>