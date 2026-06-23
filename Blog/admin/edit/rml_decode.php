<?php
$ajax = curl_init("http://192.168.0.128/RML/");
curl_setopt($ajax, CURLOPT_POST, true);
curl_setopt($ajax, CURLOPT_POSTFIELDS, $_POST["TEXT"]);
curl_setopt($ajax, CURLOPT_RETURNTRANSFER, true);
$html = curl_exec($ajax);
echo $html;