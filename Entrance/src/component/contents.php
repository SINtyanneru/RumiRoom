<?php
require_once(__DIR__."/../page.php");
require_once(__DIR__."/../path.php");

$page = page_get_from_url($cur_path);
if ($page == null) {
	http_response_code(404);
	echo "ページが見つかりません。";
	return;
}

require_once($page->path);
?>