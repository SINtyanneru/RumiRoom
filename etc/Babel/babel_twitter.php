<?php
$i = [];
$text = "";

if (isset($_GET["ID"])) {
	$split = explode("-", $_GET["ID"]);
	foreach ($split as $s) {
		array_push($i, intval($s));
	}
}

foreach ($i as $cp) {
	$cp += 32;
	if ($cp <= 126) {
		$text .= chr($cp);
	}
}

echo htmlspecialchars($text);