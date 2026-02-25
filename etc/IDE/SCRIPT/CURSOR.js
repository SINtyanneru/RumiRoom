function CURSOR_MOVE(KEY, TEXT_DATA, X, Y) {
	let OLD_X = X;
	let OLD_Y = Y;

	switch(KEY) {
		case "ArrowUp": {
			if (Y >= 1) {
				Y--;
			}
			break;
		}

		case "ArrowDown":{
			if ((Y + 1) <= (TEXT_DATA.length - 1)) {
				Y++;
			}
			break;
		}

		case "ArrowLeft": {
			if (X >= 1){
				X--;
			}
			break;
		}

		case "ArrowRight": {
			if ((X + 1) <= (TEXT_DATA[Y].length)) {
				X++;
			}
			break;
		}
	}

	//上下に移動した時に横幅が其の行を超えていたら治すやつ
	//↑これはEDITOR.jsに移動した、なぜかここで実行すると上下移動がうごかなくなるので、
	//たぶんJSという言語がクソだからに他ならないだろう
	//まじでムカつく言語すぎるぞJS、くたばれ

	return {
		"X":X,
		"Y":Y
	};
}

function CURSOR_HOME_END(KEY, TEXT_DATA, X, Y, INDENT) {
	if (KEY === "Home") {
		//今の横軸の-1にTAB文字があれば0に、そうじゃないならTABの先端に
		if (TEXT_DATA[Y][X - 1] === INDENT) {
			X = 0;
		} else {
			for (let I = 0; I < TEXT_DATA[Y].length; I++) {
				const S = TEXT_DATA[Y][I];
				if (S !== INDENT) {
					X = I;
					break;
				}
			}
		}
	} else {
		X = (TEXT_DATA[Y].length);
	}

	return {
		"X":X,
		"Y":Y
	};
}

function CURSOR_ADDSTAKK(OLD_X, OLD_Y, NEW_X, NEW_Y){
	return {
		"TYPE": "MOVE_CURSOR",
		"OLD_X": OLD_X,
		"OLD_Y": OLD_Y,
		"X": NEW_X,
		"Y": NEW_Y,
	};
}