<?php
require("../../env.php");
require("../../session_login.php");

if ($login == false) {
	echo "は？";
	exit;
}

//POSTされたJSONを変数に入れておく
$POST = json_decode(file_get_contents('php://input'), true);

//ちゃんと値が有るか
if(!(isset($POST["ID"]) || isset($POST["TITLE"]) || isset($POST["TEXT"]) || isset($POST["PUBLIC"]) || isset($POST["LOCK"]) || isset($POST["LOCK_PASS"]))){
	echo json_encode(Array("STATUS" => false, "MSG" => "PARAM_NAI!"));
	exit;
}

$STMT = $PDO->prepare("UPDATE `BLOG` SET `TITLE` = :TITLE, `TEXT` = :TEXT, `PUBLIC` = :PUBLIC, `UPDATE` = :UPDATE, `LOCK` = :LOCK, `LOCK_PASS` = :LOCK_PASS WHERE `ID` = :ID");
$STMT->bindValue(':ID', $POST["ID"]);
$STMT->bindValue(':TITLE', $POST["TITLE"]);
$STMT->bindValue(':TEXT', base64_encode($POST["TEXT"]));
$STMT->bindValue(':UPDATE', date("Y-m-d H:i:s"));

$STMT->bindValue(':LOCK_PASS', $POST["LOCK_PASS"]);
if($POST["PUBLIC"]){
	$STMT->bindValue(':PUBLIC', 1);
}else{
	$STMT->bindValue(':PUBLIC', 0);
}

if($POST["LOCK"]){
	$STMT->bindValue(':LOCK', 1);
}else{
	$STMT->bindValue(':LOCK', 0);
}

//SQL実行
$STMT->execute();

$ERR = $STMT->errorInfo();
if($ERR[0] === "00000"){
	echo json_encode(Array("STATUS" => true));
	exit;
}else{
	echo json_encode(Array("STATUS" => false, "MSG" => "SQL_ERR"));
	exit;
}
?>