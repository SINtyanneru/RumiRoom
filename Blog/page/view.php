<?php
require("https://cdn.rumia.me/LIB/RMDParser.php?V=LATEST");

if (isset($_GET["ID"]) == false) {
	echo "？";
	http_response_code(410);
} else {
	$stmt = $PDO->prepare(<<<TEXT
		SELECT
			*
		FROM
			`BLOG`
		WHERE
			`PUBLIC` = 1
		AND
			`ID` = :ID;
	TEXT);

	$offset = $SQL_GET_LIMIT * $page;
	$stmt->bindParam("ID", $_GET["ID"], PDO::PARAM_STR);

	//SQL実行
	$stmt->execute();
	$blog_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if (count($blog_list) == 0) {
		?>
		記事が無いです。
		<?php
	} else {
		$blog = $blog_list[0];

		$document_data["TITLE"] = $blog["TITLE"];
		$document_data["BLOG"] = $blog["TITLE"];

		if ($blog["LOCK"] == 1) {
			echo "非公開";
			return;
		}
		?>
		<!--<CENTER><IMG SRC="thumbnail.php?TEXT=<?=$blog["TITLE"]?>"></CENTER>-->
		<H1><?=htmlspecialchars($blog["TITLE"])?></H1>

		<TABLE>
			<TR>
				<TD>作成日</TD>
				<TD><?=$blog["DATE"]?></TD>
			</TR>
			<TR>
				<TD>最新更新日</TD>
				<TD><?=$blog["UPDATE"]?></TD>
			</TR>
		</TABLE>

		<?php
		foreach(explode("/", $blog["TAG"]) as $tag) {
			?> <A>#<?=htmlspecialchars($tag)?></A> <?php
		}
		?>
		<HR>

		<DIV CLASS="BLOG_CONTENTS">
			<?php
			$rmd = new RMD(base64_decode($blog["TEXT"]));
			echo $rmd->to_html();
			?>
		</DIV>
		<HR>

		<DIV>
			<?php
			$blog_url = "https://".$__DOMAIN.$__URL_PREFIX."/view.php?ID=".$blog["ID"];
			?>
			<A HREF="https://misskey-hub.net/share/?text=るみさんのブログより「<?=$blog["TITLE"]?>」&url=<?=$blog_url?>&visibility=public&localOnly=0&manualInstance=eth.rumiserver.com" target="_blank"><IMG SRC="/Asset/Share/Misskey_BG.png"></A>
			<A HREF="https://twitter.com/share?url=<?=$blog_url?>&text=るみさんのブログより「<?=$blog["TITLE"]?>」"><IMG SRC="/Asset/Share/Twitter_BG.png" target="_blank"></A>
			<A HREF="https://donshare.net/share.html?text=るみさんのブログより「<?=$blog["TITLE"]?>」&url=<?=$blog_url?>"><IMG SRC="/Asset/Share/Mastodon_BG.png" target="_blank"></A>
		</DIV>

		<HR>

		<DIV>
			<?php require(__DIR__."/../Component/CommentForm.php"); ?>
		</DIV>

		<DIV CLASS="COMMENT_LIST">
			<?php
			//コメント一覧習得
			$stmt = $PDO->prepare("SELECT * FROM `BLOG_COMMENT` WHERE `BLOG_ID` = BINARY :ID AND `REPLY` IS NULL LIMIT 10;");
			$stmt->bindValue(':ID', $blog["ID"]);
			$stmt->execute();
			$comment_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($comment_list as $comment) {
				require(__DIR__."/../Component/Comment.php");
			}
			?>
			<A HREF="comment_list.php?ID=<?=$blog["ID"]?>">全てのコメントを見る</A>
		</DIV>

		<?php
	}
}
?>