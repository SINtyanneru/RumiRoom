<?php
require(__DIR__."/../../../env.php");

$get = json_decode($_GET["R"], true);
if (!isset($get["ID"])) {
	echo "?";
	return;
}

$stmt = $sql->prepare("
SELECT
	i.*,
	u.NAME AS `AUTHOR_NAME`,
	u.FEDIVERSE AS `AUTHOR_FEDIVERSE`,
	u.PIXIV AS `AUTHOR_PIXIV`,
	u.TWITTER AS `AUTHOR_TWITTER`
FROM
	`RUMIART_ILLUST` AS i
JOIN
	`RUMIART_AUTHOR` AS u ON i.AUTHOR = u.ID
WHERE
	i.ID = :ID;
");
$stmt->bindValue(":ID", $get["ID"], PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch();

if ($result == false) {
	echo "ないです";
	http_response_code(404);
	return;
}
?>

<IMG SRC="/Asset/RumiArt/Thumbnail/<?=$result["ID"]?>.jpg" STYLE="width: auto; height: 400px;">
<DIV><?=$result["AUTHOR_NAME"]?>の作品</DIV>
<A HREF="<?=$result["URL"]?>" TARGET="_blank">オリジナルを見に行く</A>

<HR>
<DIV><?=$result["AUTHOR_NAME"]?>のアカウント</DIV>
<?php
if ($result["AUTHOR_FEDIVERSE"] != null) echo $result["AUTHOR_FEDIVERSE"];
if ($result["AUTHOR_PIXIV"] != null) echo $result["AUTHOR_PIXIV"];
if ($result["AUTHOR_TWITTER"] != null) echo $result["AUTHOR_TWITTER"];
?>