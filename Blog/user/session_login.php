<?php
require(__DIR__."/../../env.php");

function login(): bool|array {
	global $sql;

	if (empty($_COOKIE["BLOG_SESSION"])) {
		return false;
	}

	$user_data = null;

	$session = json_decode(base64_decode($_COOKIE["BLOG_SESSION"]), true);
	switch ($session["TYPE"]) {
		case "RSV":{
			$ajax = curl_init("https://account.rumiserver.com/api/Session?ID=".$session["TOKEN"]);
			curl_setopt($ajax, CURLOPT_HTTPHEADER, ["Accept: application/json"]);
			curl_setopt($ajax, CURLOPT_RETURNTRANSFER, true);
			$user_info = json_decode(curl_exec($ajax), true);
			if ($user_info["STATUS"] == false) return false;

			$stmt = $sql->prepare("SELECT * FROM `BLOG_USER` WHERE `RUMISERVER_USERID` = :user_id");
			$stmt->bindValue(":user_id", $user_info["ACCOUNT_DATA"]["ID"], PDO::PARAM_STR);
			$stmt->execute();
			$user_data = $stmt->fetch();
			$stmt->closeCursor();
			if ($user_data == false) return false;
			break;
		}

		default:
			return false;
	}

	return $user_data;
}