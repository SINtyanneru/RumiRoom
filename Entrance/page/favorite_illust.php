<?php
require(__DIR__."/../../env.php");
require_once(__DIR__."/../../ruby.php");
?>
<H2 TITLE="ただのIFRAMEなので無断転載ではないっす"><?=ruby("好", "す")?>きなイラスト</H2>
<?php
$stmt = $sql->prepare("SELECT * FROM `FAVORITE_ILLUST_PIXIV` ORDER BY `ID` ASC;");
$stmt->execute();
$favorite_illust_list = $stmt->fetchAll();

foreach ($favorite_illust_list as $il) {
	?>
	<IFRAME SRC="https://embed.pixiv.net/oembed_iframe.php?type=illust&id=<?=$il["PIXIV_ID"]?>&autoplay=1&auto_play=1"></IFRAME>
	<?php
}

$stmt = $sql->prepare("SELECT * FROM `FAVORITE_ILLUST_TWITTER` ORDER BY `ID` ASC;");
$stmt->execute();
$favorite_tweet = $stmt->fetchAll();

foreach ($favorite_tweet as $t) {
	?>
	<blockquote class="twitter-tweet" data-media-max-width="560"><a href="https://twitter.com/<?=$t["AUTHOR"]?>/status/<?=$t["TWEET_ID"]?>?ref_src=twsrc%5Etfw"></a></blockquote>
	<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
	<?php
}
?>
