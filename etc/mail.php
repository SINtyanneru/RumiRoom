<?php
$MAIL_LIST = [
	"gmail.com",
	"yahoo.co.jp",
	"yandex.com",
	"etonemarie.ru",
	"etonern.ru",
	"ilnk.info",
	"praha.etn.icu",
	"aozora.uk"
];
$MAIL = explode("@", $_GET["MAIL"]);

if (in_array($MAIL[count($MAIL) - 1], $MAIL_LIST)) {
	echo "使えます";
} else {
	echo "使えません";
}
?>