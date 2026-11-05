<STYLE>
	input{
		width: 100%;
	}

	b{
		font-size: 20px;
	}
</STYLE>

<?php
$forwarded = $_SERVER["HTTP_FORWARDED"];
$user_agent = $_SERVER["HTTP_USER_AGENT"];
$accept_language = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
$accept_encodeing = $_SERVER["HTTP_ACCEPT_ENCODING"];

?>
<DIV>
	貴様のForwarded情報↓<BR>
	<INPUT TYPE="text" READONLY VALUE="<?=htmlspecialchars($forwarded)?>">
</DIV>
<DIV>
	貴様のﾕｰｻﾞｰｴｰｼﾞｪﾝﾄ↓<BR>
	<INPUT TYPE="text" READONLY VALUE="<?=htmlspecialchars($user_agent)?>">
</DIV>

<DIV>
	その他数点の情報から鑑みると...
	<BR><BR><BR>
</DIV>

<?php
	$ip_address = "0.0.0.0";
	$protocol = "不明な";

	if ($forwarded != NULL) {
		//Forwarded
		foreach (explode(";", $forwarded) as $parts1) {
			$parts2 = explode("=", $parts1);
			if ($parts2[0] == "for") {
				$ip_address = $parts2[1];
			}

			if ($parts2[0] == "proto") {
				if ($parts2[1] == "https") {
					$protocol = "暗号化された";
				} else {
					$protocol = "平文な";
				}
			}
		}
	}
?>
<DIV>
	貴様のIPアドレスは<B><?=htmlspecialchars($ip_address)?></B>です。
</DIV>
<DIV>
	貴様は<B><?=htmlspecialchars($protocol)?></B>通信を使用して接続しています。
</DIV>

<?php
	$level_1_language = "不明";
	$level_2_language = "不明";

	if ($accept_language != NULL) {
		foreach (explode(",", $accept_language) as $parts1) {
			$parts2 = explode(";", $parts1);
			$language_id = trim($parts2[0]);
			$q = $parts2[1];

			if ($q == NULL) {
				$level_1_language = $language_id;
			} else if ($q == "q=0.5") {
				$level_2_language = $language_id;
			} else {
				break;
			}
		}
	}
?>
<DIV>
	貴様の言語は第一言語が<B><?=htmlspecialchars($level_1_language)?></B>、第二言語が<B><?=htmlspecialchars($level_2_language)?></B>です。
</DIV>

<?php
$encode_list = [];
foreach (explode(",", $accept_encodeing) as $parts) {
	$encode_list[] = trim($parts);
}
?>
<DIV>
	貴様が対応している圧縮形式は<B><?=htmlspecialchars(join("と", $encode_list))?></B>です
</DIV>

<DIV>
	<?php
	if (str_contains($user_agent, "Mozilla/") && str_contains($user_agent, "AppleWebKit/") && str_contains($user_agent, "Chrome/") && str_contains($user_agent, "Safari/")) {
		//Chrome
		echo "この気持ち悪いゴミみたいなクソUAから鑑みるに、貴様はChromeもしくはChromium系ブラウザを使用しているようです。";
	} else if (str_contains($user_agent, "Mozilla/") && str_contains($user_agent, "Firefox/")) {
		//Firefox
		if (preg_match("/Firefox\/([0-9.]+)/", $user_agent, $mtc)) {
			echo "貴様はFirefox ﾊﾞｰｼﾞｮﾝ".htmlspecialchars($mtc[1])."を使用しているようです。";
		}
	} else if (str_contains($user_agent, "Trident/") && str_contains($user_agent, "like Gecko")) {
		//IE
		echo "このふざけたUAを見るに、貴様はIEを使用しているようです。";
	} else if (str_contains($user_agent, "Mozilla/") && str_contains($user_agent, "AppleWebKit/") && str_contains($user_agent, "Safari/")) {
		//Safari
		echo "このふざけたUAを見るに、貴様はSafariを使用しているようです。";
	} else if (str_contains($user_agent, "NX/") && str_contains($user_agent, "NintendoBrowser/")) {
		//任天堂
		echo "貴様は任天堂のゲーム機を使用しているようです。";
	} else if (str_contains($user_agent, "PlayStation")) {
		//プレステ
		echo "貴様はソニーのゲーム機を使用しているようです。";
	}
	?>
</DIV>

<?php
	$os_name = "不明なOS";
	$hardware_name = "不明なデバイス";

	//Linux
	if (str_contains($user_agent, "Linux")) {
		$os_name = "LinuxｶｰﾈﾙなOS";
		$hardware_name = "ﾊﾟｰｿﾅﾙｺﾝﾋﾟｭｰﾀｰ";
	}

	//WindowsNT
	if (str_contains($user_agent, "Windows NT")) {
		$hardware_name = "ﾊﾟｰｿﾅﾙｺﾝﾋﾟｭｰﾀｰ";

		if (preg_match("/Windows NT ([0-9.]+)/", $user_agent, $mtc)) {
			$os_name = "NT".$mtc[1]."ｶｰﾈﾙなWindows";
		} else {
			$os_name = "NTｶｰﾈﾙなWindows";
		}
	}

	//iPhone
	if (str_contains($user_agent, "iPhone")) {
		$os_name = "iPhone OS(iOS)";
		$hardware_name = "ｽﾏｰﾄﾌｫﾝ";
	}

	//WiiU
	if (str_contains($user_agent, "Wii U") || str_contains($user_agent, "WiiU")) {
		$os_name = "任天堂の謎OS";
		$hardware_name = "WiiU";
	}

	//Wii
	if (str_contains($user_agent, "Wii; ")) {
		$os_name = "任天堂の謎OS";
		$hardware_name = "Wii";
	}

	//3DS
	if (str_contains($user_agent, "3DS")) {
		$os_name = "任天堂の謎OS";
		$hardware_name = "3DS";
	}

	//Switch
	if (str_contains($user_agent, "Nintendo Switch")) {
		$os_name = "任天堂の謎OS";
		$hardware_name = "任天堂スイッチ";
	}
?>
<DIV>
	貴様は<B><?=htmlspecialchars($os_name)?></B>が搭載された<B><?=htmlspecialchars($hardware_name)?></B>を使用しているようです
</DIV>

