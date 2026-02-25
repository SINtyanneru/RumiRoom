<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

$base_image = './base.png'; // 元画像のパス
$img = imagecreatefrompng($base_image);
if(!empty($_FILES['FONT'])){
	$font_file = "./uzura.ttf";
}else{
	$font_file = $_FILES['FONT']['tmp_name'];
}
//ID生成
$ID = md5(date("y-m-d-H-u-s-y-m-d-H-u-s")).md5(mt_rand());
$NAME = $_REQUEST['NAME'];
$CORPORATION = $_REQUEST['CORPORATION'];
$AFFILATION = $_REQUEST['AFFILATION'];
$DESC = $_REQUEST['DESC'];
$TWITTER = $_REQUEST['TWITTER'];
$INSTAGRAM = $_REQUEST['INSTAGRAM'];
$FACEBOOK = $_REQUEST['FACEBOOK'];
$RUMISERVER = $_REQUEST['RUMISERVER'];
$PHONE = $_REQUEST['PHONE'];
$ICON = imagecreatefrompng($_FILES['ICON']['tmp_name']);

/**
 * 画像処理する!!
 */

imagefttext(
	$img,	//画像
	50,		//サイズ
	0,		//アングル
	0,		//X
	60,		//Y
	imagecolorallocate($img, 0, 0, 0),//色
	$font_file,//フォント
	$NAME	//テキスト
);

imagefttext(
	$img,
	50,
	0,
	0,
	180,
	imagecolorallocate($img, 0, 0, 0),
	$font_file,
	$CORPORATION." - ".$AFFILATION."所属"
);

imagefttext(
	$img,
	30,
	0,
	0,
	1050,
	imagecolorallocate($img, 0, 0, 0),
	$font_file,
	$DESC
);

imagefttext(
	$img,
	30,
	0,
	1430,
	460,
	imagecolorallocate($img, 0, 0, 0),
	$font_file,
	$TWITTER
);

imagefttext(
	$img,
	30,
	0,
	1430,
	560,
	imagecolorallocate($img, 0, 0, 0),
	$font_file,
	$INSTAGRAM
);

imagefttext(
	$img,
	30,
	0,
	1430,
	660,
	imagecolorallocate($img, 0, 0, 0),
	$font_file,
	$FACEBOOK
);

imagefttext(
	$img,
	30,
	0,
	1430,
	760,
	imagecolorallocate($img, 0, 0, 0),
	$font_file,
	$RUMISERVER
);

imagefttext(
	$img,
	30,
	0,
	1430,
	860,
	imagecolorallocate($img, 0, 0, 0),
	$font_file,
	$PHONE
);

$position_x = 10;
$position_y = 200;
//リサイズ(サムネイル用)
$size = '800';
//imagescaleという便利な関数があったぜ
$ICON = imagescale($ICON,$size);
//画像貼り付け
imagecopy($img, $ICON, $position_x, $position_y, 0, 0, 800, 800);



//出力する画像の種類のヘッダ情報をつける(以下はPNGの場合)
//eader('Content-Type: image/png');

//画像を出力します
imagepng($img, "./RESULT/".$ID.".png");
?>

<A HREF="<?php echo "./RESULT/".$ID.".png"; ?>">保存する</A>