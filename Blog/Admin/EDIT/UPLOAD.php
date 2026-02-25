<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

require("../../env.php");
require("../../session_login.php");

if ($login == false) {
	echo json_encode(Array("STATUS" => false, "MSG" => "REQ_LOGIN"));
	exit;
}

$FILE_NAME = $_POST["ID"]."_".time();

$AJAX = curl_init($__RDS_HOST."Blog/".$FILE_NAME."?MODE=CREATE&PUBLIC=true");
curl_setopt($AJAX, CURLOPT_PORT, $__RDS_PORT);
curl_setopt($AJAX, CURLOPT_POST, true);
curl_setopt($AJAX, CURLOPT_POSTFIELDS, file_get_contents($_FILES["DATA"]["tmp_name"]));
curl_setopt($AJAX, CURLOPT_RETURNTRANSFER, true);
$RESULT = curl_exec($AJAX);
curl_close($AJAX);

echo json_encode(Array("STATUS" => true, "FILE_NAME" => "/Data/Blog/".$FILE_NAME));
exit;
?>