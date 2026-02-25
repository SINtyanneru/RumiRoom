<?php
$id = $_GET["ID"];

$id = str_replace("/", "", $id);
$id = str_replace(".", "", $id);

$path = __DIR__."/Stamp/".$id."-tab_on.png";

if (file_exists($path)) {
	header("Content-Type: image/png");
	echo file_get_contents($path);
	exit;
} else {
	http_response_code(404);
	exit;
}