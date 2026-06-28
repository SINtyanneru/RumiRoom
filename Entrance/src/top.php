<?php
require(__DIR__."/../../env.php");
require_once(__DIR__."/../../ruby.php");
?>
<DIV>
	<?php
	$file_list = scandir(__DIR__."/../../Asset/Mochi/");
	$file_list = array_filter($file_list, fn($f)=>!in_array($f, [".", ".."]));
	$rnd = random_int(2, count($file_list));
	?>
	<IMG SRC="/Asset/Mochi/<?=$file_list[$rnd]?>" ALIGN="right"><BR>

	<DIV ALIGN="left">
		<H1>るみさんのお<?=ruby("部屋", "へや")?>へようこそ</H1>
		<A HREF="/profile.html" TARGET="_parent"><?=ruby("瑠海", "るみ")?></A>(<A HREF="https://八木伸梧.com/" TARGET="_parent"><?=ruby("八木瑠海伸梧", "やぎるみしんご")?></A>)の<?=ruby("個人", "こじん")?>サイトです。<BR>
		<BR>
		<?=ruby("何", "なに")?>をやってる<?=ruby("人", "ひと")?>なのかは、<A HREF="https://portfolio.rumi-room.net/" TARGET="_parent">ポートフォリオ</A>を<?=ruby("見", "み")?>ればわかると<?=ruby("思", "お")?>うけど、<BR>
		<?=ruby("他", "ほか")?>の<?=ruby("活動", "かつどう")?>も<?=ruby("知", "し")?>りたい<?=ruby("人", "ひと")?>は<A HREF="https://dev.rumi-room.net" TARGET="_parent">るみさんの<?=ruby("開発部屋", "かいはつべや")?></A>もご<?=ruby("覧", "らん")?>くださいまし。<BR>
	</DIV>
</DIV>

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

	<?=ruby("今日", "きょう")?>は<?=floor($today_progress)?>%<?=ruby("終", "お")?>わりましたです。<BR>
	<?=ruby("今月", "こんげつ")?>は<?=floor($month_progress)?>%<?=ruby("終", "お")?>わりましたです。<BR>
	<?=ruby("今年", "ことし")?>は<?=floor($year_progress)?>%<?=ruby("終", "お")?>わりましたです。<BR>
</DIV>

<DIV>
	<H2>このサイトについて</H2>
	<A HREF="/profile.html" TARGET="_parent"><?=ruby("瑠海", "るみ")?></A>(<A HREF="https://八木伸梧.com/" TARGET="_parent"><?=ruby("八木瑠海伸梧", "やぎるみしんご")?></A>)っていう<?=ruby("愛媛県在住", "えひめけんざいじゅう")?>の<?=ruby("一般人", "いっぱんじん")?>が<?=ruby("運用", "うんよう")?>する<?=ruby("個人", "こじん")?>サイト！<BR>
	この<?=ruby("瑠海", "るみ")?>っていう人は、IE2.0/ﾈｽｹ2.0<?=ruby("向", "む")?>けのHTML<?=ruby("本", "ぼん")?>を<?=ruby("見", "み")?>てHTMLを<?=ruby("学", "まな")?>び、そこからプヨグラミングの<?=ruby("世界", "せかい")?>に<?=ruby("突入", "とつにゅう")?>したため、<BR>
	このサイトのソースコードも<?=ruby("大文字", "おおもじ")?>HTMLになっています。<BR>
	<?=ruby("見", "み")?>た<?=ruby("目", "め")?>からして<?=ruby("古", "ふる")?>めかしいですねぇ<BR>
	あ、<?=ruby("別", "べつ")?>にモダンなサイトが<?=ruby("作", "つく")?>れないわけじゃないですよ。<BR>
	たぶん<A TARGET="_parent" HREF="https://etc.rumi-room.net/"><?=ruby("物置部屋", "ものおきべや")?></A>あたりに<?=ruby("転", "ころ")?>がってるんじゃないですかね？<BR>
	<BR>
	たまにマウスカーソルを<?=ruby("翳", "かざ")?>すとなにか<?=ruby("出", "で")?>ることがありますが、<?=ruby("明", "あき")?>らかに<A HREF="https://www7a.biglobe.ne.jp/~naopy/">Naopy</A>さんのパクリです(すまんかった)<BR>
	<BR>
	<H2>なにこのルビ</H2>
	<A HREF="https://rubizaidan.jp/">ルビ<?=ruby("財団", "ざいだん")?></A>に<?=ruby("習", "なら")?>い、ルビを<?=ruby("振", "ふ")?>っています。<BR>
	もし、<?=ruby("騼", "バカ")?>にしていると<?=ruby("思", "おも")?>ったのであれば、あなたは<?=ruby("疲", "つか")?>れています、ゆっくり<?=ruby("休", "やす")?>んでください...
</DIV>

<HR>

<DIV>
	<H2 TITLE="ただのIFRAMEなので無断転載ではないっす"><?=ruby("好", "す")?>きなイラスト</H2>
	<?php
	$stmt = $sql->prepare("SELECT * FROM `FAVORITE_ILLUST_PIXIV` ORDER BY `ID` ASC LIMIT 10;");
	$stmt->execute();
	$favorite_illust_list = $stmt->fetchAll();

	foreach ($favorite_illust_list as $il) {
		?>
		<IFRAME SRC="https://embed.pixiv.net/oembed_iframe.php?type=illust&id=<?=$il["PIXIV_ID"]?>&autoplay=1&auto_play=1"></IFRAME>
		<?php
	}
	?>
	<BR>
	<A HREF="/favorite_illust.php" TARGET="_parent">続きを見る</A>

	<?php
	$stmt = $sql->prepare("SELECT * FROM `FAVORITE_ILLUST_TWITTER` ORDER BY `ID` ASC LIMIT 1;");
	$stmt->execute();
	$favorite_tweet = $stmt->fetchAll();

	foreach ($favorite_tweet as $t) {
		?>
		<blockquote class="twitter-tweet" data-media-max-width="560"><a href="https://twitter.com/<?=$t["AUTHOR"]?>/status/<?=$t["TWEET_ID"]?>?ref_src=twsrc%5Etfw"></a></blockquote>
		<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> 
		<?php
	}
	?>
	<BR>
	<A HREF="/favorite_illust.php" TARGET="_parent">続きを見る</A>
</DIV>
