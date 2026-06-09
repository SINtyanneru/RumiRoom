<?php
try {
	//共通の環境設定
	require(__DIR__."/../env.php");

	//HTTP over TLS判定
	if (str_contains($_SERVER["HTTP_FORWARDED"], "proto=https")) {
		$__is_over_tls = true;
	} else {
		$__is_over_tls = false;
	}

} catch (\Throwable) {
	require(__DIR__."/../Error/500.html");
	exit;
}
