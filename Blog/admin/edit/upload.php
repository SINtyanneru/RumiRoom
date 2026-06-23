<?php
require(__DIR__."/../session_login.php");
header("Content-Type: application/json");

$blog_id = $_GET["ID"];
$file = $_FILES["FILE"];
$file_path = $file["tmp_name"];
$file_type = $file["type"];

$api_url = "https://".$__MSKY_DRIVE_HOST."/api/drive/files/create";
$fd = [
	"i" => $__MSKY_DRIVE_TOKEN,
	"force" => "true",
	"file" => new CURLFile(
		$file_path,
		$file_type,
		"blob"
	),
	"name" => $blog_id."_".date("Y-m-d")."_".date("A").date("h:i:s"),
	"folderId" => $__MSKY_DRIVE_DIR_ID
];

$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fd);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = json_decode(curl_exec($ch), true);

echo json_encode(["STATUS" => true, "URL" => $res["url"]]);