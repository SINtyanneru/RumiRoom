<?php
$ajax = curl_init("http://192.168.0.128/RML/");
curl_setopt($ajax, CURLOPT_POST, true);
curl_setopt($ajax, CURLOPT_POSTFIELDS, file_get_contents("php://input"));
curl_setopt($ajax, CURLOPT_HTTPHEADER, ["Content-Type: text/plain"]);
curl_setopt($ajax, CURLOPT_RETURNTRANSFER, true);
$html = curl_exec($ajax);
echo $html;