<?php
$SQL_GET_LIMIT = 50;
$page = 0;

if (isset($_GET["PAGE"])) {
	$page = intval($_GET["PAGE"]) - 1;
}

if (isset($_GET["VIEW"])) {
	if (intval($_GET["VIEW"]) !== $SQL_GET_LIMIT) {
		?>
		<VIDEO SRC="<?=$__URL_PREFIX?>/rick.mp4"></VIDEO>
		<?php
		return;
	}
}
?>

るみさんのブログv3<BR>
3度目の正直...<BR>
<BR><BR>

<HR>
<?php
	$stmt = $PDO->prepare(<<<TEXT
		SELECT
			`ID`,
			`TITLE`,
			`PUBLIC`,
			`LOCK`,
			`TAG`,
			`UPDATE`,
			LENGTH(TEXT) AS BYTE_LENGTH
		FROM
			`BLOG`
		WHERE
			`PUBLIC` = 1
		ORDER BY
			`BLOG`.`DATE` DESC LIMIT :LIMIT OFFSET :OFFSET;
	TEXT);

	$offset = $SQL_GET_LIMIT * $page;
	$stmt->bindParam("LIMIT", $SQL_GET_LIMIT, PDO::PARAM_INT);
	$stmt->bindParam("OFFSET", $offset, PDO::PARAM_INT);

	//SQL実行
	$stmt->execute();
	$blog_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($blog_list as $row) {
		?>
		<DIV>
			<SPAN>
			<?php
			if ($row["LOCK"] == 1) {
				echo "[鍵]";
			}
			?>
			</SPAN>
			<SPAN><A HREF="view.php?ID=<?=$row["ID"]?>"><?=$row["TITLE"]?></A></SPAN>
			<SPAN>...<?=floor($row["BYTE_LENGTH"] / 1024)?>KB</SPAN>
		</DIV>
		<?php
	}
?>
<HR>

<DIV STYLE="text-align: center;">
	<?php
	if ($page != 0) {
		?> <A HREF="?PAGE=<?=$page?>&VIEW=<?=$SQL_GET_LIMIT?>">←</A> <?php
	}

	echo "[".($page+1)."]";

	if (count($blog_list) >= $SQL_GET_LIMIT) {
		?> <A HREF="?PAGE=<?=$page+2?>&VIEW=<?=$SQL_GET_LIMIT?>">→</A> <?php
	}
	?>
</DIV>