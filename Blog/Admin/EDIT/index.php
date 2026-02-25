<?php
require("../../env.php");
require("../../session_login.php");

if ($login == false) {
	header("Location:./LOGIN/");
	exit;
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
		<LINK REL="stylesheet" HREF="https://cdn.rumia.me/CSS/reset.css">
		<LINK REL="stylesheet" HREF="<?=$__URL_PREFIX?>/STYLE/DEF.css">
		<LINK REL="stylesheet" HREF="<?=$__URL_PREFIX?>/STYLE/ITEM.css">

		<SCRIPT SRC="./SCRIPT/Main.js" defer async></SCRIPT>
		<SCRIPT SRC="https://cdn.rumia.me/LIB/RMD.js?V=LATEST" defer async></SCRIPT>

		<STYLE>
			.TAB_OWNER{
				border-top: solid 1px;
				border-bottom: solid 1px;
			}
			.TAB_EDIT{
				position: absolute;
				left: 0px;

				width: 50vw;
				height: calc(100vh - 80px);
			}

			.TAB_VIEW{
				position: absolute;
				left: 50vw;

				width: 50vw;
				height: calc(100vh - 50px);
			}

			.BLOG_TEXT_TEXTAREA{
				width: 100%;
				height: calc(100% - 24px);
			}
			.BLOG_VIEW{
				background-color: aliceblue;

				overflow: scroll;

				width: 100%;
				height: 100%;
			}

			.MSG_BOX_OWNER {
				position: absolute;
				bottom: 0px;
				left: 50%;
				transform: translate(-50%, 0);
				-webkit-transform: translate(-50%, 0);
				-ms-transform: translate(-50%, 0);
			}

			.MSG_BOX_OWNER>.MSG_BOX {
				border: solid 1px;
				border-radius: 10px;

				background-color: white;

				animation-name: MSG_BOX_FADEOUT;
				animation-duration: 3s;
				animation-direction: normal;
				animation-fill-mode: forwards;
				animation-timing-function: ease;
			}

			@keyframes MSG_BOX_FADEOUT {
				0% {
					opacity: 1;
				}

				50% {
					opacity: 1;
				}

				100% {
					opacity: 0;
				}
			}
		</STYLE>
	</HEAD>
	<BODY STYLE="background-image: url('/Asset/rumisan_room/BLOG_BG.png');">
		<H1>るみさんのブログの管理画面</H1>
		<?php
			$STMT = $PDO->prepare("SELECT * FROM `BLOG` WHERE `ID` = BINARY :ID; ");
			$STMT->bindValue(':ID', $_GET["ID"]);

			//SQL実行
			$STMT->execute();
			$BLOG_DATA = $STMT->fetchAll(PDO::FETCH_ASSOC);
			if(count($BLOG_DATA) === 1){
				$BLOG_DATA = $BLOG_DATA[0];
			}else{
				echo "無い";
				exit;
			}
		?>
		<DIV CLASS="TAB_OWNER">
			<DIV CLASS="TAB_EDIT">
				<INPUT TYPE="text" ID="BLOG_TITLE_INPUT" VALUE="<?php echo $BLOG_DATA["TITLE"]; ?>">
				<TEXTAREA CLASS="BLOG_TEXT_TEXTAREA" ID="BLOG_TEXT_TEXTAREA"><?php echo base64_decode($BLOG_DATA["TEXT"]); ?></TEXTAREA>
				<!--公開非公開のチェックマーク-->
				<?php
					if($BLOG_DATA["PUBLIC"] === "TRUE"){
						echo "<LABEL><INPUT TYPE=\"checkbox\" ID=\"PUBLIC_CHECKBOX\" checked=\"checked\">公開</LABEL>";
					}else{
						echo "<LABEL><INPUT TYPE=\"checkbox\" ID=\"PUBLIC_CHECKBOX\">公開</LABEL>";
					}
				?>
				<?php
					if($BLOG_DATA["LOCK"] === 1){
						echo "<LABEL><INPUT TYPE=\"checkbox\" ID=\"LOCK_CHECKBOX\" checked=\"checked\">ロック</LABEL>";
					}else{
						echo "<LABEL><INPUT TYPE=\"checkbox\" ID=\"LOCK_CHECKBOX\">ロック</LABEL>";
					}
				?>
				<INPUT ID="LOCK_PASS" PLACEHOLDER="パスワード">
				<!--保存ボタン-->
				<BUTTON onclick="SAVE();">保存</BUTTON>
				<!--アップロードフォーム-->
				<DIV>
					<INPUT TYPE="FILE" ID="FILE"><BUTTON onclick="FILE_UPLOAD();">アップロード</BUTTON>
					<!--アップロード後のファイル名-->
					<DIV ID=FILE_NAME STYLE="background-color: white;"></DIV>
				</DIV>
			</DIV>
			<DIV CLASS="TAB_VIEW">
				<DIV CLASS="BLOG_VIEW CONTENTS" ID="BLOG_VIEW"></DIV>
			</DIV>
		</DIV>

		<DIV CLASS="MSG_BOX_OWNER" ID="MSG_BOX_OWNER"></DIV>
	</BODY>
</HTML>