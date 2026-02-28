<?php
require(__DIR__."/../env.php");
$path = str_replace(str_replace($_SERVER["DOCUMENT_ROOT"], "", __DIR__), "", parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
	<HEAD>
		<TITLE>るみさんのラボ</TITLE>

		<?php
			require(__DIR__."/../OGP.php");
			ogp("るみさんのラボ", $title, "開発部屋");
		?>

		<META NAME="GENERATOR" CONTENT="IBM WebSphere Studio Homepage Builder Version 6.5.0.0 for Windows(デザインのみ)">

		<STYLE>
			body{
				margin: 0px;
			}

			table{
				width: 100%;
				height: 100%;
			}

			td{
				vertical-align: top;
			}

			.MENU{
				border-right: solid 1px;
				width: 150px;
			}

			.CONTENTS{
				text-align: center;
			}
		</STYLE>
	</HEAD>
	<BODY BGCOLOR="#003399" BACKGROUND="/Asset/Dev/pe16_bg.gif" TEXT="#99FF99" LINK="#FFFF66" VLINK="#CC99CC" ALINK="#00FF00">
		<TABLE>
			<TR>
				<TD CLASS="MENU">
					<?php
					$stmt = $sql->prepare("
					SELECT
						g.*
					FROM
						`DEV_GENRE` AS g
					");
					$stmt->execute();
					foreach ($stmt->fetchAll() as $row) {
						?>
						<A HREF="/item/<?=$row["ID"]?>"><?=$row["NAME"]?></A>
						<?php
					}
					?>
				</TD>
				<TD CLASS="CONTENTS">
					<IMG SRC="/Asset/Dev/pe16_l1.gif"><BR>

					<?php
					if ($path == "/") {
						require(__DIR__."/top.html");
					} else if (preg_match("#^/item/([^/]+)/?$#", $path, $mtc)) {
						$genre_id = $mtc[1];
						require(__DIR__."/genre.php");
					} else if (preg_match("#^/item/([^/]+)/([^/]+)/?$#", $path, $mtc)) {
						$genre_id = $mtc[1];
						$item_id = $mtc[2];
						require(__DIR__."/item.php");
					} else {
						echo "?";
						http_response_code(404);
					}
					?>

					<BR>
					<IMG SRC="/Asset/Dev/pe16_l2.gif"><BR>
				</TD>
			</TR>
		</TABLE>
	</BODY>
</HTML>