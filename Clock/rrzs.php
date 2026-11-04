<?php
header("Content-Type: audio/wav");

echo file_get_contents("/tmp/zhihou.wav");