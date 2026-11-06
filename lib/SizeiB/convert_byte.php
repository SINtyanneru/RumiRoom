<?php
function convert_byte(int $size) {
	if ($size < 1024) return (string)(int)round($size)."iB";
	$kb = $size / 1024;
	if ($kb < 1024) return (string)(int)round($kb)."KiB";
	$mb = $kb / 1024;
	if ($mb < 1024) return (string)(int)round($mb)."MiB";

	return $size."GB";
}