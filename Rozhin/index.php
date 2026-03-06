<?php
require(__DIR__."/../env.php");
$path = str_replace(str_replace($_SERVER["DOCUMENT_ROOT"], "", __DIR__), "", parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));

$site_title = "インターネット老人会 愛媛支部";

$title = $site_title;
$description = "Z世代が昔の文化などを載せています";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
	<HEAD>
		<TITLE><?=$title?></TITLE>

		<?php
			require(__DIR__."/../OGP.php");
			ogp($site_title, $title, $description);
		?>
	</HEAD>
	<BODY>
		<H1><?=$site_title?></H1>
		<HR>

		<?php
		if ($path == "/") {
			require(__DIR__."/list.php");
		} else if (str_starts_with($path, "/view/")) {
			require(__DIR__."/view.php");
		} else {
			http_response_code(404);
		}
		?>

		<HR>
		©八木瑠海伸梧
	</BODY>
</HTML>