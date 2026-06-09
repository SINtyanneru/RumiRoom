<?php
require(__DIR__."/../env.php");
$article_id = $_GET["ID"];
$cache_file = "/tmp/RUMI_BLOG_THUMBNAIL_".str_replace("/", "", $article_id);;
$image_width = 500;
$font = __DIR__."/uzura.ttf";
$font_size = 30;

if (file_exists($cache_file)) {
	$tango_list = explode("\n", file_get_contents($cache_file));
} else {
	$stmt = $sql->prepare("SELECT `TITLE` FROM `BLOG_ARTICLE` WHERE `ID` = :id;");
	$stmt->bindValue(":id", $article_id, PDO::PARAM_STR);
	$stmt->execute();
	$article = $stmt->fetch();
	if ($article == false) exit;

	$element_list = [];
	$escaped = escapeshellarg($article["TITLE"]);
	$output = shell_exec("echo ".$escaped." | mecab");
	$line_list = explode("\n", trim($output));
	foreach ($line_list as $line) {
		if ($line == "EOS" || $line == "") break;

		$parts = explode("\t", $line);
		if (count($parts) < 2) continue;

		$tango = $parts[0];
		$args = explode(",", $parts[1]);

		$position = $args[0] ?? "";			//品詞
		$subcategory1 = $args[1] ?? "";		//品詞細分類1

		//前の単語と結合するべきか
		$is_must_merge = ($subcategory1 == "非自立" || $position == "助動詞" || $position == "助詞" || $subcategory1 == "接尾");

		$element_list[] = [
			"tango" => $tango,
			"is_must_merge" => $is_must_merge
		];
	}

	$tango_list = [];
	$max_width = 400;
	foreach ($element_list as $element) {
		if ($element["is_must_merge"] && count($tango_list) > 0) {
			//前の単語に強制結合
			$tango_list[count($tango_list) - 1] .= $element["tango"];
		} else if (count($tango_list) > 0) {
			//幅チェック：前の単語にくっつけた場合の幅を計算
			$bbox = imagettfbbox($font_size, 0, $font, $tango_list[count($tango_list) - 1] . $element["tango"]);
			$text_width = $bbox[2] - $bbox[0];
			if ($text_width > $max_width) {
				//はみ出るなら新しい行へ
				$tango_list[] = $element["tango"];
			} else {
				//収まるなら前の単語にくっつける
				$tango_list[count($tango_list) - 1] .= $element["tango"];
			}
		} else {
			//配列が空なら無条件で追加
			$tango_list[] = $element["tango"];
		}
	}

	file_put_contents($cache_file, join("\n", $tango_list));
}

$img = imagecreatetruecolor(500, 300);

//背景色
imagefilledrectangle($img, 0, 0, 599, 399, 0xEEEEDD);

//アレ
imagettftext($img, 20, 0, 0, 25, 0x000000, $font, "るみさんのブログ");

//タイトルを書き込む
$i = 0;
foreach ($tango_list as $tango) {
	$bbox = imagettfbbox($font_size, 0, $font, $tango);
	$text_width = $bbox[2] - $bbox[0];
	$y = ($font_size + 10) * $i;
	imagettftext($img, $font_size, 0, intval((500 - $text_width ) / 2), intval(150 / 2 + $y), 0x000000, $font, $tango);
	$i += 1;
}

header('Content-Type: image/png;');
imagepng($img);
