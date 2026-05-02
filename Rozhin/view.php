<?php
$id = str_replace("/view/", "", $path);

$stmt = $sql->prepare("SELECT * FROM `InternetRouzhinkai` WHERE `ID` = :ID;");
$stmt->bindValue(":ID", $id, PDO::PARAM_STR);
$stmt->execute();
$page = $stmt->fetch();
if ($page == false) {
	echo "記事がありません";
	return;
}

?>
<A HREF="/">トップへ</A>
<H2><?=htmlspecialchars($page["TITLE"])?></H2>
<DIV><?=$page["DATE"]?></DIV>
<BR>

<?php
$text = $page["TEXT"];
$ajax = curl_init("http://192.168.0.128/RML/");
curl_setopt($ajax, CURLOPT_POST, true);
curl_setopt($ajax, CURLOPT_POSTFIELDS, $text);
curl_setopt($ajax, CURLOPT_RETURNTRANSFER, true);
$html = curl_exec($ajax);
echo $html;
?>