<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

//メソッドがPOSTじゃない
if($_SERVER["REQUEST_METHOD"] !== "POST"){
	echo "POSTしろ！";
}

//POSTされたJSONを解読
$POST = json_decode(file_get_contents('php://input'), true);

//必要なパラメータが無い
if(empty($_GET["MODE"]) || empty($POST["SESSION"]) || empty($POST["DEVICE"]) || empty($POST["MODEL"]) || empty($POST["DATA"])){
	echo "あ？";
	http_response_code(418);
	exit;
}

$SESSION = $POST["SESSION"];
$DEVICE_ID = $POST["DEVICE"];
$DEVICE_MODEL = $POST["MODEL"];
$DATA = $POST["DATA"];

if($_GET["MODE"] === "DEVICEU"){
	$AJAX = curl_init("https://cocoroplusapp.jp.sharp/v1/cocoro-air/deviceinfos");

	$HEADER_DATA = array(
		"Cookie: jsessionid=".$SESSION
	);
	
	curl_setopt($AJAX, CURLOPT_HTTPHEADER, $HEADER_DATA);
	curl_setopt($AJAX, CURLOPT_RETURNTRANSFER, true);
	
	$RESULT = json_decode(curl_exec($AJAX), true);
	if (!curl_errno($AJAX)) {
		if($RESULT["device_infos_003_010"]["status"] === 200){
			$LIST = array();
			for ($I=0; $I < count($RESULT["device_infos_003_010"]["body"]["devices"]); $I++) {
				$ROW = $RESULT["device_infos_003_010"]["body"]["devices"][$I];
				array_push($LIST, array(
					"ID" => $ROW["device_id"],
					"NAME" => $ROW["device_name"],
					"MODEL" => $ROW["model_name"]
				));
			}
			echo json_encode(array("STATUS" => true, "LIST" => $LIST));
		} else {
			echo "{\"STATUS\":false}";
		}
	} else {
		echo "{\"STATUS\":false}";
	}
} elseif($_GET["MODE"] === "CONT"){
	$AJAX = curl_init("https://cocoroplusapp.jp.sharp/v1/cocoro-air/sync/air-conditioner");
	$POST_DATA = array(
		"deviceToken" => $DEVICE_ID,
		"map_ver" => 23,
		"model_name" => $DEVICE_MODEL,
		"additional_request" => false,
		"event_key" => "echonet_control",
		"data" => $DATA
	);
	
	$HEADER_DATA = array(
		"Cookie: jsessionid=".$SESSION,
		"Content-Type: application/json"
	);
	
	curl_setopt($AJAX, CURLOPT_HTTPHEADER, $HEADER_DATA);
	curl_setopt($AJAX, CURLOPT_POST, true);
	curl_setopt($AJAX, CURLOPT_POSTFIELDS, json_encode($POST_DATA));
	curl_setopt($AJAX, CURLOPT_RETURNTRANSFER, true);
	
	$RESULT = json_decode(curl_exec($AJAX));
	if (!curl_errno($AJAX)) {
		var_dump($RESULT);
	} else {
		echo "{\"STATUS\":false}";
	}
}
?>