<?php
$ua = getenv('HTTP_USER_AGENT');
 
if (strstr($ua, 'Edge') || strstr($ua, 'Edg')) {
  echo "Microsoft Edge";
} elseif (strstr($ua, 'Trident') || strstr($ua, 'MSIE')) {
  echo "Microsoft Internet Explorer";
} elseif (strstr($ua, 'OPR') || strstr($ua, 'Opera')) {
  echo "Opera";
} elseif (strstr($ua, 'Chrome')) {
  echo "Google Chrome";
} elseif (strstr($ua, 'Firefox')) {
  echo "Firefox";
} elseif (strstr($ua, 'Safari')) {
  echo "Safari";
} else {
  echo "Unknown";
}

// 使用する変数を空文字で初期化
$user_device = '';

// HTTP リクエストヘッダーが持っているユーザーエージェントの文字列を取得
$useragent = $_SERVER['HTTP_USER_AGENT'];
// スマホ・ガラケー・PCそれぞれについて、strpos 関数を使ってクライアントのデバイスを調べる
if((strpos($useragent, 'Android') !== false) &&
    (strpos($useragent, 'Mobile') !== false) ||
    (strpos($useragent, 'iPhone') !== false) ||
    (strpos($useragent, 'iPad') !== false) ||
    (strpos($useragent, 'Windows Phone') !== false)){
    // スマホからアクセスしている場合
    $user_device = 'スマホからみてるよ';
}elseif((strpos($useragent, 'DoCoMo') !== false) ||
    (strpos($useragent, 'KDDI') !== false) ||
    (strpos($useragent, 'SoftBank') !== false) ||
    (strpos($useragent, 'Vodafone') !== false) ||
    (strpos($useragent, 'J-PHONE') !== false)){
    // ガラケーからアクセスしている場合
    $user_device = '<script> alert("ガラケーには非対応です！"); </script>';
}else{
    // パソコンからアクセスしている場合
    $user_device = 'パソコンからみてるよ';
}
echo $user_device;
?>