<?php
session_start();

//いんくるーど
require("../env.php");
require("../session_login.php");

if ($login == false) {
	header("Location:./LOGIN/");
}

//数字を4点区切りに
function BAIT_CONV($SIZE){
	$EINHEIT = "B";
	if($SIZE >= 1000){
		$SIZE = floor($SIZE / 1000);
		$EINHEIT = "KB";
	}else{
		$SIZE = floor($SIZE);
	}

	$SIZE =  preg_replace('/\B(?=(\d{4})+(?!\d))/', ',', $SIZE);

	$SIZE = $SIZE.$EINHEIT;

	return $SIZE;
}
?>
<!DOCTYPE html>
<HTML>
	<HEAD>
		<TITLE>るみさんのブログの管理画面</TITLE>

		<!--CSS-->
		<LINK REL="stylesheet" HREF="/reset.css">
		<LINK REL="stylesheet" HREF="<?php echo $__URL_PREFIX; ?>/STYLE/DEF.css">
	</HEAD>
	<BODY STYLE="background-image: url('/Asset/rumisan_room/BLOG_BG.png');">
		<H1>るみさんのブログの管理画面</H1>
		<HR>
		<DIV>
			<A HREF="./CREATE/">記事を新規作成</A>
		</DIV>
		<HR>
		<?php
			//SELECT文を変数に格納
			$STMT = $PDO->prepare("SELECT `DATE`, `ID`, `TITLE`, `PUBLIC`, `TAG`, LENGTH(TEXT) AS BYTE_LENGTH FROM `BLOG` ORDER BY `BLOG`.`DATE` DESC");
			//SQL実行
			$STMT->execute();
			$BLOG_LIST = $STMT->fetchAll(PDO::FETCH_ASSOC);

			echo "<TABLE>\n";
			foreach($BLOG_LIST as $ROW){
				echo "<TR>\n".
						/*"<TD><IMG SRC=\"/sinch/Blog/BlogThumbnail.php?TEXT=".$ROW["TITLE"]."\"></TD>\n".*/
						"<TD>".$ROW["TITLE"]."</TD>\n".
						"<TD>".BAIT_CONV($ROW["BYTE_LENGTH"])."</TD>\n".
						"<TD><A HREF=\"./EDIT/?ID=".$ROW["ID"]."\">編集</A></TD>\n".
					"</TR>\n";
			}
			echo "</TABLE>\n";
		?>
	</BODY>
</HTML>