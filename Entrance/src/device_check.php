<?php
function is_smartphone(): bool {
	$ua = $_SERVER["HTTP_USER_AGENT"] ?? "";
	if ($ua === "") {
		return false;
	}

	return preg_match("/iPhone|iPod|Android.*Mobile|Windows Phone|BlackBerry|webOS|Opera Mini|IEMobile/u", $ua) === 1;
}
