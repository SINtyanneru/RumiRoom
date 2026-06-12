<?php
$use_language = [
	"日本語"
];

$use_proguraming_language = [
	"Java", "C#", "JavaScript", "TypeScript", "PHP", "Lua"
];

$love_artist = [
	[
		"NAME" => "ころんびぁ",
		"URL" => "https://eth.rumiserver.com/@Colon_BR@misskey.io"
	],
	[
		"NAME" => "さわやか鮫肌",
		"URL" => "https://eth.rumiserver.com/@adahemas@misskey.io"
	],
	[
		"NAME" => "倉本たかと",
		"URL" => "https://www.pixiv.net/users/40172"
	],
	[
		"NAME" => "Thalia",
		"URL" => "https://www.pixiv.net/users/68118979"
	],
	[
		"NAME" => "たんたんめん",
		"URL" => "https://www.pixiv.net/users/188106"
	],
	[
		"NAME" => "ココシラ",
		"URL" => "https://www.pixiv.net/users/43408135"
	],
	[
		"NAME" => "めいび",
		"URL" => "https://www.pixiv.net/users/89796887"
	],
	[
		"NAME" => "柔毛",
		"URL" => "https://twitter.com/c5buf/media"
	],
	[
		"NAME" => "スウ",
		"URL" => "https://eth.rumiserver.com/@suu1003@misskey.io"
	],
	[
		"NAME" => "みあま",
		"URL" => "https://eth.rumiserver.com/@Miama_rein@misskey.io"
	],
	[
		"NAME" => "のや‏",
		"URL" => "https://eth.rumiserver.com/@noya@mk.noyaskey.net"
	],
	[
		"NAME" => "みなほし",
		"URL" => "https://eth.rumiserver.com/@Minata_@mk.yopo.work"
	],
	[
		"NAME" => "ケケ",
		"URL" => "https://eth.rumiserver.com/@keke2023@misskey.io"
	],
	[
		"NAME" => "honyang",
		"URL" => "https://www.pixiv.net/users/30413979"
	],
	[
		"NAME" => "森山メト",
		"URL" => "https://www.pixiv.net/users/82910318"
	]
];

$shitteru_kyara = [];
$love_kyara = [
	[
		"NAME" => "マヨ",
		"ARTIFACT" => "トリッカル",
		"URL" => "https://wikiwiki.jp/thetrickal/%E3%83%9E%E3%83%A8"
	],
	[
		"NAME" => "びあ",
		"ARTIFACT" => "ころんびぁ",
		"URL" => "https://misskey.io/notes/a3qycvplxt0t001i"
	],
	[
		"NAME" => "しろんびぁ",
		"ARTIFACT" => "ころんびぁ",
		"URL" => "https://misskey.io/notes/akitrksxw71b03jr"
	],
	[
		"NAME" => "ロッシ",
		"ARTIFACT" => "明日方舟:终末地",
		"URL" => "https://twitter.com/AKEndfieldJP/status/2038088758763905387"
	],
	[
		"NAME" => "卯月",
		"ARTIFACT" => "艦隊これくしょん",
		"URL" => "https://www.pixiv.net/tags/%E5%8D%AF%E6%9C%88(%E8%89%A6%E9%9A%8A%E3%81%93%E3%82%8C%E3%81%8F%E3%81%97%E3%82%87%E3%82%93)/artworks"
	],
	[
		"NAME" => "蓮希るい",
		"ARTIFACT" => "VTuber",
		"URL" => "https://www.pixiv.net/tags/%E8%93%AE%E5%B8%8C%E3%82%8B%E3%81%84/artworks"
	],
	[
		"NAME" => "姬野星奏",
		"ARTIFACT" => "姫野星奏（ひめの せな）はUs:track傘下のゲーム『君へ贈る、愛の歌』およびその派生作品の登場人物。 [1]",
		"URL" => "https://zh.moegirl.org.cn/ja/%E5%A7%AC%E9%87%8E%E6%98%9F%E5%A5%8F"
	]
];
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
			Σχετικά με μένα
		</TD>
	</TR>
	<TR>
		<TD COLSPAN="2">
			<I>Сара исызку ашәҟәы, наӡаӡа схала</I>
		</TD>
	</TR>
	<TR>
		<TD>名前</TD>
		<TD>: るみ</TD>
	</TR>
	<TR>
		<TD>年齢</TD>
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
		<TD>支持政党</TD>
		<TD>: 日本保守党</TD>
	</TR>
	<TR>
		<TD>喋れる言語</TD>
		<TD>: <?=implode("/", $use_language)?></TD>
	</TR>
	<TR>
		<TD>使えるﾌﾟﾖｸﾞﾗﾐﾝｸﾞ言語</TD>
		<TD>: <?=implode("/", $use_proguraming_language)?></TD>
	</TR>
</TABLE>

<HR>

<!--代理-->
<TABLE>
	<TR>
		<TH>わたしの代理</TH>
	</TR>
	<TR>
		<TD>
			<IMG CLASS="ICON" SRC="/Asset/るみどっと.png">
		</TD>
	</TR>
	<TR>
		<TH>
			<A HREF="/art/shiryou.html" TARGET="_parent">資料はこちら</A>
		</TH>
	</TR>
</TABLE>

<HR>

<DIV STYLE="text-align: center;">
	<H2>推しの絵師</H2>
	<?php
	foreach ($love_artist as $artist) {
		?>
		<A HREF="<?=$artist["URL"]?>" TARGET="_blank"><?=$artist["NAME"]?></A>
		<?php
	}
	?>
</DIV>

<DIV STYLE="text-align: center;">
	<H2>推しキャラ</H2>
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
	<H2>認知済みキャラ</H2>
	<?php
	foreach ($shitteru_kyara as $kyara) {
		?>
		
		<?php
	}
	?>
</DIV>
