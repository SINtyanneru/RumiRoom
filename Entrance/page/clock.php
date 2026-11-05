<?php
$url = "http://clock.rumi-room.net/";

if (str_contains($_SERVER["HTTP_FORWARDED"], "https")) {
	$url = "https://clock.rumi-room.net/";
}
?>
<IFRAME SRC="<?=$url?>" STYLE="width: 500px; height: 700px; border: none;"></IFRAME>