<?php
/*ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

//↓GDのエラーはこうしないとtryに引っかからん
set_error_handler(function ($errno, $errstr) {
	throw new \RuntimeException($errstr, $errno);
});*/

header("Content-Type: image/png");

//UA
$user_agent = $_SERVER["HTTP_USER_AGENT"] ?? "None";

$margin = 10;
$font_size = 14;
$font = __DIR__."/NotoSansJP-Regular.ttf";

$width = 0;
$height = 0;

//サイズをゲット
$bbox = imagettfbbox($font_size, 0, $font, $user_agent);

//サイズを入れる
$width = abs($bbox[2] - $bbox[0]) + ($margin * 2);
$height = abs($bbox[5] - $bbox[3]) + $margin;

$img = imagecreatetruecolor($width, $height);

//背景色
imagefill($img, 0, 0, imagecolorallocate($img, 255, 255, 255));

imagettftext($img, $font_size, 0, $margin, $margin + $font_size, imagecolorallocate($img, 0, 0, 0), $font, $user_agent);

imagepng($img);