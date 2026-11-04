<?php
$path = "/tmp/zhihou.wav";

if (!is_file($path) || filesize($path) === 0) {
	http_response_code(404);
	exit;
}

header("Content-Type: audio/wav");
header("Content-Length: " . filesize($path));
header("Cache-Control: no-store");

readfile($path);