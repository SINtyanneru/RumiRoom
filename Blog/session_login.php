<?php
session_start();
$login = false;
$user = null;
if (isset($_SESSION[$__SESSION_NAME])) {
	if ($_SESSION[$__SESSION_NAME]["TYPE"] === "RSV") {
		$ajax = curl_init("https://account.rumiserver.com/api/Session?ID=".$_SESSION[$__SESSION_NAME]["TOKEN"]);
		curl_setopt($ajax, CURLOPT_HTTPHEADER, ["Accept: application/json"]);
		curl_setopt($ajax, CURLOPT_RETURNTRANSFER, true);
		$user_info = json_decode(curl_exec($ajax), true);
		if ($user_info["STATUS"]) {
			$user = $user_info["ACCOUNT_DATA"];
			$login = true;
		} else {
			$_SESSION[$__SESSION_NAME] = null;
		}
	}
}