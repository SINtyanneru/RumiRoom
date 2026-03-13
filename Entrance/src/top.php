<H1>るみさんのお部屋へようこそ</H1>
<A HREF="/profile.html" TARGET="_parent">るみ</A>(<A HREF="https://八木伸梧.com/" TARGET="_parent">八木瑠海伸梧</A>)の個人サイトです。<BR>
<BR>
何をやってる人なのかは、<A HREF="https://portfolio.rumi-room.net/" TARGET="_parent">ポートフォリオ</A>を見ればわかると思うけど、<BR>
他の活動も知りたい人は<A HREF="https://dev.rumi-room.net" TARGET="_parent">るみさんの開発部屋</A>もご覧くださいまし。<BR>

<HR>

<DIV STYLE="text-align: center;">
	<?php
	$today_progress = ((time() - strtotime("today")) / 86400) * 100;

	$month_day_max = date("t");
	$today = date("j");
	$month_progress = ($today / $month_day_max) * 100;

	$year_today = date("z") + 1;
	$year_progress = ($year_today / 365) * 100;
	?>

	今日は<?=floor($today_progress)?>%終わりましたです。<BR>
	今月は<?=floor($month_progress)?>%終わりましたです。<BR>
	今年は<?=floor($year_progress)?>%終わりましたです。<BR>
</DIV>

<DIV>
	好きなイラスト(R18を排除したらこうなった)↓<BR>
	<?php
	$favorite_illust_list = [
		"141912115", "141348315", "132261916", "135324294", "77685626", "117037467", "130191916", "131768074", "137320265", "129026842", "90895574", "141979915", "140409861", "138643541"
	];

	foreach ($favorite_illust_list as $il) {
		?>
		<IFRAME SRC="https://embed.pixiv.net/oembed_iframe.php?type=illust&id=<?=$il?>&autoplay=1&auto_play=1"></IFRAME>
		<?php
	}

	$favorite_tweet = [
		[
			"USER" => "c5buf",
			"ID" => "1997599996569612718"
		]
	];

	foreach ($favorite_tweet as $t) {
		?>
		<blockquote class="twitter-tweet" data-media-max-width="560"><a href="https://twitter.com/<?=$t["USER"]?>/status/<?=$t["ID"]?>?ref_src=twsrc%5Etfw">December 7, 2025</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> 
		<?php
	}
	?>
</DIV>