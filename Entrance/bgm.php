<?php
require(__DIR__."/const.php");

$toc = json_decode(file_get_contents(__DIR__."/bgm/toc.json"), true);

if (isset($_COOKIE[BGM_CHOISE_COOKIE])) {
	$bgm = $toc[array_rand($toc)];

	setcookie(BGM_CHOISE_COOKIE, $bgm["ID"], [
		"expires" => 0,
		"path" => "/",
		"secure" => true,
		"httponly" => true,
		"samesite" => "Lax"
	]);

	header("Location: /bgm/".$bgm["ID"].".mp3", false, 302);
} else {
	header("Location: /bgm/".$_COOKIE[BGM_CHOISE_COOKIE].".mp3", false, 302);
}
