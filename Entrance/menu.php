<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
	<HEAD>
		<TITLE>メニュー</TITLE>
	</HEAD>
	<BODY BACKGROUND="/Asset/Entrance_Bg.png">
		<?php
		if (!isset($_GET["P"])) return;
		$site_list = json_decode(file_get_contents(__DIR__."/site.json"), true);
		foreach ($site_list as $site) {
			if (!$site["SHOW_MENU"]) continue;
			?>
			<DIV>
				<?php
					if ($site["URL"] == $_GET["P"]) {
						echo htmlspecialchars(">").$site["TITLE"];
					} else {
						?>
						<A HREF="<?=$site["URL"]?>" TARGET="_parent"><?=$site["TITLE"]?></A>
						<?php
					}
				?>
			</DIV>
			<?php
		}
		?>

		<HR>

		<DIV>
			<IMG SRC="/icons/apache_pb.png" STYLE="background-color: white; width: 100%">
		</DIV>
	</BODY>
</HTML>