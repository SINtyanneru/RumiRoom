<?php
if (empty($_GET["V"])) {
	?>
	<H1>るみのパブリックソースソフトウェアライセンス</H1>
	<?php
	$file_list = glob(__DIR__ . '/*');
	foreach ($file_list as $file) {
		if ($file == __FILE__) continue;
		?>
		<A HREF="/license/PSS/?V=<?=htmlspecialchars(basename($file))?>" TARGET="_parent"><?=basename($file)?></A><BR>
		<?php
	}
} else {
	$path = __DIR__."/".str_replace("/", "", $_GET["V"]);
	if (file_exists($path) == false) {
		echo "ない";
		exit;
	}

	echo nl2br(file_get_contents($path));
}
?>