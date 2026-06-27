<?php
require(__DIR__."/../session_login.php");
header("Content-Type: application/json");

$post = json_decode(file_get_contents("php://input"), true);

var_dump($post);

$stmt = $sql->prepare("UPDATE `BLOG_ARTICLE` SET `TITLE` = :title, `TEXT` = :text, `IS_PUBLIC` = :is_public, `UPDATE_AT` = NOW() WHERE `ID` = :id;");
$stmt->bindValue(":id", $post["ID"], PDO::PARAM_STR);
$stmt->bindValue(":title", $post["TITLE"], PDO::PARAM_STR);
$stmt->bindValue(":text", $post["TEXT"], PDO::PARAM_STR);
if ($post["IS_PUBLIC"]) {
	$stmt->bindValue(":is_public", 1, PDO::PARAM_INT);
} else {
	$stmt->bindValue(":is_public", 0, PDO::PARAM_INT);
}
$stmt->execute();

echo json_encode(["STATUS" => true]);