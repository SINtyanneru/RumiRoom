<?php
header("Content-Type: text/plain; charset=UTF-8");
$cookie_prefix = "AUTH_TEST-";

if (!isset($_GET["TYPE"])) {
	echo "?";
	http_response_code(400);
	exit;
}

switch (strtoupper($_GET["TYPE"])) {
	case "MISSKEY":
		misskey();
		exit;

	default:
		echo "?";
		exit;
}

function misskey() {
	global $cookie_prefix;

	$session = $_GET["session"];
	$host = $_GET["HOST"];
	$url = "https://".$host."/api/miauth/".$session."/check";

	$ajax = curl_init($url);
	curl_setopt($ajax, CURLOPT_POST, true);
	curl_setopt($ajax, CURLOPT_POSTFIELDS, "{}");
	curl_setopt($ajax, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ajax, CURLOPT_HTTPHEADER, [
		"Content-Type: application/json; charset=UTF-8"
	]);
	$result = json_decode(curl_exec($ajax), true);
	$error = curl_error($ajax);

	if ($error) {
		echo "Misskeyサーバーがエラーを吐きました\n".$error;
		return;
	}

	$token = $result["token"];
	setcookie($cookie_prefix."MISSKEY", $token, time() + (60 * 60 * 24 * 360), "/", "rumi-room.net", true);

	header("Location: ./");
}