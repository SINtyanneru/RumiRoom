<?php
require(__DIR__."/env.php");
session_start();

//環境設定
$ENV = file_get_contents($_SERVER['DOCUMENT_ROOT']."/ENV.json");
if($ENV === false){
	$Login_tips = "ENV ERR";
	echo json_encode(array("STATUS" => false, "MSG" => $Login_error));
	exit;
}else{
	$ENV = json_decode($ENV, true);
	if(json_last_error() !== 0){
		$Login_tips = "ENV ERR";
		echo json_encode(array("STATUS" => false, "MSG" => $Login_error));
		exit;
	}
}

if (isset($_GET["SESSION"])) {
	$AJAX = curl_init("https://account.rumiserver.com/api/AUTH/Check");
	curl_setopt($AJAX, CURLOPT_POST, true);
	curl_setopt($AJAX, CURLOPT_HTTPHEADER, ["Content-Type: application/json; charset=UTF-8", "Accept: application/json; charset=UTF-8"]);
	curl_setopt($AJAX, CURLOPT_POSTFIELDS, json_encode([
		"APP" => $ENV["RSV_APP_ID"],
		"SESSION" => $_GET["SESSION"],
		"TOKEN" => $ENV["RSV_TOKEN"]
	]));
	curl_setopt($AJAX, CURLOPT_RETURNTRANSFER, true);
	$RESULT = json_decode(curl_exec($AJAX), true);

	if ($RESULT["STATUS"]) {
		$ajax = curl_init("https://account.rumiserver.com/api/Session?ID=".$RESULT["TOKEN"]);
		curl_setopt($ajax, CURLOPT_HTTPHEADER, ["Accept: application/json"]);
		curl_setopt($ajax, CURLOPT_RETURNTRANSFER, true);
		$USER_INFO = json_decode(curl_exec($ajax), true);
		if ($USER_INFO["STATUS"]) {
			$_SESSION[$__SESSION_NAME] = [
				"TYPE" => "RSV",
				"TOKEN" => $RESULT["TOKEN"]
			];

			echo "ようこそ".htmlspecialchars($USER_INFO["ACCOUNT_DATA"]["NAME"])."さん<BR>";
			echo "<A HREF=\"".$__URL_PREFIX."\">戻る</A>";
		} else {
			echo "セッションエラー";
		}
	} else {
		header("Content-Type: text/plain; charset=UTF-8");

		switch ($RESULT["ERR"]) {
			case "NTF": {
				echo "セッションが不正です";
				return;
			}

			default: {
				echo "不明なエラー:".json_encode($RESULT);
			}
		}
	}
} else {
	header("Location: https://account.rumiserver.com/auth?ID=8357544410130106121&SESSION=".urlencode(uniqid())."&PERMISSION=account:read&CALLBACK=".urlencode("https://".$__DOMAIN.$__URL_PREFIX."/login.php"));
}
?>