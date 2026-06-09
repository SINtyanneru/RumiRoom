<?php
require(__DIR__."/../../../env.php");

$auth_data = json_decode(base64_decode($_COOKIE["AUTH_DATA"]), true);

if ($auth_data["MODE"] == "RSV") {
	$ajax = curl_init("https://account.rumiserver.com/api/Session?ID=".$auth_data["TOKEN"]);
	curl_setopt($ajax, CURLOPT_HTTPHEADER, ["Accept: application/json"]);
	curl_setopt($ajax, CURLOPT_RETURNTRANSFER, true);
	$user_info = json_decode(curl_exec($ajax), true);
	if ($user_info["STATUS"] == false) {
		echo "セッションエラー";
		exit;
	}

	if (isset($_GET["NEW"])) {
		$stmt = $sql->prepare("INSERT INTO `BLOG_USER` (`ID`, `NAME`, `CREATE_AT`, `IS_ADMIN`, `RUMISERVER_USERID`, `MISSKEY_USERID`, `MISSKEY_HOST`) VALUES (NULL, :name, NOW(), 0, :rsv_id, NULL, NULL);");
		$stmt->bindValue(":name", $user_info["ACCOUNT_DATA"]["NAME"], PDO::PARAM_STR);
		$stmt->bindValue(":rsv_id", $user_info["ACCOUNT_DATA"]["ID"], PDO::PARAM_STR);
		$stmt->execute();

		setcookie("BLOG_SESSION", base64_encode(json_encode(
			[
				"TYPE" => "RSV",
				"TOKEN" => $auth_data["TOKEN"]
			]
		)), time() + 60 * 60 * 24 * 365 * 10, "/", "", true, true);

		header("Location: /user/");
		exit;
	}

	$stmt = $sql->prepare("SELECT `ID` FROM `BLOG_USER` WHERE `RUMISERVER_USERID` = :user_id");
	$stmt->bindValue(":user_id", $user_info["ACCOUNT_DATA"]["ID"], PDO::PARAM_STR);
	$stmt->execute();
	if ($stmt->fetch() == false) {
		//登録されているアカウントがない
		header("Content-Type: text/html");
		echo "ようこそ".htmlspecialchars($user_info["ACCOUNT_DATA"]["NAME"])."さん<BR>";
		echo "まだアカウントが未登録です、新規登録しますか？それとも既存のアカウントに関連付けますか？<BR>";
		echo "<A HREF=\"?NEW=Y\">新規登録</A><BR>";
		echo "<A HREF=\"/\">キャンセル</A>";
	} else {
		//アカウントがある
		header("Location: /user/");
	}
} else {
	header("Content-Type: text/plain");
	echo "非対応の操作";
}

