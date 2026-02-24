<?php
$__SQL_HOST = "192.168.0.130";
$__SQL_DB = "rumisan_room";
$__SQL_USER = "rumi_room";
$__SQL_PASS = "aqaz12345569apapapa14463229";

//SQL
$sql = new PDO(
	"mysql:host=".$__SQL_HOST.";dbname=".$__SQL_DB.";",
	$__SQL_USER,
	$__SQL_PASS,
	[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
);