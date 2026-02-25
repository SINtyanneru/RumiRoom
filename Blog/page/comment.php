<?php
if (!isset($_GET["ID"]) || !isset($_GET["BLOG"])) {
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
				C.`REPLY` = :COMMENT
			ORDER BY
				C.DATE ASC
			LIMIT 100
		) AS `REPLY`,
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
				C.ID = :COMMENT
			LIMIT 100
		) AS `COMMENT`
	FROM
		`BLOG` AS B
	WHERE
		B.`PUBLIC` = 1
	AND
		B.`ID` = :ID;
TEXT);
$stmt->bindValue(':ID', $_GET["BLOG"]);
$stmt->bindValue(':COMMENT', $_GET["ID"]);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$blog = $result[0];
$comment = json_decode($result[0]["COMMENT"], true);
$reply_list = json_decode($result[0]["REPLY"], true);

if (count($comment) == 0) {
	echo "そのコメントは存在しない。";
	return;
}
?>
コメント<BR>
<IMG SRC="thumbnail.php?TEXT=<?=$blog["TITLE"]?>"><BR>
<A HREF="view.php?ID=<?=$blog["ID"]?>">記事に戻る</A>
<HR>

<?php
$comment = $comment[0];
require(__DIR__."/../Component/Comment.php");
?>
<HR>

<?php require(__DIR__."/../Component/ReplyForm.php"); ?>
<HR

<?php
foreach ($comment_list as $comment) {
	require(__DIR__."/../Component/Comment.php");
}
?>

※リプは100件しか出してません