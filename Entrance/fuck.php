<?php
/**
 * ランダムな地獄へリダイレクトします。
 */

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

$url_list = [
	"https://tanken.com/meijikenpo.html",
	"https://www.gop.com/",
	"https://twitter.com/search?q=%E9%AB%98%E5%B8%82&src=typed_query&f=live",
	"https://x.com/search?q=%E5%AE%89%E5%80%8D&src=typed_query&f=live",
	"https://x.com/hashtag/%E6%96%8E%E8%97%A4%E5%85%83%E5%BD%A6?src=hashtag_click&f=live",
	"https://x.com/search?q=%E5%8F%82%E6%94%BF%E5%85%9A&src=typed_query&f=live"
];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML LANG="ja-jp">
	<HEAD>
		<TITLE>るみさんのお部屋</TITLE>

		<META NAME="viewport" CONTENT="width=device-width, initial-scale=1">
		<META HTTP-EQUIV="Cache-Control" CONTENT="no-store, no-cache, must-revalidate">
		<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
		<META HTTP-EQUIV="Expires" CONTENT="0">

		<?php
		require_once(__DIR__."/../OGP.php");
		ogp("るみさんのお部屋", "入り口", "ん");
		?>
	</HEAD>
	<BODY>
		<CENTER>
			ランダムな地獄へリダイレクトしています...
		</CENTER>
	</BODY>
	<SCRIPT>
		const url_list = <?php echo json_encode($url_list, JSON_UNESCAPED_SLASHES); ?>;

		function randomIndex(length) {
			const max = 4294967296;
			const limit = max - (max % length);
			const buf = new Uint32Array(1);
			let value = 0;
			do {
				crypto.getRandomValues(buf);
				value = buf[0];
			} while (value >= limit);
			return value % length;
		}

		setTimeout(function () {
			location.replace(url_list[randomIndex(url_list.length)]);
		}, 1000);
	</SCRIPT>
</HTML>