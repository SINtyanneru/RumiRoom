<?php
require_once(__DIR__."/../../env.php");
$cur_path = str_replace($__PATH, "", urldecode(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH)));
