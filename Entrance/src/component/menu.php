<?php
require_once(__DIR__."/../page.php");
require_once(__DIR__."/../path.php");
?>
<TABLE>
	<?php
	foreach (page_get_list() as $page) {
		if ($page->show_menu == false) continue;

		$icon_url = "/Asset/Haiku/png/32x32/App_Generic.png";
		if ($page->menu_icon != null) $icon_url = "/Asset/Haiku/png/32x32/".$page->menu_icon.".png";
		?>
		<TR>
			<TD><?php if ($page->url == $cur_path) echo htmlspecialchars(">"); ?></TD>
			<TD><A HREF="<?=htmlspecialchars($page->url)?>"><IMG SRC="<?=htmlspecialchars($icon_url)?>" ALT="<?=htmlspecialchars($page->title)?>"></A></TD>
			<TD><A HREF="<?=htmlspecialchars($page->url)?>"><?=htmlspecialchars($page->title)?></A></TD>
		</TR>
		<?php
	}
	?>
</TABLE>

<HR>

<DIV>
	<A HREF="https://httpd.apache.org/" TITLE="Apache HTTP Server Project">
		<IMG SRC="/icons/apache_pb.png" ALT="Powerd by APACHE" STYLE="background-color: white; width: 100%">
	</A>
	<A HREF="http://www.videolan.org/vlc" TITLE="VLCメディアプレイヤーをゲット！ - 再生もストリーミングもこなし、WMPを圧倒する！">
		<IMG SRC="/Asset/menu_bannar/getvlcnow.png" HEIGHT="32" ALT="VLCをゲット" />
	</A>
</DIV>

<HR>

<DIV>
	<?php
		$forwarded = $_SERVER["HTTP_FORWARDED"];
		$url = "http://mpd.rumi-room.net/winamp.png";
		if (str_contains($forwarded, "https")) {
			$url = "https://mpd.rumi-room.net/winamp.png";
		}
	?>
	るみが今聞いてる曲↓<BR>
	<IFRAME SRC="<?=$url?>" TITLE="Winamp風MPDスクショ" CLASS="MPD_STATUS"></IFRAME>
</DIV>

<HR>

<DIV CLASS="FOOTER">
	ｱｲｺﾝ素材の多くは<A HREF="https://github.com/haiku/haiku/tree/master/data/artwork">HaikuOSﾌﾟﾛｼﾞｪｸﾄ</A>から拝借しています。<BR>
	<A HREF="https://github.com/darealshinji/haiku-icons">HaikuOSﾌﾟﾛｼﾞｪｸﾄのｱｲｺﾝをPNG化した物</A>を使用しています。<BR>
	「/」に置いてあるｷｬﾗｸﾀｰはﾄﾘｯｶﾙから拝借しています。<BR>
	背景素材は弊サイト運営者の自作です。<BR>
	©2020 rumi-room.net<BR>
</DIV>