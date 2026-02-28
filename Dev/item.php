<?php
$stmt = $sql->prepare("
SELECT
	i.*,
	g.NAME AS `GENRE_NAME`
FROM
	`DEV_ITEM` AS i
JOIN
	`DEV_GENRE` AS g
	ON g.ID = i.GENRE
WHERE
	i.ID = :ID;
");
$stmt->bindValue(":ID", $item_id, PDO::PARAM_INT);
$stmt->execute();
$item = $stmt->fetch();

if ($item == false) {
	echo "ありません。";
	return;
}

$stmt = $sql->prepare("
SELECT
	u.*
FROM
	`DEV_URL` AS u
WHERE
	u.ITEM = :ID;
");
$stmt->bindValue(":ID", $item_id, PDO::PARAM_INT);
$stmt->execute();
$url_list = $stmt->fetchAll();

$stmt = $sql->prepare("
SELECT
	f.*
FROM
	`DEV_FILE` AS f
WHERE
	f.ITEM = :ID;
");
$stmt->bindValue(":ID", $item_id, PDO::PARAM_INT);
$stmt->execute();
$download_list = $stmt->fetchAll();
?>

<?=$item["GENRE_NAME"]?>/<?=$item["TITLE"]?>

<HR>

<?=nl2br(htmlspecialchars($item["DESCRIPTION"]))?>

<BR>

<?php
if ($item["DETAIL_URL"] != null) {
	?>
	<A HREF="<?=htmlspecialchars($item["DETAIL_URL"])?>">詳細はこちら</A>
	<?php
}
?>

<BR>

<H3>URL</H3>
<?php
foreach ($url_list as $url) {
	?>
	<A HREF="<?=$url["URL"]?>" TARGET="_blank"><?=$url["NAME"]?></A>
	<?php
}
?>

<H3>ダウンロード</H3>
<TABLE STYLE="width: fit-content; height: fit-content; margin: auto;">
	<?php
	foreach ($download_list as $dl) {
		?>
		<TR>
			<TD>
				<IMG SRC="/Asset/Dev/OS/<?=$dl["OS"]?>">
			</TD>
			<TD>
				<?php
				if ($dl["OS_VERSION"] != null) echo $dl["OS_VERSION"];
				?>
			</TD>
			<TD>
				<A HREF="<?=$dl["URL"]?>"><?=$dl["NAME"]?></A>
			</TD>
			<TD>
				<?php
				$img_src = "/icons/unknown.gif";
				switch ($dl["TYPE"]) {
					case "application/zip":
						$img_src = "/icons/compressed.png";
						break;
				}
				?>
				<IMG SRC="<?=$img_src?>" ALT="<?=$dl["TYPE"]?>" TITLE="<?=$dl["TYPE"]?>">
			</TD>
		</TR>
		<?php
	}
	?>
</TABLE>