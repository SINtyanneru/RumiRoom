<?php
$WIDTH = 640;
$HEIGHT = 416;

$IMG = imagecreatetruecolor($WIDTH, $HEIGHT);

for($X = 0; $X < $WIDTH; $X++){
	for($Y = 0; $Y < $HEIGHT; $Y++){
		imagesetpixel($IMG, $X, $Y, imagecolorallocate($IMG, rand(0, 255), rand(0, 255), rand(0, 255)));
	}
}

header('Content-Type: image/png');
imagepng($IMG);
?>