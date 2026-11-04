<?php
header("Content-Type: text/plain; charset=UTF-8");
header("Cache-Control: no-store");

//UNIX時刻(ミリ秒)。タイムゾーンに依存しない
echo (int)floor(microtime(true) * 1000);