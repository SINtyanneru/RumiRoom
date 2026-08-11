<?php
require(__DIR__."/../../../env.php");

if (isset($_GET["SESSION"])) {
	$ajax = curl_init("https://account.rumiserver.com/api/Auth/Check");
	curl_setopt($ajax, CURLOPT_POST, true);
	curl_setopt($ajax, CURLOPT_HTTPHEADER, ["Content-Type: application/json; charset=UTF-8", "Accept: application/json; charset=UTF-8"]);
	curl_setopt($ajax, CURLOPT_POSTFIELDS, json_encode([
		"APP" => $__RSV_APP_ID,
		"SESSION" => $_GET["SESSION"],
		"TOKEN" => $__RSV_TOKEN
	]));
	curl_setopt($ajax, CURLOPT_RETURNTRANSFER, true);
	$result = json_decode(curl_exec($ajax), true);
	$token = $result["TOKEN"];

	setcookie("AUTH_DATA", base64_encode(json_encode(
		[
			"MODE" => "RSV",
			"TOKEN" => $token
		]
	)), time() + 600, "/", "blog.rumi-room.net", true, true);
	header("Location: /user/login/auth.php");
} else {
	header("Location: https://account.rumiserver.com/auth?ID=".$__RSV_APP_ID."&SESSION=".urlencode(uniqid())."&PERMISSION=account:read&CALLBACK=".urlencode("https://blog.rumi-room.net/user/login/rsv_login.php"));
}