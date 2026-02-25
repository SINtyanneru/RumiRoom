<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
$file_name = $_SERVER['DOCUMENT_ROOT']."/Data_Server/DATA/RumiVideo/DataBroad/Rumisan/data.rbml"; /*読込ファイルの指定*/
$filearr = file($file_name);
//配列の内容を出力
foreach ($filearr as $no => $val) {
    $pattern = '/\<.*?\>/';
    if (preg_match($pattern, $val, $match)){
    }
}
?>