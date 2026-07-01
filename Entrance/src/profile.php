<?php
require(__DIR__."/../../env.php");
require_once(__DIR__."/../../ruby.php");

$use_language = [
	"日本語"
];

$use_proguraming_language = [
	"Java", "C#", "JavaScript", "TypeScript", "PHP", "Lua"
];

$stmt = $sql->prepare("SELECT * FROM `FAVORITE_ARTIST` ORDER BY `ID` ASC;");
$stmt->execute();
$love_artist = $stmt->fetchAll();

$stmt = $sql->prepare("SELECT * FROM `KYARA_KNOWN` WHERE `LOVE` = 0 ORDER BY `ID` ASC;");
$stmt->execute();
$shitteru_kyara = $stmt->fetchAll();

$stmt = $sql->prepare("SELECT * FROM `KYARA_KNOWN` WHERE `LOVE` = 1 ORDER BY `ID` ASC;");
$stmt->execute();
$love_kyara = $stmt->fetchAll();
?>

<STYLE>
	table{
		margin: auto;
	}

	table td {
		padding:10px;
	}

	.ICON{
		width: 128px;
		height: auto;
	}
</STYLE>

<!--プロフ-->
<TABLE>
	<TR>
		<TD ROWSPAN="10">
			<A HREF="https://www.pixiv.net/tags/%E6%A3%97%E9%88%B4/artworks" TARGET="_blank">
				<IMG CLASS="ICON" SRC="/Asset/icon_proxy.php">
			</A>
		</TD>
		<TD COLSPAN="2" STYLE="font-size: 45px;">
			<?=ruby("Σχετικά με", "Shetikáme")?><?=ruby("μένα", "ména")?>
		</TD>
	</TR>
	<TR>
		<TD COLSPAN="2">
			<I><?=ruby("Сара", "Sara")?> <?=ruby("исызку", "isyzku")?> <?=ruby("ашәҟәы,", "ašwq́wy")?> <?=ruby("наӡаӡа", "nażaża")?> <?=ruby("схала", "shala")?></I>
		</TD>
	</TR>
	<TR>
		<TD><?=ruby("名前", "なまえ")?></TD>
		<TD>: るみ</TD>
	</TR>
	<TR>
		<TD><?=ruby("年齢", "ねんれい")?></TD>
		<TD>
			<?php
			$birthday = new DateTime("2007-10-29");
			$now = new DateTime();
			$age = $now->diff($birthday)->y;
			echo ": ".$age;
			?>
		</TD>
	</TR>
	<TR>
		<TD>マイナンバー</TD>
		<TD>: 1037 0077 4698</TD>
	</TR>
	<TR>
		<TD><?=ruby("喋", "しゃ")?>れる<?=ruby("言語", "げんご")?></TD>
		<TD>: <?=implode("/", $use_language)?></TD>
	</TR>
	<TR>
		<TD><?=ruby("使", "つか")?>えるﾌﾟﾖｸﾞﾗﾐﾝｸﾞ<?=ruby("言語", "げんご")?></TD>
		<TD>: <?=implode("/", $use_proguraming_language)?></TD>
	</TR>
</TABLE>

<HR>

<!--代理-->
<TABLE>
	<TR>
		<TH>わたしの<?=ruby("代理", "だいり")?></TH>
	</TR>
	<TR>
		<TD>
			<IMG CLASS="ICON" SRC="/Asset/るみどっと.png">
		</TD>
	</TR>
	<TR>
		<TH>
			<A HREF="/art/shiryou.html" TARGET="_parent"><?=ruby("資料", "しりょう")?>はこちら</A>
		</TH>
	</TR>
</TABLE>

<HR>

<DIV STYLE="text-align: center;">
	<H2><?=ruby("好", "す")?>きな<?=ruby("絵師", "えし")?></H2>
	<?php
	foreach ($love_artist as $artist) {
		?>
		<A HREF="<?=$artist["URL"]?>" TARGET="_blank"><?=$artist["NAME"]?></A>
		<?php
	}
	?>
</DIV>

<DIV STYLE="text-align: center;">
	<H2><?=ruby("好", "す")?>きなキャラ</H2>
	<?php
	foreach ($love_kyara as $kyara) {
		if (isset($kyara["URL"])) {
			?>
			<A HREF="<?=$kyara["URL"]?>">
			<?php
		}
		echo "[";
		echo $kyara["NAME"];
		echo "|";
		echo $kyara["ARTIFACT"];
		echo "] ";
		if (isset($kyara["URL"])) {
			echo "</A>";
		}
	}
	?>
</DIV>

<DIV STYLE="text-align: center;">
	<H2><?=ruby("知", "し")?>ってるキャラ</H2>
	<?php
	foreach ($shitteru_kyara as $kyara) {
		if (isset($kyara["URL"])) {
			?>
			<A HREF="<?=$kyara["URL"]?>">
			<?php
		}
		echo "[";
		echo $kyara["NAME"];
		echo "|";
		echo $kyara["ARTIFACT"];
		echo "] ";
		if (isset($kyara["URL"])) {
			echo "</A>";
		}
	}
	?>
</DIV>
