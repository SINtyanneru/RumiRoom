<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

//↓GDのエラーはこうしないとtryに引っかからん
set_error_handler(function ($errno, $errstr) {
	throw new \RuntimeException($errstr, $errno);
});

include("https://cdn.rumia.me/LIB/OGP.php");

if(!empty($_GET["ID"])){
	$NOTE_ID = explode("@", $_GET["ID"])[0];
	$NOTE_DOMAIN = explode("@", $_GET["ID"])[1];

	if ($NOTE_DOMAIN !== "ussr.rumiserver.com") {
		echo "るみすきーのみ";
		exit;
	}

	//AJAXする
	$AJAX = curl_init("https://".$NOTE_DOMAIN."/api/notes/show");
	curl_setopt($AJAX, CURLOPT_POST, TRUE);
	curl_setopt($AJAX, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($AJAX, CURLOPT_POSTFIELDS, "{\"noteId\":\"$NOTE_ID\"}");
	curl_setopt($AJAX, CURLOPT_HTTPHEADER, array(
		"Content-Type: application/json"
	));
	$RESULT = json_decode(curl_exec($AJAX), true);
	$AJAX_ERR = curl_error($AJAX);
	curl_close($AJAX);

	if($AJAX_ERR == ""){
		$USER = [
			"ID" => $RESULT["user"]["id"],
			"UID" => $RESULT["user"]["username"],
			"NAME" => $RESULT["user"]["name"],
			"HOST" => $RESULT["user"]["host"],
			"ICON" => "/tmp/".uniqid(),
		];
		$NOTE = [
			"TEXT" => $RESULT["text"]
		];

		//アイコン
		file_put_contents($USER["ICON"], file_get_contents($RESULT["user"]["avatarUrl"]));

		$WIDTH = 500;
		$HEIGHT = 600;
		$PADDING = 32;
		$INSTANCENAME_FONTSIZE = 15;
		$FONT = __DIR__."/NotoSansJP-Regular.ttf";

		//ベース
		$IMG = imagecreatetruecolor($WIDTH, $HEIGHT);
		imagefilledrectangle($IMG, 0, 0, $WIDTH, $HEIGHT, imagecolorallocate($IMG, 0xF0, 0xF0, 0xF0));

		//インスタンス名
		imagettftext($IMG, $INSTANCENAME_FONTSIZE, 0, 50, 25, imagecolorallocate($IMG, 0, 0, 0), $FONT, "インスタンス名");

		//枠
		$WAKU_X = 10;
		$WAKU_Y = 30 + $INSTANCENAME_FONTSIZE;
		$WAKU_W = $WIDTH - 20;
		drawRoundedRectangle($IMG, $WAKU_X, $WAKU_Y, $WAKU_W, $HEIGHT - 50, 10, imagecolorallocate($IMG, 0xFF, 0xFF, 0xFF));

		//アイコン
		$ICON = null;
		try {
			if (str_contains($RESULT["user"]["avatarUrl"], "webp")) {
				$ICON = imagecreatefromwebp($USER["ICON"]);
			} else {
				$ICON = imagecreatefrompng($USER["ICON"]);
			}
		} catch(\Exception $EX) {
			//読み込みエラー
			$ICON = imagecreatetruecolor(256, 256);
		} catch(\Throwable $EX) {//読み込みエラー
			$ICON = imagecreatetruecolor(256, 256);
		}

		$ICON_SIZE = 58;
		imagecopyresized($IMG, $ICON, $WAKU_X + $PADDING, $WAKU_Y + $PADDING, 0, 0, $ICON_SIZE, $ICON_SIZE, imagesx($ICON), imagesy($ICON));

		//なまえ
		$USERNAME_FONTSIZE = 19;
		imagettftext($IMG, $USERNAME_FONTSIZE, 0, $WAKU_X + $PADDING + $ICON_SIZE + 10, $WAKU_Y + $PADDING + $USERNAME_FONTSIZE + 10, imagecolorallocate($IMG, 0, 0, 0), $FONT, $USER["NAME"]);
		imagettftext($IMG, $USERNAME_FONTSIZE - 5, 0, $WAKU_X + $PADDING + $ICON_SIZE + 10, $WAKU_Y + $PADDING + (($USERNAME_FONTSIZE - 5)*3) + 10, imagecolorallocate($IMG, 0, 0, 0), $FONT, "@".$USER["UID"]);

		//テキスト
		$TEXT = "";
		$LINE = "";
		$TEXT_SIZE = 21;
		$SCount = 0;
		$SPLIT = mb_str_split($NOTE["TEXT"]);
		for ($I = 0; $I < count($SPLIT); $I++) { 
			$S = $SPLIT[$I];
			//追加
			$TEXT .= $S;
			$LINE .= $S;

			$BBOX = imagettfbbox($TEXT_SIZE, 0, $FONT, $LINE);
			$LINE_WIDTH = abs($BBOX[2] - $BBOX[0]);

			if ($LINE_WIDTH >= ($WAKU_W - $PADDING - $PADDING) || $S === "\n") {
				$TEXT .= "\n";
				$LINE = "";
				$SCount = 0;
			}
		}

		imagettftext($IMG, $TEXT_SIZE, 0, $WAKU_X + $PADDING, $WAKU_Y + $PADDING + ($USERNAME_FONTSIZE * 4) + 10, imagecolorallocate($IMG, 0, 0, 0), $FONT, $TEXT);

		header("Content-Type: image/png");
		imagepng($IMG);

		//後始末
		//unlink($USER["ICON"]);
	} else {
		echo "ERR";
	}
} else {
	echo "f";
}

function drawRoundedRectangle($image, $x, $y, $width, $height, $radius, $color) {
	//四隅の円弧を描画
	imagefilledarc($image, $x + $radius, $y + $radius, $radius * 2, $radius * 2, 180, 270, $color, IMG_ARC_PIE); //左上
	imagefilledarc($image, $x + $width - $radius, $y + $radius, $radius * 2, $radius * 2, 270, 360, $color, IMG_ARC_PIE); //右上
	imagefilledarc($image, $x + $radius, $y + $height - $radius, $radius * 2, $radius * 2, 90, 180, $color, IMG_ARC_PIE); //左下
	imagefilledarc($image, $x + $width - $radius, $y + $height - $radius, $radius * 2, $radius * 2, 0, 90, $color, IMG_ARC_PIE); //右下

	//直線部分の描画
	imagefilledrectangle($image, $x + $radius, $y, $x + $width - $radius, $y + $radius, $color); //上
	imagefilledrectangle($image, $x + $radius, $y + $height - $radius, $x + $width - $radius, $y + $height, $color); //下
	imagefilledrectangle($image, $x, $y + $radius, $x + $radius, $y + $height - $radius, $color); //左
	imagefilledrectangle($image, $x + $width - $radius, $y + $radius, $x + $width, $y + $height - $radius, $color); //右

	//中央の四角形を描画
	imagefilledrectangle($image, $x + $radius, $y + $radius, $x + $width - $radius, $y + $height - $radius, $color);
}

?>