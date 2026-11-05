<?php
require(__DIR__."/const.php");

$path = str_replace(str_replace($_SERVER["DOCUMENT_ROOT"], "", __DIR__), "", urldecode(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH)));
$title = "";

$site_list = json_decode(file_get_contents(__DIR__."/site.json"), true);
foreach ($site_list as $site) {
	if ($site["URL"] == $path) {
		$title = $site["TITLE"];
	}
}

//↓Tor
header("onion-location: http://rumi32qpqupmml55krw75ue522lxhei2g2gmq2ktyzvlb6os3vd4beqd.onion/");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<HTML>
	<HEAD>
		<TITLE><?=$title?></TITLE>

		<META NAME="theme-color" CONTENT="#00A3AF">
		<LINK REL="me" HREF="https://eth.rumiserver.com/@rumisan">

		<!--BASEURL-->
		<!--<BASE HREF="http://rumi-room.net/">-->
		<!--			↑HTTPSからHTTPにつながらないクソ仕様-->

		<!--BGM-->
		<?php
			$bgm_enable = true;
			$bgm_volume = 0.5;

			if (empty($_COOKIE[BGM_SETTING_COOKIE]) == false) {
				$setting = json_decode($_COOKIE[BGM_SETTING_COOKIE], true);
				$bgm_enable = $setting["ENABLE"];
				$bgm_volume = $setting["VOLUME"];
			}

			if ($bgm_enable) {
				$bgm = "/bgm_get.php?a=".uniqid();

				if (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE") !== false || strpos($_SERVER["HTTP_USER_AGENT"], "Trident") !== false) {
					//IE
					echo "<BGSOUND LOOP=\"infinite\" SRC=\"".$bgm."\">";
				} else {
					//それ以外
					?>
					<SCRIPT>
						window.addEventListener("load", (E)=>{
							let seek = 0;
							const cookie = document.cookie.split(";");
							for (const c of cookie) {
								const parts = c.split("=");
								const key = parts[0];
								const value = parts[1];
								if (key === "<?=BGM_SEEK_COOKIE?>") {
									seek = Number.parseFloat(value);
								}
							}

							let BGSOUND = document.createElement("AUDIO");
							BGSOUND.src = "<?=$bgm?>";
							BGSOUND.autoplay = true;
							BGSOUND.loop = true;
							BGSOUND.volume = <?=$bgm_volume?>;
							BGSOUND.currentTime = seek;
							document.body.appendChild(BGSOUND);

							BGSOUND.addEventListener("timeupdate", function() {
								document.cookie = `<?=BGM_SEEK_COOKIE?>=${BGSOUND.currentTime}`;
							});
						});
					</SCRIPT>
					<?php
				}
			}
		?>

		<?php
			require(__DIR__."/../OGP.php");
			ogp("るみさんのお部屋", $title, "八木瑠海伸梧の個人サイト");
		?>
	</HEAD>

	<FRAMESET ROWS="110,*">
		<FRAME SRC="/header.php?P=<?php echo $path ?>&R=<?=htmlspecialchars(json_encode($_GET))?>" NAME="HEADER" noresize>
		<FRAMESET COLS="290,*">
			<FRAME SRC="/menu.php?P=<?php echo $path ?>" NAME="MENU" noresize>
			<FRAME SRC="/main.php?P=<?php echo $path ?>&R=<?=htmlspecialchars(json_encode($_GET))?>" NAME="MAIN" noresize>
		</FRAMESET>
		<NOFRAMES>
			<BODY BGCOLOR="#003399" TEXT="#99FF990">
				フレームに対応しているブラウザが必要です。
			</BODY>
		</NOFRAMES>
	</FRAMESET>
</HTML>
<!--FRAMESETは非推奨？知らねえな-->