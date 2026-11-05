<?php
require_once(__DIR__."/src/bgm.php");

$bgm_path = bgm_get_path();

header("Content-Type: audio/mpeg");
header("Content-Length: ".filesize($bgm_path));
header("Cache-Control: no-store");
header("Vary: Cookie");

readfile($bgm_path);