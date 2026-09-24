<?php
header("Content-Type: text/plain; charset=UTF-8");

$key = "unko4545pju";
if ($_GET["KEY"] != $key) {
	echo "?";
	exit;
}

$connection = ssh2_connect("192.168.0.139", 22);
if (!$connection) {
	echo "エラー";
	exit;
}

//認証（パスワード）
if (!ssh2_auth_password($connection, "root", "aya4423")) {
	echo "エラー";
	exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	$stream = ssh2_exec($connection, "pct status 112");
	stream_set_blocking($stream, true);

	if (str_contains(stream_get_contents($stream), "running")) {
		echo "RUN";
	} else {
		echo "STOP";
	}

	fclose($stream);
} else {
	if ($_GET["MODE"] == "STOP") {
		$stream = ssh2_exec($connection, "pct shutdown 112");
		stream_set_blocking($stream, true);
	} else {
		$stream = ssh2_exec($connection, "pct start 112");
		stream_set_blocking($stream, true);
	}

	echo "たぶんOK";
}