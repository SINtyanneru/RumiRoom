<?php
function ogp($site_name, $title, $description) {
	?>

	<META NAME="description" CONTENT="<?=$description?>">

	<!--OGP-->
	<META PROPERTY="og:title" CONTENT="<?=$title?>">
	<META PROPERTY="og:description" CONTENT="<?=$description?>">
	<META PROPERTY="og:type" CONTENT="website">
	<META PROPERTY="og:site_name" CONTENT="<?=$site_name?>">
	<META PROPERTY="og:locale" CONTENT="ja_JP">
	<META PROPERTY="og:image" CONTENT="https://data.rumiserver.com/account/icon-1">
	<META PROPERTY="og:image:secure_url" content="https://data.rumiserver.com/account/icon-1">

	<!--Twitter(旧X)-->
	<META NAME="twitter:card" CONTENT="summary">
	<META NAME="twitter:title" CONTENT="<?=$title?>">
	<META NAME="twitter:description" CONTENT="<?=$title?>">
	<META NAME="twitter:site" CONTENT="@RUMI_SYSTEM32">
	<META NAME="twitter:creator" CONTENT="@RUMI_SYSTEM32">

	<?php
}