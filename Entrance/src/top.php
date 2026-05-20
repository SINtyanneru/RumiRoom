<?php
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
	$favorite_illust_list = [
		"141912115", "141348315", "132261916", "135324294", "77685626", "117037467", "130191916",
		"131768074", "137320265", "129026842", "90895574", "141979915", "140409861", "138643541",
		"141415017", "142000488", "141596869", "142811711", "142861894", "131018306", "135496483",
		"142810716", "142775366", "142686126", "131006006", "141219192", "142847676", "142960117",
		"141850981", "142834034", "120881604", "114365748", "133066820", "144460373", "143550336",
		"144731813", "143860543", "143867771", "143084491", "142818689"
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
		],
		[
			"USER" => "Colon_BR",
			"ID" => "2055491626332725613"
		],
		[
			"USER" => "520maodou",
			"ID" => "2056599288319443386"
		]
	];

	foreach ($favorite_tweet as $t) {
		?>
		<blockquote class="twitter-tweet" data-media-max-width="560"><a href="https://twitter.com/<?=$t["USER"]?>/status/<?=$t["ID"]?>?ref_src=twsrc%5Etfw">December 7, 2025</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> 
		<?php
	}
	?>
</DIV>
