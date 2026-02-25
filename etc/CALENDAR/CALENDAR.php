<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

$CALENDAR = array();

$DATE_TOMOT = $_REQUEST['MOT'];
$DATE_TOYO = date("y");
$DATE_TOSTD = date('N', strtotime($DATE_TOYO."-".$DATE_TOMOT."-01"));	//今月の1日の曜日
$DAE_END = date('d',strtotime('last day of this month'));

/*最初の空白部分を追加*/
$COUNT = 0;
while($COUNT < $DATE_TOSTD){
	array_push($CALENDAR, ["DAY" => "N", "NAME" => "", "DATA" => "NONE"]);

	$COUNT++;
}

/*ほんだいやー*/
$COUNT = 0;
while($COUNT < $DAE_END){
	array_push($CALENDAR, ["DAY" => $COUNT + 1, "NAME" => "", "DATA" => "ここに予定を"]);

	$COUNT++;
}

echo json_encode($CALENDAR);
?>