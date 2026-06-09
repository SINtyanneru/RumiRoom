<?php
require(__DIR__."/env.php");
require(__DIR__."/tool.php");

$document_title = "検索";
$document_text = "";
$$document_description = "るみのブログ";

$page_number = 0;

if (isset($_GET["P"])) {
	$page_number = intval($_GET["P"]);
}

$article_get_max = 50;
$article_get_offset = $article_get_max * $page_number;

//取得数が異常だったらリックロールする
if (isset($_GET["LIMIT"])) {
	$url_param_limit = intval($_GET["LIMIT"]);
	if ($url_param_limit != $article_get_max) {
		header("Content-Type: video/mp4");
		echo file_get_contents(__DIR__."/rick.mp4");
		exit;
	}
}

if ($_GET["MODE"] == "TITLE") {
	$script = "SELECT `ID`, `CREATE_AT`, `UPDATE_AT`, `TITLE`, `LOCK_PASSWORD`, LENGTH(`TEXT`) AS `SIZE` FROM `BLOG_ARTICLE` WHERE `IS_PUBLIC` = 1 AND `TITLE` LIKE :query ORDER BY `CREATE_AT` DESC LIMIT :limit OFFSET :offset;";
	$stmt = $sql->prepare($script);
	$stmt->bindValue(":limit", $article_get_max, PDO::PARAM_INT);
	$stmt->bindValue(":offset", $article_get_offset, PDO::PARAM_INT);
	$stmt->bindValue(":query", "%".$_GET["Q"]."%", PDO::PARAM_STR);
	$stmt->execute();
	$article_list = $stmt->fetchAll();
} else if ($_GET["MODE"] == "TEXT") {
	$script = "SELECT `ID`, `CREATE_AT`, `UPDATE_AT`, `TITLE`, `LOCK_PASSWORD`, LENGTH(`TEXT`) AS `SIZE` FROM `BLOG_ARTICLE` WHERE `IS_PUBLIC` = 1 AND `TEXT` LIKE :query ORDER BY `CREATE_AT` DESC LIMIT :limit OFFSET :offset;";
	$stmt = $sql->prepare($script);
	$stmt->bindValue(":limit", $article_get_max, PDO::PARAM_INT);
	$stmt->bindValue(":offset", $article_get_offset, PDO::PARAM_INT);
	$stmt->bindValue(":query", "%".$_GET["Q"]."%", PDO::PARAM_STR);
	$stmt->execute();
	$article_list = $stmt->fetchAll();
} else if ($_GET["MODE"] == "TAG") {
	$script = "SELECT `ARTICLE` FROM `BLOG_TAG` WHERE `NAME` = :query LIMIT :limit;";
	$stmt = $sql->prepare($script);
	$stmt->bindValue(":limit", $article_get_max, PDO::PARAM_INT);
	$stmt->bindValue(":query", $_GET["Q"], PDO::PARAM_STR);
	$stmt->execute();
	$tag_article_list = $stmt->fetchAll();
	$stmt->closeCursor();

	$article_list = [];

	foreach ($tag_article_list as $tag_article) {
		$script = "SELECT `ID`, `CREATE_AT`, `UPDATE_AT`, `TITLE`, `LOCK_PASSWORD`, LENGTH(`TEXT`) AS `SIZE` FROM `BLOG_ARTICLE` WHERE `ID` = :id;";
		$stmt = $sql->prepare($script);
		$stmt->bindValue(":id", $tag_article["ARTICLE"], PDO::PARAM_STR);
		$stmt->execute();
		$article_list[] = $stmt->fetch();
		$stmt->closeCursor();
	}
} else {
	return;
}

ob_start();

?>
<TABLE>
	<?php
	foreach ($article_list as $article) {
		?>
		<TR>
			<TD>
				<A HREF="view.php?ID=<?=$article["ID"]?>">
					<?=$article["TITLE"]?>
				</A>
			</TD>
			<TD>...<?=convert_byte($article["SIZE"])?></TD>
		</TR>
		<?php
	}
	?>
</TABLE>

<DIV STYLE="margin: auto; width: fit-content;">
	<!--戻る-->
	<?php
	if ($page_number != 0) {
		?>
		<A HREF="?P=<?=$page_number - 1?>&LIMIT=<?=$article_get_max?>"><BUTTON>←</BUTTON></A>
		<?php
	}
	?>

	<!--今-->
	<SPAN><?=$page_number?></SPAN>

	<!--進む-->
	<?php
	if (count($article_list) >= $article_get_max) {
		?>
		<A HREF="?P=<?=$page_number + 1?>&LIMIT=<?=$article_get_max?>"><BUTTON>→</BUTTON></A>
		<?php
	}
	?>
</DIV>
<?php

$document_text .= "\n";
$document_text .= ob_get_clean();

require(__DIR__."/layout.php");