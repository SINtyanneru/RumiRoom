<?php
$get = json_decode($_GET["R"], true);

if (empty($get["V"])) {
	?>
	<H1>るみのオープンソースソフトウェアライセンス</H1>
	<?php
	$file_list = glob(__DIR__ . '/*');
	foreach ($file_list as $file) {
		if ($file == __FILE__) continue;
		?>
		<A HREF="/license/OSS/?V=<?=htmlspecialchars(basename($file))?>" TARGET="_parent"><?=basename($file)?></A><BR>
		<?php
	}
} else {
	$path = __DIR__."/".str_replace("/", "", $get["V"]);
	if (file_exists($path) == false) {
		echo "ない";
		exit;
	}

	echo nl2br(file_get_contents($path));
}
?>