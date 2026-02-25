<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

include("http://plain-cdn.rumia.me/LIB/LangSystem.php");
$LANG = new LangSystem("test");
echo $LANG->GET("test");
?>