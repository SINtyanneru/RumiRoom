<?php
require(__DIR__."/session_login.php");
?>
<!DOCTYPE html>
<HTML>
	<HEAD>
		<TITLE>記事作成</TITLE>
	</HEAD>
	<BODY>
		<?php
		//値をチェック
		if (empty($_POST["TITLE"]) || trim($_POST["TITLE"]) == "") {
			echo "値が不足しています";
			http_response_code(400);
			exit;
		}

		if (empty($_POST["TAG"]) || trim($_POST["TAG"]) == "") {
			echo "値が不足しています";
			http_response_code(400);
			exit;
		}

		$id = uniqid();
		$title = $_POST["TITLE"];
		$tag_list = explode("/", $_POST["TAG"]);

		$stmt = $sql->prepare("INSERT INTO `BLOG_ARTICLE` (`ID`, `CREATE_AT`, `UPDATE_AT`, `TITLE`, `TEXT`, `IS_PUBLIC`, `LOCK_PASSWORD`) VALUES (:id, NOW(), NOW(), :title, '', 0, :password)");
		$stmt->bindValue(":id", $id, PDO::PARAM_STR);
		$stmt->bindValue(":title", $title, PDO::PARAM_STR);
		if ($_POST["PASSWORD"] != "") {
			$stmt->bindValue(":password", $_POST["PASSWORD"], PDO::PARAM_STR);
		} else {
			$stmt->bindValue(":password", null, PDO::PARAM_STR);
		}
		$stmt->execute();

		foreach ($tag_list as $tag) {
			$stmt = $sql->prepare("INSERT INTO `BLOG_TAG` (`ID`, `ARTICLE`, `NAME`) VALUES (NULL, :article_id, :name);");
			$stmt->bindValue(":article_id", $id, PDO::PARAM_STR);
			$stmt->bindValue(":name", $tag, PDO::PARAM_STR);
			$stmt->execute();
		}
		?>
		<A HREF="edit/?ID=<?=htmlspecialchars($id)?>">編集しに行く</A>
	</BODY>
</HTML>