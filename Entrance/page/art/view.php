<?php
require(__DIR__."/../../../env.php");

$stmt = $sql->prepare("SELECT * FROM `RUMIART_VERSION` WHERE `ID` = :id;");
$stmt->bindValue(":id", $_GET["ID"]);
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