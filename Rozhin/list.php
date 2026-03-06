<?php
$stmt = $sql->prepare("SELECT * FROM `InternetRouzhinkai`;");
$stmt->execute();
$list = $stmt->fetchAll();
?>

<TABLE>
<?php
foreach ($list as $row) {
	?>
	<TR>
		<TD>
			<A HREF="/view/<?=$row["ID"]?>"><?=$row["TITLE"]?></A>
		</TD>
		<TD>
			<?=$row["DATE"]?>
		</TD>
	</TR>
	<?php
}
?>
</TABLE>