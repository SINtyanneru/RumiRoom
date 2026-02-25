<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

//値が有るか
if($_SERVER["REQUEST_METHOD"] !== "POST"){
	exit;
}

$TEXT = file_get_contents('php://input');
$CONV_LIST = json_decode(file_get_contents("CONVERT_LIST.json"), true);

$SPLIT_TEXT = mb_split(" ", $TEXT);

for($I = 0; $I < count($SPLIT_TEXT); $I++){
	$SP = mb_str_split($SPLIT_TEXT[$I]);
	$KANKEI_NAI = false;

	for($I2 = 0; $I2 < count($SP); $I2++){
		$S = $SP[$I2];

		if(!isset($CONV_LIST[$S])){
			echo $S;
			$KANKEI_NAI = true;
		} else {
			if(!isset($SP[$I2 + 1])){
				if($I2 === 0 || $KANKEI_NAI){
					//単独
					echo $CONV_LIST[$S][0];
				} else {
					//尾字
					echo $CONV_LIST[$S][3];
				}
			} else {
				if($I2 === 0){
					//頭字
					echo $CONV_LIST[$S][1];
				} else {
					//中字
					echo $CONV_LIST[$S][2];
				}
			}
		}
	}

	echo " ";
}
?>