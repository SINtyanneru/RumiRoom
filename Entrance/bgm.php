<?php
require(__DIR__."/const.php");

//セッション開始
function bgm_session_start() {
	if (session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
}

//TOCを読み込む
function bgm_load_toc() {
	return json_decode(file_get_contents(__DIR__."/bgm/toc.json"), true);
}

//抽選
function bgm_choise() {
	bgm_session_start();

	$toc = bgm_load_toc();
	$id = array_map("strval", array_column($toc, "ID"));

	//選択済みで、かつTOCに存在するなら何もしない
	if (isset($_SESSION["BGM_ID"]) && in_array((string)$_SESSION["BGM_ID"], $id, true)) {
		return;
	}

	$_SESSION["BGM_ID"] = $id[array_rand($id)];
	session_write_close();
}

//再抽選
function bgm_rechoise() {
	bgm_session_start();

	$toc = bgm_load_toc();
	$id = array_map("strval", array_column($toc, "ID"));

	$now = isset($_SESSION["BGM_ID"]) ? (string)$_SESSION["BGM_ID"] : "";
	$candidate = array_values(array_filter($id, function ($v) use ($now) {
		return $v !== $now;
	}));
	if (count($candidate) == 0) {
		$candidate = $id;
	}

	$_SESSION["BGM_ID"] = $candidate[array_rand($candidate)];
	session_write_close();
}

//選ばれたBGMのパスを返す
function bgm_get_path() {
	bgm_choise();

	bgm_session_start();
	$id = (string)$_SESSION["BGM_ID"];
	session_write_close();

	return __DIR__."/bgm/".$id.".mp3";
}

//現在のBGMのIDを返す
function bgm_get_id() {
	bgm_choise();

	bgm_session_start();
	$id = (string)$_SESSION["BGM_ID"];
	session_write_close();

	return $id;
}