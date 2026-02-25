<?php
if (!isset($_GET["TEXT"])) {
	echo "TEXTがない";
	exit;
}

$IMG = imagecreatetruecolor(500, 500);
imagefilledrectangle($IMG, 0, 0, 500, 500, 0xFFFFFF);
$FONT = __DIR__."/NotoSansJP-Regular.ttf";

$IDS = array();

for ($I = 0; $I < strlen($_GET["TEXT"]); $I++) { 
	$S = $_GET["TEXT"][$I];

	switch($S) {
		case "⿱": {
			
			break;
		}

		case "⿰": {
			
			break;
		}
	}
}

var_dump($IDS);

/*
header('Content-Type: image/jpeg;');
imagejpeg($IMG,NULL,100);
imagedestroy($IMG);*/
?>