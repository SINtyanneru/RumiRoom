<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
	<HEAD>
		<TITLE>メニュー</TITLE>

		<STYLE>
			.MENU_ITEM{
				text-decoration: none;
				color: black;
			}

			.MENU_ITEM:visited{
				color: black;
			}

			.MENU_ITEM_ICON{
				width: 16px;
				height: auto;
			}

			.FOOTER{
				margin-top: 100px;

				font-size: 10px;
			}
		</STYLE>
	</HEAD>
	<BODY BACKGROUND="/Asset/Entrance_Bg.png">
		<?php
		if (!isset($_GET["P"])) return;
		$site_list = json_decode(file_get_contents(__DIR__."/site.json"), true);
		foreach ($site_list as $site) {
			if (!$site["SHOW_MENU"]) continue;
			$icon_url = "/Asset/Haiku/png/32x32/App_Generic.png";

			if (empty($site["ICON"]) == false) {
				$icon_url = "/Asset/Haiku/png/32x32/".$site["ICON"].".png";
			}

			?>
			<DIV>
				<?php
					if ($site["URL"] == $_GET["P"]) {
						echo htmlspecialchars(">")." <IMG CLASS=\"MENU_ITEM_ICON\" SRC=\"".$icon_url."\">".$site["TITLE"];
					} else {
						?>
						<A HREF="<?=$site["URL"]?>" TARGET="_parent" CLASS="MENU_ITEM">
							<IMG CLASS="MENU_ITEM_ICON" SRC="<?=$icon_url?>">
							<?=$site["TITLE"]?>
						</A>
						<?php
					}
				?>
			</DIV>
			<?php
		}
		?>

		<HR>

		<DIV>
			<A HREF="https://httpd.apache.org/" TARGET="_parent" TITLE="Apache HTTP Server Project">
				<IMG SRC="/icons/apache_pb.png" STYLE="background-color: white; width: 100%">
			</A>
			<A HREF="http://www.videolan.org/vlc" TARGET="_parent" TITLE="VLCメディアプレイヤーをゲット！ - 再生もストリーミングもこなし、WMPを圧倒する！">
				<IMG SRC="/Asset/menu_bannar/getvlcnow.png" HEIGHT="32" ALT="VLCをゲット" />
			</A>
		</DIV>

		<DIV CLASS="FOOTER">
			ｱｲｺﾝ素材の多くは<A HREF="https://github.com/haiku/haiku/tree/master/data/artwork">HaikuOSﾌﾟﾛｼﾞｪｸﾄ</A>から拝借しています。<BR>
			<A HREF="https://github.com/darealshinji/haiku-icons">HaikuOSﾌﾟﾛｼﾞｪｸﾄのｱｲｺﾝをPNG化した物</A>を使用しています。<BR>
			「/」に置いてあるｷｬﾗｸﾀｰはﾄﾘｯｶﾙから拝借しています。<BR>
			背景素材は弊サイト運営者の自作です。<BR>
			©2020 rumi-room.net<BR>
		</DIV>
	</BODY>
</HTML>