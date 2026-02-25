<?php
require("../../env.php");
require("../../session_login.php");

if ($login == false) {
	echo json_encode(Array("STATUS" => false));
	exit;
}

//ちゃんと値が有るか
if(empty($_POST["TITLE"]) || empty($_POST["TAG"])){
	echo "エラー、パラメーター不足";
	exit;
}

$DATE = date("Y-m-d H:i:s");
$ID = md5($DATE);

$STMT = $PDO->prepare("INSERT INTO `BLOG` (`ID`, `DATE`, `TITLE`, `TEXT`, `PUBLIC`, `LOCK`, `LOCK_PASS`, `TAG`, `UPDATE`) VALUES (:ID, :DATE, :TITLE, \"\", 1, 0, \"\", :TAG, :UPDATE);");
$STMT->bindValue(':DATE', $DATE);
$STMT->bindValue(':ID', $ID);
$STMT->bindValue(':TITLE', $_POST["TITLE"]);
$STMT->bindValue(':TAG', $_POST["TAG"]);
$STMT->bindValue(':UPDATE', $DATE);

//SQL実行
$STMT->execute();

$ERR = $STMT->errorInfo();
if($ERR[0] === "00000"){
	echo "作成しました<A HREF=\"../EDIT/?ID=".$ID."\">編集しに行く</A>";
	exit;
}else{
	echo "エラー、SQLのエラー";
	exit;
}
?>