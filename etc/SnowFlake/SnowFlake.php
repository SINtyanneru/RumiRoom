<?php
/**
 * SnowFlake生成
 * @return void
 */
function GEN_SNOWFLAKE(){
	$TIME = (int)str_replace(".", "", microtime(true));
	$X = mt_rand(0, 0x3FFFFF);

	return (($TIME << 22) | (($X) & 0x3FFFFF)) & 0x7FFFFFFFFFFFFFFF;
}

//BASE64のゴミを消すやつ
function BASE64_GOMI_RM($TEXT){
	return str_replace("=", "", $TEXT);
}

echo "<H1>SnowFlakeみたいなものが生成できた。。。</H1>";
echo "SnowFlakeみたいなものというだけでありSnowFlakeではない、";
echo "<HR>";
echo "Discordのあれ<BR>";
echo BASE64_GOMI_RM(base64_encode(GEN_SNOWFLAKE())).".".BASE64_GOMI_RM(base64_encode(time() - 1293840000)).".AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA";

echo "<HR>";
echo "100個生成<BR>";

for ($I=0; $I < 100; $I++) {
	echo GEN_SNOWFLAKE()."<BR>";
	sleep(0.5);
}
?>