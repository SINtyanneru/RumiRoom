<?php
//ChatGPTに書かせた
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

header("Content-Type: text/plain");

function generate_randomart($hash) {
	$width = 17;
	$height = 9;
	$grid = array_fill(0, $height, array_fill(0, $width, 0));
	$dx = [1, 1, 0, -1, -1, -1, 0, 1];
	$dy = [0, -1, -1, -1, 0, 1, 1, 1];

	$x = intdiv($width, 2);
	$y = intdiv($height, 2);
	$grid[$y][$x] = -1; // Start

	$bytes = unpack("C*", $hash); // バイナリ→バイト配列（1-indexed）

	foreach ($bytes as $b) {
		for ($j = 0; $j < 4; $j++) {
			$shift = 6 - $j * 2;
			if ($shift < 1) continue; // 安全策
			$dir = ($b >> $shift) & 0b11;
			$step = ($dir << 1) | (($b >> ($shift - 1)) & 0b1);
			$step %= 8;

			$x += $dx[$step];
			$y += $dy[$step];
			$x = max(0, min($width - 1, $x));
			$y = max(0, min($height - 1, $y));

			if ($grid[$y][$x] >= 0) {
				$grid[$y][$x]++;
			}
		}
	}
	$grid[$y][$x] = -2; // End

	$symbols = [' ', '.', 'o', '+', '=', '*', 'B', 'O', 'X', '@', '#'];
	$out = "+---[SHA256]---+\n";
	for ($j = 0; $j < $height; $j++) {
		for ($i = 0; $i < $width; $i++) {
			switch ($grid[$j][$i]) {
				case -1: $out .= 'S'; break;
				case -2: $out .= 'E'; break;
				default:
					$val = $grid[$j][$i];
					$out .= $symbols[min($val, count($symbols) - 1)];
			}
		}
		$out .= "\n";
	}
	$out .= "+--------------+\n";
	return $out;
}

// ランダムな32バイトの入力を作る（SHA256風）
$rand = random_bytes(32);
$hash = hash('sha256', $rand, true); // バイナリで取得
echo generate_randomart($hash);
