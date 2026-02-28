<?php
$stmt = $sql->prepare("
SELECT
	g.*
FROM
	`DEV_GENRE` AS g
WHERE
	g.ID = :ID;
");
$stmt->bindValue(":ID", $genre_id, PDO::PARAM_INT);
$stmt->execute();
$genre = $stmt->fetch();

if ($genre == false) {
	echo "ジャンルが存在しません。";
	return;
}
?>
<IMG SRC="/Asset/Dev/Genre/<?=$genre["ID"]?>.gif">
<DIV>
	<?=$genre["DESCRIPTION"]?>
</DIV>

<BR>

<DIV>
	<?php
	$stmt = $sql->prepare("
	SELECT
		i.*
	FROM
		`DEV_ITEM` AS i
	WHERE
		i.GENRE = :GENRE;
	");
	$stmt->bindValue(":GENRE", $genre_id, PDO::PARAM_INT);
	$stmt->execute();

	foreach ($stmt->fetchAll() as $row) {
		?>
		<A HREF="/item/<?=$genre_id?>/<?=$row["ID"]?>"><?=$row["TITLE"]?></A>
		<?php
	}
	?>
</DIV>