<?php
$url = "https://account.rumiserver.com/api/Icon?ID=1";
header("Content-Type: image/png");

echo file_get_contents($url);