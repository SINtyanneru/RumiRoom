<?php
$tor_exit_nodes = explode("\n", file_get_contents('./tor_list.txt'));
$user_ip = $_SERVER['HTTP_CLIENT_IP'];
echo $user_ip."<BR>";

if (in_array($user_ip, $tor_exit_nodes)) {
	echo "あなたは使用しているTor!";
} else {
	echo "きみはTorを使用していない！！！！！！";
}
?>
