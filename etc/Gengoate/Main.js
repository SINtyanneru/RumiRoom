let EL = {
	QUESTION: document.getElementById("QUESTION")
};

let NOW_QUSTION = {
	TYPE: "LETTER",
	ID: "LATIN"/*LETTER[RND(LETTER.length)]["ID"]*/
};

let QUESTION_TEMP = {
	LIST: [],
	LETTER: [],
	NATION: [],
	GENRE: [],
	AUTHOR: []
};

window.addEventListener("load", (E) => {
	EL.QUESTION.innerText = `正書法で「${LETTER.find((ROW) => ROW.ID === NOW_QUSTION.ID)["NAME"]}」を使用しますか？
							もしくは転写等で使用することができますか？`;
});

function QUESTION() {
	const Q_TYPE_LIST = [
		"LETTER",
		"NATION",
		"AUTHOR"
	];
	const Q_TYPE = Q_TYPE_LIST[RND(Q_TYPE_LIST.length)];
	
	if (Q_TYPE === "LETTER" && LETTER.length != QUESTION_TEMP.LETTER.length) {
		const TARGET_LETTER = LETTER[RND(LETTER.length)];
		EL.QUESTION.innerText = `正書法で「${TARGET_LETTER["NAME"]}」を使用しますか？
								もしくは転写等で使用することができますか？`;

		NOW_QUSTION = {
			TYPE: "LETTER",
			ID: TARGET_LETTER["ID"]
		};
	} else if (Q_TYPE === "NATION" && NATION.length != QUESTION_TEMP.NATION.length) {
		const TARGET_NATION = NATION[RND(NATION.length)];
		EL.QUESTION.innerText = `${TARGET_NATION["NAME"]}で公用語に選ばれていますか？`;

		NOW_QUSTION = {
			TYPE: "NATION",
			ID: TARGET_NATION["ID"]
		};
	} else if (Q_TYPE === "AUTHOR" && AUTHOR.length != QUESTION_TEMP.AUTHOR.length) {
		const TARGET_AUTHOR = AUTHOR[RND(AUTHOR.length)];
		EL.QUESTION.innerText = `その言語は${TARGET_AUTHOR["NAME"]}が開発しましたか？`;

		NOW_QUSTION = {
			TYPE: "AUTHOR",
			ID: TARGET_AUTHOR["ID"]
		};
	} else {
		QUESTION();
	}
}

async function ANSER(ANS) {
	//最終回答
	if(NOW_QUSTION.TYPE === "CHECK") {
		if (ANS) {
			EL.QUESTION.innerHTML = `やったー<BR>
			<BUTTON onclick="window.location.reload();">もう一回やる</BUTTON>`;
		} else {
			EL.QUESTION.innerText = `じゃあわからない`;
		}

		return;
	}

	if (ANS) {
		if (NOW_QUSTION.TYPE === "LETTER") {
			QUESTION_TEMP.LETTER.push(LETTER.find((ROW) => ROW.ID === NOW_QUSTION.ID));
		}

		if (NOW_QUSTION.TYPE === "NATION") {
			QUESTION_TEMP.NATION.push(NATION.find((ROW) => ROW.ID === NOW_QUSTION.ID));
		}

		if (NOW_QUSTION.TYPE === "AUTHOR") {
			QUESTION_TEMP.AUTHOR.push(AUTHOR.find((ROW) => ROW.ID === NOW_QUSTION.ID));
		}
	
		//検索
		await SEARCH();
	
		//検索結果が1つだけなら終了
		if (QUESTION_TEMP.LIST.length === 1) {
			EL.QUESTION.innerText = `その言語は「${QUESTION_TEMP.LIST[0]["NAME"]}」ですか？`;

			//質問として登録
			NOW_QUSTION = {
				TYPE: "CHECK",
				ID: QUESTION_TEMP.LIST[0]["ID"]
			};
		} else {
			if (QUESTION_TEMP.LIST.length != 0) {
				//それ以外なので質問を生成
				QUESTION();
			} else {
				//わからない
				EL.QUESTION.innerText = "わかりません";
			}
		}
	} else {
		//違うらしいので続投
		QUESTION();
	}
}

async function SEARCH() {
	let AJAX = await fetch("SEARCH.php", {
		method: "POST",
		body: JSON.stringify(
			{
				LETTER: QUESTION_TEMP.LETTER,
				NATION: QUESTION_TEMP.NATION,
				GENRE: QUESTION_TEMP.GENRE,
				AUTHOR: QUESTION_TEMP.AUTHOR
			}
		)
	});

	const RESULT = await AJAX.json();
	if (RESULT.STATUS) {
		console.log(RESULT);

		QUESTION_TEMP.LIST = RESULT.LIST;
	}
}

function RND(MAX) {
	return Math.floor(Math.random() * MAX);
}