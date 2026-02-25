<?php
require(__DIR__."/LOAD.php");
$BASE_URI = "/RumiRoom/etc/LINE_Sticker/List/";
$BASE_URL = "/etc/LINE_Sticker/List/";
$REQUEST_URL = str_replace($BASE_URI, "/", $_SERVER["REQUEST_URI"]);
$user_list = json_decode(file_get_contents(__DIR__."/user.json"), true);
$stamp_list = [];

if (!check_login()) {
	header('WWW-Authenticate: Basic realm="Restricted Area"');
	header('HTTP/1.0 401 Unauthorized');
	header("Content-Type: text/plain;charset=UTF-8");

	echo "おめーのアクセスは許可されていません";
	exit;
}

foreach ($STICKERS_DATA as $row) {
	$id = $row["ID"];
	$stamp = [];

	foreach ($row["FILE"] as $image) {
		array_push($stamp, [
			"ID" => $image["ID"],
			"THUMBNAIL" => $BASE_URL."../image.gif?ID=".$image["ID"]."&thumbnail=true",
		]);
	}

	array_push($stamp_list, [
		"ID" => $id,
		"TITLE" => $row["TITLE"],
		"AUTHOR" => $row["AUTHOR"],
		"STAMP" => $stamp
	]);
}

function check_login() {
	global $user_list;

	if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
		return false;
	}


	foreach ($user_list as $user) {
		if ($_SERVER['PHP_AUTH_USER'] === $user["ID"] || $_SERVER['PHP_AUTH_PW'] === $user["PASS"]) {
			return true;
		}
	}

	//駄目！
	return false;
}

function GenTabOn($STMP_ID) {
	global $REQUEST_URL;

	if ("/".$STMP_ID === $REQUEST_URL) {
		return "true";
	} else {
		return "false";
	}
}

function GenTabOnClass($STMP_ID) {
	global $REQUEST_URL;

	if ("/".$STMP_ID === $REQUEST_URL) {
		return "ON";
	} else {
		return "OFF";
	}
}
?>
<!DOCTYPE html>
<HTML>
	<HEAD>
		<TITLE>LINEスタンプ一覧</TITLE>

		<LINK REL="stylesheet" HREF="https://cdn.rumia.me/CSS/font.css">
		<LINK REL="stylesheet" HREF="https://cdn.rumia.me/CSS/reset.css">
		<LINK REL="stylesheet" HREF="https://cdn.rumia.me/CSS/DEFAULT.css">

		<!--スタイルｼｰﾄ-->
		<LINK REL="stylesheet" HREF="./STYLE/Main.css">

		<!--JS-->
		<SCRIPT SRC="./SCRIPT/Main.js" defer></SCRIPT>
	</HEAD>
	<BODY>
		<DIV CLASS="STAMP_INFO" ID="EL_STAMP_INFO"></DIV>

		<DIV CLASS="TABVIEW" data-tabviewid="stmp">
			<DIV CLASS="TABVIEW_BTN">
				<?php
					foreach ($STICKERS_DATA as $ROW) {
						$ID = $ROW["ID"];
						$TITLE = $ROW["TITLE"];
						$AUTHOR = $ROW["AUTHOR"];
						$THUMBNAIL = $BASE_URL."../tab.php?ID=".$ID;
						?>
						<BUTTON ID="TABVIEW_BTN_ITEM" on="<?=GenTabOn($ID)?>" onclick="TABVIEW_CH('<?=$ID?>', this); STICKER_INFO_DRAW('<?=$THUMBNAIL?>', '<?=$TITLE?>', '<?=$AUTHOR?>', '<?=$ID?>');" data-name="<?=$ID?>" data-tabviewid="stmp">
							<IMG SRC="<?=$THUMBNAIL?>">
							<DIV><?=$TITLE?></DIV>
						</BUTTON>
						<?php
					}
				?>
			</DIV>
			<DIV CLASS="TABVIEW_ITEM_PARENT">
				<?php
					foreach ($STICKERS_DATA as $row) {
						?>
						<DIV CLASS="TABVIEW_ITEM_<?=GenTabOnClass($row["ID"])?>" ID="TABVIEW_ITEM" data-id="<?=$row["ID"]?>" data-name="<?=$row["ID"]?>" data-tabviewid="stmp">

						</DIV>
						<?php
					}
				?>
			</DIV>
		</DIV>

		<DIV CLASS="MSG_BOX_OWNER" ID="EL_MSG_BOX_OWNER"></DIV>
	</BODY>

	<SCRIPT SRC="https://cdn.rumia.me/LIB/TABVIEW.js?V=LATEST" defer></SCRIPT>
	<SCRIPT SRC="https://cdn.rumia.me/LIB/DIALOG.js?V=LATEST" defer></SCRIPT>
	<SCRIPT defer>
		const list = <?=json_encode($stamp_list)?>;

		window.addEventListener("load", async (e)=>{
			const load = new DIALOG_SYSTEM().SHOW_LOAD("ロード中");

			for (let i = 0; i < list.length; i++) {
				const stamp = list[i];
				const tab = document.querySelector(`#TABVIEW_ITEM[data-id="${stamp["ID"]}"]`);

				for (let j = 0; j < stamp["STAMP"].length; j++) {
					const img = stamp["STAMP"][j];
					let el = document.createElement("IMG");
					el.addEventListener("click", (e)=>{
						CPI(img["ID"]);
					});

					let ajax = await fetch(img["THUMBNAIL"]);
					const blob = await ajax.blob();
					const url = URL.createObjectURL(blob);

					el.style.height = "100px";
					el.src = url;
					el.addEventListener("load", (e)=>{
						URL.revokeObjectURL(url)
					});
					tab.appendChild(el);
				}
			}

			new DIALOG_SYSTEM().CLOSE_LOAD(load);
		});
	</SCRIPT>
</HTML>