<?php
$UNIX_TIME = explode(" ", microtime());

echo $UNIX_TIME[1]."-".str_replace("0.", "", $UNIX_TIME[0])."-".random_int(0, 9999);
?>