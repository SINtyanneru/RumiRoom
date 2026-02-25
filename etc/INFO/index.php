<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

$BROWSER_LIST = array(
	"Firefox" => "Mozilla FireFox",
	"Chrome" => "Google Chrome",

	"NintendoBrowser" => "任天堂ブラウザ"
);

$ENGINE_LIST = array(
	"NX" => "NetFront® Browser NX"
);

$OS_LIST = array(
	"windows" => array(
		"NAME" => "Windows",
		"DEVELOP" => "Microsoft",
		"PICTURE" => "Windows_95_stacked_logo.svg"
	),
	"macintosh" => array(
		"NAME" => "MacOS",
		"DEVELOP" => "Apple",
		"PICTURE" => null
	),
	"mac os x" => array(
		"NAME" => "MacOS X",
		"DEVELOP" => "Apple",
		"PICTURE" => null
	),
	"linux" => array(
		"NAME" => "Linuxディストリビューション",
		"DEVELOP" => "",
		"PICTURE" => "Tux.png"
	),
	"android" => array(
		"NAME" => "Android",
		"DEVELOP" => "",
		"PICTURE" => null
	),
	"os" => array(
		"NAME" => "iOS",
		"DEVELOP" => "Apple",
		"PICTURE" => null
	),

	"Nintendo WiiU" => array(
		"NAME" => "Cafe OS",
		"DEVELOP" => "任天堂 WiiU",
		"PICTURE" => "WiiU.jpg"
	),
	"Nintendo Switch" => array(
		"NAME" => "Nintendo Switch",
		"DEVELOP" => "任天堂",
		"PICTURE" => "switch.jpg"
	)
);

$BROWSER = array(
	"NAME" => "不明",
	"VERSION" => "不明"
);
$OS = array(
	"NAME" => "不明",
	"VERSION" => "不明",
	"IMAGE" => null
);

$UA = strtolower($_SERVER['HTTP_USER_AGENT']);

//ブラウザ名の検出
foreach($BROWSER_LIST as $ROW => $NAME){
	if (stripos($UA, $ROW) !== false) {
		$BROWSER = array(
			"NAME" => $NAME,
			"VERSION" => ""
		);
		break;
	}
}

//OS名の検出
foreach($OS_LIST as $ROW => $VAL){
	if (stripos($UA, $ROW) !== false) {
		$OS = array(
			"NAME" => $VAL["NAME"],
			"VERSION" => "",
			"IMAGE" => $VAL["PICTURE"]
		);
		break;
	}
}
?>

<HTML>
	<HEAD>
		<TITLE>情報</TITLE>

		<LINK REL="stylesheet" HREF="./style.css">
	</HEAD>
	<BODY>
		<DIV CLASS="HEADER">
			情報
		</DIV>

		<!--ブラウザ-->
		<DIV CLASS="CONTENTS">
			<DIV CLASS="TITLE" data-HELP_ID="BROWSER">
				ブラウザ(WebBrowser)
			</DIV>
			<DIV data-HELP_ID="BROWSER_NAME">ブラウザ名；<?php echo $BROWSER["NAME"]; ?></DIV>
			<DIV data-HELP_ID="BROWSER_VER">バージョン<?php echo $BROWSER["VERSION"]; ?></DIV>
		</DIV>

		<!--OS-->
		<DIV CLASS="CONTENTS">
			<DIV CLASS="TITLE" data-HELP_ID="OS">
				OS
			</DIV>
			<DIV data-HELP_ID="OS_NAME">OS名：<?php echo $OS["NAME"]; ?></DIV>
			<DIV data-HELP_ID="OS_VER">バージョン：<?php echo $OS["VERSION"]; ?></DIV>
			<?php
			if($OS["IMAGE"] != null){
				echo "<IMG SRC=\"IMAGE/".$OS["IMAGE"]."\" CLASS=\"OS_IMAGE\">";
			}
			?>
		</DIV>

		<!--クライアント情報-->
		<DIV CLASS="CONTENTS">
			<DIV CLASS="TITLE" data-HELP_ID="CLIENT">
				クライアント情報
			</DIV>
			<DIV data-HELP_ID="CLIENT_IP">IPアドレス：<?php echo $_SERVER['HTTP_CLIENT_IP']; ?></DIV>
			<DIV data-HELP_ID="CLIENT_UA">ユーザーエージェント：「<?php echo $_SERVER['HTTP_USER_AGENT']; ?>」</DIV>
			<DIV data-HELP_ID="CLIENT_ENC">許可エンコード：<?php echo $_SERVER['HTTP_ACCEPT_ENCODING']; ?></DIV>
			<DIV data-HELP_ID="CLIENT_LANG">言語：<?php echo $_SERVER['HTTP_ACCEPT_LANGUAGE']; ?></DIV>
			<DIV data-HELP_ID="CLIENT_AC">HTTP許可：<?php echo $_SERVER['HTTP_ACCEPT']; ?></DIV>
		</DIV>

		<!--鯖情報-->
		<DIV CLASS="CONTENTS">
			<DIV CLASS="TITLE" data-HELP_ID="SERVER">
				サーバー情報
			</DIV>
			<DIV data-HELP_ID="SERVER_IP">IPアドレス：<?php echo $_SERVER['SERVER_ADDR']; ?></DIV>
			<DIV data-HELP_ID="SERVER_SOFT">ソフトウェア：<?php echo $_SERVER['SERVER_SOFTWARE']; ?></DIV>
			<DIV data-HELP_ID="SERVER_PORT">ポート：<?php echo $_SERVER['SERVER_PORT']; ?></DIV>
			<DIV data-HELP_ID="SERVER_TIME">リクエスト時間：<?php echo $_SERVER['REQUEST_TIME']; ?></DIV>
			<DIV data-HELP_ID="SERVER_PROT">サーバープロトコル：<?php echo $_SERVER['HTTP_CLIENT_SERVER_PROTOCOL']; ?></DIV>
		</DIV>

		<DIV CLASS="HELP_POP" ID="HELP_POP">
		</DIV>
	</BODY>
</HTML>

<SCRIPT SRC="./HELP.js"></SCRIPT>