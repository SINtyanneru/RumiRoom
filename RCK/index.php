<?php
require_once(__DIR__."/../env.php");
require_once(__DIR__."/../lib/SizeiB/convert_byte.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML LANG="ja-jp">
	<HEAD>
		<TITLE>RCK</TITLE>
	</HEAD>
	<BODY>
		<H1>Index of /RCK</H1>

		<A HREF="https://rumi-room.net/"><IMG SRC="/Asset/Haiku/png/32x32/Action_GoHome_2.png" ALT="ホームに戻る"></A>

		<TABLE>
			<TR>
				<TH></TH>
				<TH>番号</TH>
				<TH>名称</TH>
				<TH>最新バージョン</TH>
				<TH>サイズ</TH>
			</TR>
			<TR>
				<TH COLSPAN="4"><HR></TH>
			</TR>
			<?php
				$stmt = $sql->prepare("SELECT * FROM `RCK_ARTICLE` ORDER BY `ID` DESC;");
				$stmt->execute();
				$article_list = $stmt->fetchAll();

				foreach ($article_list as $article) {
					$stmt = $sql->prepare("SELECT `ID`, `VERSION`, `CREATE_AT`, LENGTH(`TEXT`) AS `SIZE` FROM `RCK_VERSION` ORDER BY `CREATE_AT` DESC LIMIT 1;");
					$stmt->execute();
					$latest_version = $stmt->fetch();
					?>
					<TR>
						<?php
						if ($article["IS_DISCONTINUED"] == 1) {
							echo "<TD>[廃止]</TD>";
						} else {
							echo "<TD></TD>";
						}
						?>
						<TD><A HREF="view.php?RCK=<?=htmlspecialchars($article["ID"])?>&V=<?=htmlspecialchars($latest_version["ID"])?>">RCK-<?=htmlspecialchars($article["ID"])?></A></TD>
						<TD><A HREF="view.php?RCK=<?=htmlspecialchars($article["ID"])?>&V=<?=htmlspecialchars($latest_version["ID"])?>"><?=htmlspecialchars($article["TITLE"])?></A></TD>
						<TD><?=htmlspecialchars($latest_version["CREATE_AT"])?></TD>
						<TD><?=htmlspecialchars(convert_byte($latest_version["SIZE"]))?></TD>
					</TR>
					<?php
				}
			?>
			<TR>
				<TH COLSPAN="4"><HR></TH>
			</TR>
		</TABLE>
	</BODY>
</HTML>