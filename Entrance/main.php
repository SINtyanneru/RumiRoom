<?php
declare(strict_types=1);

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

require_once(__DIR__."/../env.php");
require_once(__DIR__."/src/page.php");
require_once(__DIR__."/src/path.php");
require_once(__DIR__."/src/const.php");
require_once(__DIR__."/../OGP.php");
require_once(__DIR__."/src/device_check.php");

if (is_smartphone()) {
	header("Location: /imode/", true, 302);
	exit;
}


//↓Tor
header("onion-location: http://rumi32qpqupmml55krw75ue522lxhei2g2gmq2ktyzvlb6os3vd4beqd.onion/");

//-----------------------------------------------------------------------------------------------------------

//トップページ
page_add(new Page("/main.php", __DIR__."/page/top.php", "トップ", "とっぷちんちん", true, "Action_GoHome_2"));

//プロフィール
page_add(new Page("/profile.html", __DIR__."/page/profile.php", "わたしについて", "八木瑠海伸梧とかいう物体について", true, "File_Person"));

//貴様について
page_add(new Page("/ÉG ER ALLTAF AÐ FYLGJAST MEÐ ÞÉR", __DIR__."/page/you_info.php", "貴様について", "死なす。", true, "App_People"));

//SNS
page_add(new Page("/sns.html", __DIR__."/page/sns.php", "SNS", "八木瑠海伸梧とかいう物体がやってるSNS", true, "Misc_Antenna"));

//時計
page_add(new Page("/clock", __DIR__."/page/clock.php", "時計", "時計です", true, "App_Clock"));

//代理
page_add(new Page("/art", __DIR__."/page/art/index.php", "代理", "#るみあーと", true, null));
page_add(new Page("/art/view.php", __DIR__."/page/art/view.php", "代理", "#るみあーと", false, null));

//ブログ
page_add(new Page("https://blog.rumi-room.net/", null, "ブログ", "", true, "App_StyledEdit"));

//ラボ
page_add(new Page("https://dev.rumi-room.net/", null, "ラボ", "", true, "Folder_prefs"));

//物置部屋
page_add(new Page("https://etc.rumi-room.net/", null, "物置部屋", "", true, "App_HaikuDepot"));

//インターネット老人会 愛媛支部
page_add(new Page("https://rozhin.rumi-room.net/", null, "インターネット老人会 愛媛支部", "", true, "Misc_R.I.P"));

//お布施
page_add(new Page("/ohuse.html", __DIR__."/page/ohuse.html", "支援", "", true, "App_Finance"));

//連絡先
page_add(new Page("https://form.rumia.me/contact/?to=RUMI", null, "連絡フォーム", "", true, "File_Mail_label"));

//ライセンス
page_add(new Page("/license", __DIR__."/page/license/index.html", "ライセンス", "ライセンスです", true, "File_SourceCode"));
page_add(new Page("/license/PSS/", __DIR__."/page/license/PSS/index.php", "るみのパブリックソースソフトウェアライセンス", "るみのパブリックソースソフトウェアライセンス", false, null));
page_add(new Page("/license/CSS/", __DIR__."/page/license/CSS/index.php", "るみのクローズドソースライセンス", "るみのクローズドソースライセンス", false, null));


//好きなイラスト
page_add(new Page("/favorite_illust.php", __DIR__."/page/favorite_illust.php", "好きなイラスト", "好きなイラスト", false, null));

//-----------------------------------------------------------------------------------------------------------
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML LANG="ja-jp">
	<HEAD>
		<TITLE>るみさんのお部屋</TITLE>

		<?php
			$page = page_get_from_url($cur_path);
			if ($page == null) {
				http_response_code(404);
				echo "ページが見つかりません。";
				return;
			}

			ogp("るみさんのお部屋", $page->title, $page->description);
		?>

		<META NAME="theme-color" CONTENT="#00A3AF">
		<LINK REL="me" HREF="https://eth.rumiserver.com/@rumisan">

		<?php
			$bgm_enable = true;
			$bgm_volume = 0.5;

			if (empty($_COOKIE[BGM_SETTING_COOKIE]) == false) {
				$setting = json_decode($_COOKIE[BGM_SETTING_COOKIE], true);
				$bgm_enable = $setting["ENABLE"];
				$bgm_volume = $setting["VOLUME"];
			}

			if ($bgm_enable) {
				$bgm = "/bgm_get.php?a=".uniqid();

				if (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE") !== false || strpos($_SERVER["HTTP_USER_AGENT"], "Trident") !== false) {
					//IE
					echo "<BGSOUND LOOP=\"infinite\" SRC=\"".$bgm."\">";
				} else {
					//それ以外
					?>
					<SCRIPT>
						window.addEventListener("load", (E)=>{
							let seek = 0;
							const cookie = document.cookie.split(";");
							for (const c of cookie) {
								const parts = c.split("=");
								const key = parts[0];
								const value = parts[1];
								if (key === "<?=BGM_SEEK_COOKIE?>") {
									seek = Number.parseFloat(value);
								}
							}

							let BGSOUND = document.createElement("AUDIO");
							BGSOUND.src = "<?=$bgm?>";
							BGSOUND.autoplay = true;
							BGSOUND.loop = true;
							BGSOUND.volume = <?=$bgm_volume?>;
							BGSOUND.currentTime = seek;
							document.body.appendChild(BGSOUND);

							BGSOUND.addEventListener("timeupdate", function() {
								document.cookie = `<?=BGM_SEEK_COOKIE?>=${BGSOUND.currentTime}`;
							});
						});
					</SCRIPT>
					<?php
				}
			}
		?>

		<STYLE>
			html, body{
				margin: 0px !important;
				padding: 0px !important;
				height: 100% !important;

				overflow: hidden !important;
			}

			body{
				background-image: url("/Asset/Entrance_Bg.png") !important;
			}

			.MAIN_TABLE{
				width: 100% !important;
				height: 100% !important;

				border-collapse: collapse !important;
			}

			.HEADER_TD, .MENU_TD, .CONTENTS_TD {
				vertical-align: top !important;
				text-align: left !important;

				padding: 10px !important;
			}

			.MENU_TD, .CONTENTS_TD{
				position: relative !important;
				padding: 0px !important;
			}

			.MENU_TD > div, .CONTENTS_TD > div{
				position: absolute !important;
				top: 0px !important;
				left: 0px !important;
				right: 0px !important;
				bottom: 0px !important;

				padding: 10px !important;
				overflow-y: auto !important;
			}

			.HEADER_TD{
				height: 110px !important;
			}

			.MENU_TD{
				width: 290px !important;
			}

			.TABLE_BORDER_HORIZONTAL_A{
				background-color: #C0C0C0 !important;
				height: 1px !important;
			}

			.TABLE_BORDER_HORIZONTAL_B{
				background-color: #808080 !important;
				height: 1px !important;
			}

			.TABLE_BORDER_VERTICAL_A{
				background-color: #C0C0C0 !important;
				width: 1px !important;
			}

			.TABLE_BORDER_VERTICAL_B{
				background-color: #808080 !important;
				width: 1px !important;
			}
		</STYLE>

		<STYLE>
			.MPD_STATUS{
				width: 275px;
				height: 116px;

				border: none;
			}

			/* .FOOTER{
				margin-top: 100px;

				font-size: 10px;
			} */
		</STYLE>
	</HEAD>
	<BODY>
		<TABLE CLASS="MAIN_TABLE">
			<TR>
				<TD COLSPAN="4" CLASS="HEADER_TD" ROLE="banner">
					<?php require_once(__DIR__."/src/component/header.php"); ?>
				</TD>
			</TR>
			<TR>
				<TD COLSPAN="4" CLASS="TABLE_BORDER_HORIZONTAL_A"></TD>
			</TR>
			<TR>
				<TD COLSPAN="4" CLASS="TABLE_BORDER_HORIZONTAL_B"></TD>
			</TR>
			<TR>
				<TD CLASS="MENU_TD">
					<DIV ROLE="menu">
						<?php require_once(__DIR__."/src/component/menu.php"); ?>
					</DIV>
				</TD>
				<TD CLASS="TABLE_BORDER_VERTICAL_A"></TD>
				<TD CLASS="TABLE_BORDER_VERTICAL_B"></TD>
				<TD CLASS="CONTENTS_TD">
					<DIV ROLE="main">
						<?php require_once(__DIR__."/src/component/contents.php"); ?>
					</DIV>
				</TD>
			</TR>
		</TABLE>
	</BODY>
</HTML>