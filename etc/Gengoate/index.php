<!DOCTYPE html>
<HTML>
	<HEAD>
		<TITLE>言語当てるやつ</TITLE>
	</HEAD>
	<BODY>
		<H1>言語当てるくん</H1>
		<HR>
		<DIV>
			<DIV CLASS="QUESTION" ID="QUESTION">
				しばらくお待ちください
			</DIV>
			<BUTTON onclick="ANSER(true);">はい</BUTTON>
			<BUTTON onclick="ANSER(false);">いいえ</BUTTON>
		</DIV>
		<DETAILS>
			<SUMMARY>対応言語</SUMMARY>
			<?php
				foreach(json_decode(file_get_contents("./LIST.json"), true) as $ROW) {
					echo "<DIV>".$ROW["NAME"]."</DIV>";
				}
			?>
		</DETAILS>
	</BODY>
</HTML>
<SCRIPT>
	let LIST = JSON.parse(`<?php echo file_get_contents("./LIST.json") ?>`);
	let LETTER = JSON.parse(`<?php echo file_get_contents("./LETTER.json") ?>`);
	let NATION = JSON.parse(`<?php echo file_get_contents("./NATION.json") ?>`);
	let GENRE = JSON.parse(`<?php echo file_get_contents("./GENRE.json") ?>`);
	let AUTHOR = JSON.parse(`<?php echo file_get_contents("./AUTHOR.json") ?>`);
</SCRIPT>
<SCRIPT SRC="./Main.js"></SCRIPT>