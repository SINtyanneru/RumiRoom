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
require(__DIR__."/../lib/RML/RML.php");
echo rml_to_html(htmlspecialchars($page["TEXT"]));
?>