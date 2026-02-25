<?php
if (!isset($_GET["ID"])) {
	echo "は？";
	http_response_code(410);
	return;
}

//コメント一覧習得
$stmt = $PDO->prepare(<<<TEXT
	SELECT
		B.*,
		(
			SELECT
				JSON_ARRAYAGG(
					JSON_OBJECT(
						'ID', C.ID,
						'DATE', C.DATE,
						'UID', C.UID,
						'TEXT', C.TEXT,
						'BLOG_ID', C.BLOG_ID
					)
				)
			FROM
				`BLOG_COMMENT` AS C
			WHERE
				C.`BLOG_ID` = B.`ID`
			AND
				C.`REPLY` IS NULL
			ORDER BY
				C.`ID` ASC
			LIMIT 100
		) AS `COMMENT`
	FROM
		`BLOG` AS B
	WHERE
		B.`PUBLIC` = 1
	AND
		B.`ID` = :ID;
TEXT);
$stmt->bindValue(':ID', $_GET["ID"]);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$blog = $result[0];
$comment_list = json_decode($result[0]["COMMENT"], true);
?>
コメント一覧<BR>
<IMG SRC="thumbnail.php?TEXT=<?=$blog["TITLE"]?>"><BR>
<A HREF="view.php?ID=<?=$blog["ID"]?>">記事に戻る</A>
<HR>

<?php require(__DIR__."/../Component/CommentForm.php"); ?>
<HR>

<?php
foreach ($comment_list as $comment) {
	require(__DIR__."/../Component/Comment.php");
}
?>

※コメントは100件しか出してません