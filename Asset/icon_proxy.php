<?php
$url = "https://data.rumiserver.jp/account/icon/1";
header("Content-Type: image/png");

echo file_get_contents($url);