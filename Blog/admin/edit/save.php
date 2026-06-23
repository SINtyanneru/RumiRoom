<?php
require(__DIR__."/../session_login.php");
header("Content-Type: application/json");

if (empty($_POST["ID"]) || empty($_POST["TITLE"]) || empty($_POST["TEXT"]) || empty($_POST["IS_PUBLIC"])) {
	echo json_encode(["STATUS" => false]);
	exit;
}

$stmt = $sql->prepare("UPDATE `BLOG_ARTICLE` SET `TITLE` = :title, `TEXT` = :text, `IS_PUBLIC` = :is_public, `UPDATE_AT` = NOW() WHERE `ID` = :id;");
$stmt->bindValue(":id", $_POST["ID"], PDO::PARAM_STR);
$stmt->bindValue(":title", $_POST["TITLE"], PDO::PARAM_STR);
$stmt->bindValue(":text", $_POST["TEXT"], PDO::PARAM_STR);
if ($_POST["IS_PUBLIC"] == "T") {
	$stmt->bindValue(":is_public", 1, PDO::PARAM_INT);
} else {
	$stmt->bindValue(":is_public", 0, PDO::PARAM_INT);
}
$stmt->execute();

echo json_encode(["STATUS" => true]);