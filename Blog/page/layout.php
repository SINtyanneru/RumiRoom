<?php
require("https://cdn.rumia.me/LIB/OGP.php?V=LATEST");
require(__DIR__."/../env.php");
require(__DIR__."/../session_login.php");

session_start();

$document_data = [
	"TITLE" => null,
	"DESC" => "あ",
	"BLOG" => null
];

ob_start();

if (isset($PAGE_MODE) == false) {
	?> <FONT COLOR="RED">コードエラー</FONT> <?php
}

switch ($PAGE_MODE) {
	case "HOME":
		require(__DIR__."/home.php");
		break;
	case "VIEW":
		require(__DIR__."/view.php");
		break;
	case "COMMENT_LIST":
		require(__DIR__."/comment_list.php");
		break;
	case "COMMENT":
		require(__DIR__."/comment.php");
		break;

	default:
		require(__DIR__."/404.html");
		break;
}

$content = ob_get_clean();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
	<HEAD>
		<TITLE><?php
			echo $__BLOG_NAME;
			if (isset($document_data["TITLE"])) {
				echo " | ".$document_data["TITLE"];
			}
		?></TITLE>

		<?php
			$OGP = new OGP_PHP();
			$OGP->SET_TYPE(false);

			$OGP->SET_PAGENAME("るみさんのブログ");
			$OGP->SET_TITLE($document_data["TITLE"]);
			$OGP->SET_DESC($document_data["DESC"]);

			$OGP->SET_TWITTER_USER("@RUMI_SYSTEM32");
			$OGP->SET_RSV_USER("@Rumisan");
			$OGP->SET_RSV_USER("@Rumisan");
			$OGP->SET_MISSKEY_USER("@rumisan@eth.rumiserver.com");

			if(isset($document_data["BLOG"])){
				$OGP->SET_IMAGE("https://".$__DOMAIN.$__URL_PREFIX."/thumbnail.php?TEXT=".$document_data["BLOG"]);
			} else {
				$OGP->SET_IMAGE("https://".$__DOMAIN.$__URL_PREFIX."/Asset/P_20230401_124955.png");
			}
			$OGP->BUILD();
		?>

		<!--ビューポート-->
		<META NAME="viewport" CONTENT="width=device-width, initial-scale=1" />

		<!--CSS-->
		<LINK REL="stylesheet" HREF="https://cdn.rumia.me/CSS/reset.css">
		<LINK REL="stylesheet" HREF="https://cdn.rumia.me/CSS/DEFAULT.css">

		<!--CSS-->
		<LINK REL="stylesheet" HREF="<?=$__URL_PREFIX?>/Style/Main.css">
		<LINK REL="stylesheet" HREF="<?=$__URL_PREFIX?>/Style/Comment.css">
		<LINK REL="stylesheet" HREF="<?=$__URL_PREFIX?>/Style/Item.css">
	</HEAD>
	<BODY>
		<DIV CLASS="MAIN">
			<DIV CLASS="HEADER">
				<A HREF="<?=$__URL_PREFIX?>" CLASS="IMG">
					<IMG SRC="<?=$__URL_PREFIX?>/Asset/a.png">
				</A>

				<DIV>
					<A HREF="rss_jarikata.php"><IMG SRC="<?=$__URL_PREFIX?>/Asset/rss.png" STYLE="width: 45px; height: 45px;"></A>
					<?php
					if (!$login) {
						?> <A HREF="login.php">ログイン</A> <?php
					}
					?>
				</DIV>
			</DIV>

			<DIV CLASS="CONTENTS">
				<?=$content?>
				<!--↓CSS書くのがめんどいので無理やりマージン-->
				<BR>
			</DIV>
		</DIV>
	</BODY>
</HTML>