<?php
require(__DIR__."/env.php");
require(__DIR__."/tool.php");

$article_id = $_GET["ID"];

$stmt = $sql->prepare("SELECT * FROM `BLOG_ARTICLE` WHERE `ID` = :id;");
$stmt->bindValue(":id", $article_id, PDO::PARAM_STR);
$stmt->execute();
$article = $stmt->fetch();

$document_title = $article["TITLE"];
$document_text = "";
$document_description = $article["TITLE"];

$thumbnail_url = "https://blog.rumi-room.net/thumbnail.php?ID=".$article["ID"];

ob_start();

?>
<TABLE>
	<TR>
		<TD>Date====</TD>
		<TD>Time====</TD>
		<TD>Update====</TD>
		<TD>Time====</TD>
		<TD>Title====</TD>
		<TD>[[W]WRITE [RET]READ [?]HELP]</TD>
	</TR>
	<TR>
		<TD><?=explode(" ", $article["CREATE_AT"])[0]?></TD>
		<TD><?=explode(" ", $article["CREATE_AT"])[1]?></TD>
		<TD><?=explode(" ", $article["UPDATE_AT"])[0]?></TD>
		<TD><?=explode(" ", $article["UPDATE_AT"])[1]?></TD>
		<TD COLSPAN="2"><?=$article["TITLE"]?></TD>
	</TR>
</TABLE>

<DIV>
	<PRE>TEXT FILE (<?=str_pad(convert_byte(strlen($article["TEXT"])), 7, " ", STR_PAD_LEFT)?> ) を受信しますか？ [Y]/[N] > Y</PRE>
</DIV>

<BR>

<DIV>
	<?php
	$stmt = $sql->prepare("SELECT `NAME` FROM `BLOG_TAG` WHERE `ARTICLE` = :article;");
	$stmt->bindValue(":article", $_GET["ID"], PDO::PARAM_STR);
	$stmt->execute();
	$tag_list = $stmt->fetchAll();
	$stmt->closeCursor();
	foreach ($tag_list as $tag) {
		?>
		<A HREF="/search.php?Q=<?=$tag["NAME"]?>&MODE=TAG"><?=$tag["NAME"]?></A>
		<?php
	}
	?>
</DIV>

<BR>

<!--本文-->
<DIV>
	<?php
	$ajax = curl_init("http://192.168.0.128/RML/");
	curl_setopt($ajax, CURLOPT_POST, true);
	curl_setopt($ajax, CURLOPT_POSTFIELDS, $article["TEXT"]);
	curl_setopt($ajax, CURLOPT_RETURNTRANSFER, true);
	$html = curl_exec($ajax);
	echo $html;
?>
</DIV>

<?php

$document_text .= "\n";
$document_text .= ob_get_clean();

require(__DIR__."/layout.php");