<?php
header("Content-Type: application/json; charset=UTF-8");
$token_list = [
	"ochinchinippaibo-iwara" => "るみ"
];

$post = json_decode(file_get_contents("php://input"), true);

if (!isset($post["TEXT"]) || !isset($post["TOKEN"])) {
	echo json_encode(["STATUS" => false]);
	exit;
}

$text = $post["TEXT"];
$token = $post["TOKEN"];
$llm_url = "http://192.168.0.128:8080/v1/chat/completions";

if (!isset($token_list[$token])) {
	echo json_encode(["STATUS" => false]);
	exit;
}

echo json_encode([
	"KR" => translate("韓国語"),
	"EN" => translate("英語")
]);

function translate($lang) {
	global $text, $llm_url;

	$istria = [
		[
			"role" => "system",
			"content" => "ユーザーからのメッセージを{$lang}にしてください。"
		],
		[
			"role" => "user",
			"content" => $text
		]
	];

	$ajax = curl_init();
	curl_setopt($ajax, CURLOPT_URL, $llm_url);
	curl_setopt($ajax, CURLOPT_POST, true);
	curl_setopt($ajax, CURLOPT_POSTFIELDS, json_encode(["messages" => $istria]));
	curl_setopt($ajax, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ajax, CURLOPT_HTTPHEADER, [
		"Content-Type: application/json; charset=UTF-8",
		"Accept: application/json; charset=UTF-8"
	]);
	$result = json_decode(curl_exec($ajax), true);
	return $result["choices"][0]["message"]["content"];
}