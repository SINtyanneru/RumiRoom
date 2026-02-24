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