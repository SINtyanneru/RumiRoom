<?php
require(__DIR__."/../user/session_login.php");
$user = login();
if ($user == false) fuckyou();
if ($user["IS_ADMIN"] == false) fuckyou();

function fuckyou() {
	header("Content-Type: text/plain; charset=UTF-8");
	echo "マヨはわたしの嫁";
	http_response_code(418);
	exit;
}