<?php
//ドメイン
$__DOMAIN = "blog.rumi-room.net";
//URLの先頭
$__URL_PREFIX = "";
$__URI_PREFIX = "/RumiRoom/Blog";

//ブログの名前
$__BLOG_NAME = "るみさんのブログ";

//RSCP
$__RSCP_HOST = "192.168.0.120";
$__RSCP_PORT = 41029;

$__RDS_HOST = "http://192.168.0.130/rds/";
$__RDS_PORT = 3006;

//SQL
$__SQL_HOST = "192.168.0.130";
$__SQL_DB = "rumisan_room";
$__SQL_USER = "user";
$__SQL_PASS = "NAMUHIhUZu_4423_322470303223_193127387987_4423_005742659749_380572241506_010610577945_AA_GX533_MINITX_PICO_PSU150XT_ATAFAKALONGONA_AXTV_TVA_TELEVI_AICHI_LAA1503716";

//セッション
$__SESSION_NAME = "RUMI_BLOG";

try {
	$PDO = new PDO(
		"mysql:host=".$__SQL_HOST.";dbname=".$__SQL_DB.";",
		$__SQL_USER,
		$__SQL_PASS,
		[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
	);
} catch (PDOException $ex) {
	exit;
}