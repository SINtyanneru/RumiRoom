<?php
require(__DIR__."/session_login.php");
?>
<!DOCTYPE html>
<HTML>
	<HEAD>
		<TITLE>るみさんのブログ 管理画面</TITLE>
	</HEAD>
	<BODY>
		<H1>るみさんのブログ - 管理画面</H1>
		<DIV>ようこそ<?=htmlspecialchars($user["NAME"])?>さん</DIV>

		<FORM METHOD="post" ACTION="create.php">
			<INPUT TYPE="text" NAME="TITLE" PLACEHOLDER="タイトル">
			<INPUT TYPE="text" NAME="TAG" PLACEHOLDER="タグ(スラッシュ区切り)">
			<INPUT TYPE="text" NAME="PASSWORD" PLACEHOLDER="閲覧パスワード(空欄OK)">
			<BUTTON>記事を作成</BUTTON>
		</FORM>

		<TABLE>
			<TR>
				<TH>タイトル</TH>
				<TH>投稿日時</TH>
				<TH>最終更新日時</TH>
				<TH>操作</TH>
			</TR>
			<?php
			$stmt = $sql->prepare("SELECT * FROM `BLOG_ARTICLE` ORDER BY `CREATE_AT` DESC;");
			$stmt->execute();
			$article_list = $stmt->fetchAll();
			foreach ($article_list as $article) {
				?>
				<TR>
					<TD><?=htmlspecialchars($article["TITLE"])?></TD>
					<TD><?=htmlspecialchars($article["CREATE_AT"])?></TD>
					<TD><?=htmlspecialchars($article["UPDATE_AT"])?></TD>
					<TD>
						<A HREF="edit/"><BUTTON>編集</BUTTON></A>
					</TD>
				</TR>
				<?php
			}
			?>
		</TABLE>
	</BODY>
</HTML>