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
			<A HREF="/bgm_seting.php?m=onoff&p=<?=htmlspecialchars($_GET["P"])?>&r=<?=htmlspecialchars($_GET["R"])?>" TARGET="_parent"><BUTTON>BGM ON/OFF</BUTTON></A>
			<A HREF="/bgm_seting.php?m=up&p=<?=htmlspecialchars($_GET["P"])?>&r=<?=htmlspecialchars($_GET["R"])?>" TARGET="_parent"><BUTTON>音量を上げる</BUTTON></A>
			<A HREF="/bgm_seting.php?m=down&p=<?=htmlspecialchars($_GET["P"])?>&r=<?=htmlspecialchars($_GET["R"])?>" TARGET="_parent"><BUTTON>音量を下げる</BUTTON></A>
			<?php
				require(__DIR__."/const.php");

				//曲名表示
				if (isset($_COOKIE[BGM_CHOISE_COOKIE])) {
					$toc = json_decode(file_get_contents(__DIR__."/bgm/toc.json"), true);
					foreach ($toc as $track) {
						if ($_COOKIE[BGM_CHOISE_COOKIE] == $track["ID"]) {
							echo "[".htmlspecialchars($track["NAME"])."]";
							break;
						}
					}
				}

				//音量表示
				$setting = json_decode($_COOKIE[BGM_SETTING_COOKIE], true);
				$bgm_volume = $setting["VOLUME"];
				echo "[".htmlspecialchars(($bgm_volume * 100)."%")."]";
			?>
		</DIV>
	</BODY>
</HTML>