<?php
$path = str_replace(str_replace($_SERVER["DOCUMENT_ROOT"], "", __DIR__), "", parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
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
			$bgm = "/Asset/bgm.mp3";
			if (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE") !== false || strpos($_SERVER["HTTP_USER_AGENT"], "Trident") !== false) {
				//IE
				echo "<BGSOUND LOOP=\"infinite\" SRC=\"".$bgm."\">";
			} else {
				//それ以外
				?>
				<SCRIPT>
					window.addEventListener("load", (E)=>{
						let BGSOUND = document.createElement("AUDIO");
						BGSOUND.src = "<?=$bgm?>";
						BGSOUND.autoplay = true;
						BGSOUND.loop = true;
						document.body.appendChild(BGSOUND);
					});
				</SCRIPT>
				<?php
			}
		?>

		<?php
			require(__DIR__."/../OGP.php");
			ogp("るみさんのお部屋", $title, "八木瑠海伸梧の個人サイト");
		?>
	</HEAD>

	<FRAMESET ROWS="100,*">
		<FRAME SRC="/header.html" NAME="HEADER" noresize>
		<FRAMESET COLS="200,*">
			<FRAME SRC="/menu.php?P=<?php echo $path ?>" NAME="MENU" noresize>
			<FRAME SRC="/main.php?P=<?php echo $path ?>&R=<?=htmlspecialchars(json_encode($_GET))?>" NAME="MAIN" noresize>
		</FRAMESET>
	</FRAMESET>
</HTML>
<!--FRAMESETは非推奨？知らねえな-->