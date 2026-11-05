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
			[<?php
				require(__DIR__."/const.php");
				$setting = json_decode($_COOKIE[BGM_SETTING_COOKIE], true);
				$bgm_volume = $setting["VOLUME"];
				echo ($bgm_volume * 100)."%";
			?>]
		</DIV>
	</BODY>
</HTML>