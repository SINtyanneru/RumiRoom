<?php
require(__DIR__."/const.php");

$url = $_GET["p"];
$url_param = http_build_query(json_decode($_GET["r"], true));

if ($url_param != "") $url_param = "?".$url_param;

if (empty($_GET["m"])) {
	header("Location: ".$url.$url_param, false, 302);
	exit;
}

$setting = [
	"ENABLE" => true,
	"VOLUME" => 0.5,
	"SEEK" => 0
];

if (empty($_COOKIE[BGM_SETTING_COOKIE]) == false) {
	$setting = json_decode($_COOKIE[BGM_SETTING_COOKIE], true);
}

switch ($_GET["m"]) {
	case "onoff": {
		if ($setting["ENABLE"]) {
			$setting["ENABLE"] = false;
		} else {
			$setting["ENABLE"] = true;
		}
		break;
	}

	case "up": {
		$setting["VOLUME"] += 0.1;
		if ($setting["VOLUME"] > 1) {
			$setting["VOLUME"] = 1;
		}
		break;
	}

	case "down": {
		$setting["VOLUME"] -= 0.1;
		if ($setting["VOLUME"] < 0) {
			$setting["VOLUME"] = 0;
		}
		break;
	}
}

setcookie(
	BGM_SETTING_COOKIE,
	json_encode($setting, JSON_UNESCAPED_UNICODE),
	[
		"expires" => time() + 60 * 60 * 24 * 365 * 10,
		"path" => "/",
		"secure" => true,
		"httponly" => true,
		"samesite" => "Lax"
	]
);


header("Location: ".$url.$url_param, false, 302);