<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
	<HEAD>
		<TITLE>メイン</TITLE>
	</HEAD>
	<BODY BACKGROUND="/Asset/Entrance_Bg.png">
		<?php
		if (!isset($_GET["P"])) return;

		$path = null;

		$site_list = json_decode(file_get_contents(__DIR__."/site.json"), true);
		foreach ($site_list as $site) {
			if ($site["URL"] == $_GET["P"]) {
				$path = __DIR__."/src/".$site["PATH"];
				break;
			}
		}

		if ($path != null) {
			require($path);
		} else {
			echo "404";
			http_response_code(404);
		}
		?>
	</BODY>
</HTML>