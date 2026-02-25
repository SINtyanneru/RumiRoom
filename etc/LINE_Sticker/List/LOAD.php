<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
require("https://cdn.rumia.me/LIB/SQL.php?V=LATEST");

//スタンプの一覧を取得する
function STICKERS_LIST_LOAD() {
	$pdo = new PDO(
		"mysql:host=192.168.0.130;dbname=rumisan_room;",
		"rumi_room",
		"aqaz12345569apapapa14463229",
		[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
	);

	$result = SQL_RUN($pdo,
		"SELECT
			STAMP.ID,
			STAMP.SALE,
			STAMP.TITLE,
			CREATOR.NAME AS CREATOR,
			JSON_ARRAYAGG(
				JSON_OBJECT(
					'ID', IMAGE.ID
				)
			) AS IMAGE_LIST
		FROM
			`LINESTAMP_STAMP` AS STAMP
		JOIN
			`LINESTAMP_IMAGE` AS IMAGE
			ON IMAGE.STAMP = STAMP.ID
		JOIN
			`LINESTAMP_CREATOR` AS CREATOR
			ON CREATOR.ID = STAMP.CREATOR
		GROUP BY
			STAMP.ID;
	",[]);

	if (!$result["STATUS"]) {
		http_response_code(500);
		exit;
	}

	return $result["RESULT"];
}

$STICKERS_DATA = [];

foreach (STICKERS_LIST_LOAD() as $row) {
	array_push($STICKERS_DATA, [
		"ID" => $row["ID"],
		"SALE_NOW" => $row["SALE"],
		"TITLE" => $row["TITLE"],
		"AUTHOR" => $row["CREATOR"],
		"TAB_THUMBNAIL" => [
			"ON" => "./STICKERS/" . $row["ID"] . "/tab_on.png",
			"OFF" => "./STICKERS/" . $row["ID"] . "/tab_off.png"
		],
		"FILE" => json_decode($row["IMAGE_LIST"], true)
	]);
}
?>