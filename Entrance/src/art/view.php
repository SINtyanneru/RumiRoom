<?php
require(__DIR__."/../../../env.php");
$query = json_decode($_GET["R"], true);

$stmt = $sql->prepare("SELECT * FROM `RUMIART_VERSION` WHERE `ID` = :id;");
$stmt->bindValue(":id", $query["ID"]);
$stmt->execute();
$version = $stmt->fetch();
if ($version == false) {
	echo "だめっぽいですね...";
	return;
}
?>

<H1>八木瑠海伸梧の代理 V<?=$version["NAME"]?></H1>
<DIV>作った日: <?=$version["CREATE_AT"]?></DIV>
<PRE><?=$version["DESCRIPTION"]?></PRE>