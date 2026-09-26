<H1>八木瑠海伸梧の代理</H1>

私怨絵は#るみあーとでFediverseに投稿してね★<BR>
代理はv2.x.x-Nを主に使っています<BR>
<BR>

<?php
require(__DIR__."/../../../env.php");

$stmt = $sql->prepare("SELECT `ID`, `NAME`, `CREATE_AT` FROM `RUMIART_VERSION` ORDER BY `ID` DESC;");
$stmt->execute();
$version_list = $stmt->fetchAll();
?>

<TABLE>
	<TR>
		<TH>バージョン</TH>
	</TR>
	<?php
	foreach ($version_list as $version) {
		?>
			<TR>
				<TD>
					<A HREF="/art/view.php?ID=<?=$version["ID"]?>" TARGET="_parent"><?=$version["NAME"]?></A>
				</TD>
				<TD>
					<?=$version["CREATE_AT"]?>
				</TD>
			</TR>
		<?php
	}
	?>
</TABLE>