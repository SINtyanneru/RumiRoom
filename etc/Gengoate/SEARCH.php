<?php
include("https://cdn.rumia.me/LIB/RPL.php?V=LATEST");

header("Content-Type: application/json");

try {
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		$POST_DATA = POST_JSON();
	
		$LIST = json_decode(file_get_contents("./LIST.json"), true);
		$LETTER = $POST_DATA["LETTER"];
		$NATION = $POST_DATA["NATION"];
		$GENRE = $POST_DATA["GENRE"];
		$AUTHOR = $POST_DATA["AUTHOR"];
	
		//言語を1つずつチェックする
		$LIST_TEMP = array();
		foreach($LIST as $ROW) {
			$DA = false;

			if (FIND_LETTER($ROW, $LETTER) && FIND_NATION($ROW, $NATION) && FIND_AUTHOR($ROW, $AUTHOR)) {
				$DA = true;
			}

			if ($DA) {
				//既に追加してるなら追加しない
				if (!ArrayFind($ROW, $LIST_TEMP)) {
					array_push($LIST_TEMP, $ROW);
				}
			}
		}

		echo json_encode(array(
			"STATUS" => true,
			"LIST" => $LIST_TEMP
		));
	} else {
		echo json_encode(array("STATUS" => false));
	}
} catch(\Exception $EX) {
	echo json_encode(array("STATUS" => false, "ERR" => "SYSTEM_ERR", "EX" => $EX));
	http_response_code(500);
} catch(\Throwable $EX) {
	echo json_encode(array("STATUS" => false, "ERR" => "SYSTEM_ERR", "EX" => $EX));
	http_response_code(500);
}

function FIND_LETTER($LANG, $LETTER) {
	//指定されている文字が0個ならtrueを返す
	if (count($LETTER) !== 0) {
		$DA = false;
		foreach($LETTER as $ROW) {
			$ID = $ROW["ID"];
			if (ArrayFind($ID, $LANG["LETTER"]) || ArrayFind($ID, $LANG["TENSHA"])) {
				$DA = true;
			} else {
				$DA = false;
			}
		}
		return $DA;
	} else {
		return true;
	}
}

function FIND_NATION($LANG, $NATION) {
	//指定されている国が0個ならtrueを返す
	if (count($NATION) !== 0) {
		$DA = false;
		foreach($NATION as $ROW) {
			$ID = $ROW["ID"];
			if (ArrayFind($ID, $LANG["KOUYOU"])) {
				$DA = true;
			} else {
				$DA = false;
			}
		}
		return $DA;
	} else {
		return true;
	}
}

function FIND_AUTHOR($LANG, $AUTHOR) {
	//指定されている開発者が0個ならtrueを返す
	if (count($AUTHOR) !== 0) {
		//開発者が居るのに自然言語じゃないならfalseを返す
		if ($LANG["TYPE"] === 0) {
			return false;
		}

		//人工言語なので検索開始
		$DA = false;
		foreach($AUTHOR as $ROW) {
			$ID = $ROW["ID"];
			if ($LANG["AUTHOR"] === $ID) {
				$DA = true;
			} else {
				$DA = false;
			}
		}
		return $DA;
	} else {
		return true;
	}
}

function ArrayFind($VAL, $ARRAY) {
	foreach($ARRAY as $ROW) {
		if ($ROW === $VAL) {
			return true;
		}
	}

	return false;
}
?>