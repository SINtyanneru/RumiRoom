<A HREF="/art/shiryou.html" TARGET="_parent">代理の資料はこちら</A><BR>
私怨絵は#るみあーとでFediverseに投稿してね★<BR>
連絡してくれたらここに掲載するよ(画質を絶望的に落とします)<BR>
※掲載削除依頼も連絡フォームからお願いします<BR>

<HR>
<?php
require(__DIR__."/../../../env.php");

$stmt = $sql->prepare("
SELECT
	i.*,
	u.NAME AS `AUTHOR`
FROM
	`RUMIART_ILLUST` AS i
JOIN
	`RUMIART_AUTHOR` AS u ON i.AUTHOR = u.ID
ORDER BY
	i.DATE DESC;
");
$stmt->execute();
$art_list = $stmt->fetchAll();
?>

<TABLE BORDER="1">
	<?php
	foreach ($art_list as $art) {
		?>
		<TR>
			<TD>
				<IMG SRC="/Asset/RumiArt/Thumbnail/<?=$art["ID"]?>.jpg">
			</TD>
			<TD>
				<A HREF="/art/view.php?ID=<?=$art["ID"]?>" TARGET="_parent">
					<?=htmlspecialchars($art["AUTHOR"])?>の作品
				</A>
			</TD>
			<TD>
				<?=$art["DATE"]?>
			</TD>
		</TR>
		<?php
	}
	?>
</TABLE>

<STYLE>
	tr > td > img{
		width: 128px;
		height: auto;
	}
</STYLE>