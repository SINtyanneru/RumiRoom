<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

//画像を作る
$IMG = imagecreatetruecolor(500, 300);
imagefilledrectangle($IMG, 0, 0, 599, 399, 0xeeeedd);

//--------------------------------------文字列を配列化する
$TEXT = array();

//パラメーターがあるか
if (!empty($_REQUEST['TEXT'])) {
	$REQUEST_TITLE = mb_str_split($_REQUEST['TEXT'], 1);

	$C = 1;					//これは15文字ずつリセットするので、forとか独立した値である必要がある、CはČINKOのC
	$TEMP_TITLE = "";		//ここに書いていく
	for ($I=0; $I < count($REQUEST_TITLE); $I++) {
		$STR = $REQUEST_TITLE[$I];

		//特定の文字で、+1したら15以上なら、次の処理に回す
		if ($STR === "「") {
			if($C+1 > 10){
				$C = 1;
				//配列に追記
				array_push($TEXT, $TEMP_TITLE);

				//一時配列に入れることで、次の処理で使える
				$TEMP_TITLE = $STR;
			}
		} else {
			$TEMP_TITLE .= $STR;
			$C++;
		}
		if ($C > 10 || empty($REQUEST_TITLE[$I +1])) {
			//配列に追記
			array_push($TEXT, $TEMP_TITLE);

			//初期化
			$C = 1;
			$TEMP_TITLE = "";
		}
	}
} else {
	//無い
	array_push($TEXT, "パラメーターを", "よこしやがれ", "愚か者");
}


$FONT_FILE = "./uzura.ttf";
$FONT_SIZE = 30;

//--------------------------------------実際に描画
//タイトルを描画
for($I = 0; $I < count($TEXT); $I++){
	$STR = $TEXT[$I];										//文字列
	$BBOX = imagettfbbox($FONT_SIZE, 0, $FONT_FILE, $STR);	//テキストの横幅(中央に表示するために必須)
	$TEXT_WIDTH = $BBOX[2] - $BBOX[0];						//テキストの横幅(中央に表示するために必須)
	$Y = ($FONT_SIZE + 10) * $I;							//縦軸
	imagettftext($IMG, $FONT_SIZE, 0, intval((500 - $TEXT_WIDTH ) / 2), intval(300 / 2 + $Y), 0x000000, $FONT_FILE, $STR);
}

//その他の描画
imagettftext($IMG, 20, 0, 0, 25, 0x000000, $FONT_FILE, "るみさんのブログ");

//画像として出力
header('Content-Type: image/png;');
imagepng($IMG);
imagedestroy($IMG);
?>