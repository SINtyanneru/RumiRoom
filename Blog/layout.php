<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
	<HEAD>
		<TITLE><?=htmlspecialchars($document_title)?> るみさんのブログ</TITLE>

		<?php
		if (empty($document_title)) $document_title = "無";
		if (empty($document_description)) $document_description = "無";
		if (empty($document_text)) $document_text = "無";
		?>

		<META PROPERTY="og:type" CONTENT="website" />
		<META PROPERTY="og:title" CONTENT="<?=htmlspecialchars($document_title)?>" />
		<META PROPERTY="og:site_name" CONTENT="るみさんのブログ" />
		<META PROPERTY="og:description" CONTENT="<?=htmlspecialchars($document_description)?>" />
		<META NAME="description" CONTENT="<?=htmlspecialchars($document_description)?>" />
		<?php
		if (isset($thumbnail_url)) {
			?>
			<META PROPERTY="og:image" CONTENT="<?=htmlspecialchars($thumbnail_url)?>" />
			<META PROPERTY="twitter:card" CONTENT="summary_large_image" />
			<?php
		}
		?>
		<META PROPERTY="twitter:site" CONTENT="RUMI_SYSTEM32" />
		<META PROPERTY="rsv:site" CONTENT="Rumisan" />
		<META PROPERTY="misskey:site" CONTENT="rumisan@eth.rumiserver.com" />

		<STYLE>
			body{
				background-color: burlywood;
				background-image: url("/Asset/bg.png");
			}

			.MAIN{
				margin: auto;

				width: 50vw;
				min-width: 500px;
				max-width: 800px;

				background-color: whitesmoke;

				overflow-x: hidden;
				overflow-y: scroll;
			}

			.MAIN > .TITLE{
				background-image: url("/Asset/a.png");

				width: 800px;
				height: 251px;
			}

			.MAIN > .TITLE > a > img{
				width: 100%;
				height: auto;
			}

			.MAIN > .CONTENTS{
				padding: 10px;
			}

			img[class="RML"] {
				width: 100%;
			}
		</STYLE>
	</HEAD>
	<BODY>
		<DIV CLASS="MAIN">
			<!--ヘッダー-->
			<DIV CLASS="TITLE">
				<A HREF="/">
					<IMG SRC="/Asset/LETTER_BK.png">
				</A>
			</DIV>

			<!--ボタン類-->
			<DIV>
				<A HREF="RSS.php">RSS</A>

				<?php
				if ($__is_over_tls) {
					require(__DIR__."/user/session_login.php");
					$login = login();
					if ($login == false) {
						?>
						<A HREF="/user/login/">ログイン</A>
						<?php
					} else {
						?>
						<A HREF="/user/"><?=htmlspecialchars($login["NAME"])?></A>
						<?php
						if ($login["IS_ADMIN"] == 1) {
							?>
							<A HREF="/admin/">管理ページ</A>
							<?php
						}
					}
				}
				?>
			</DIV>

			<!--本体-->
			<DIV CLASS="CONTENTS">
				<?=$document_text?>
			</DIV>
		</DIV>
	</BODY>
</HTML>