class EDITOR {
	IME_NOW = false;
	POS = {X:0, Y:0}; //横/縦
	OLD_POS = {X:0, Y:0};
	INPUT_TEMP = "";
	INDENT = "\t";
	EDIT_STAKK = {POS:0, STAKK:[]};
	TEXT_DATA = [];
	EL = {
		INPUT:null,
		STATUS:null,
		EDIT:null
	};

	constructor(CONTENTS, FILENAME, PEL) {
		let EDIT_EL = document.createElement("DIV");
		EDIT_EL.id = "EDITOR";
		EDIT_EL.className = "EDITOR";

		let STATUS_EL = document.createElement("DIV");
		STATUS_EL.innerText = "0,0";

		let INPUT_EL = document.createElement("INPUT");
		INPUT_EL.addEventListener("keydown", (E) => {
			if (!this.IME_NOW) {
				if (E.ctrlKey) {
					E.preventDefault();
					this.CTRL_KEY(E);
				} else {
					this.KEY(E);
				}
			}
		});
		INPUT_EL.addEventListener("compositionupdate", (E) => {
			this.IME_NOW = true;
		});
		INPUT_EL.addEventListener("compositionend", (E) => {
			this.IME_NOW = false;
		});
		INPUT_EL.addEventListener("input", (E) => {
			if (!this.IME_NOW) {
				this.INPUT_TEMP = this.EL.INPUT.value;
				this.EL.INPUT.value = "";
				this.INPUT_MERGE();
			}
		});

		PEL.appendChild(INPUT_EL);
		PEL.appendChild(EDIT_EL);
		PEL.appendChild(STATUS_EL);

		this.EL.EDIT = EDIT_EL;
		this.EL.STATUS = STATUS_EL;
		this.EL.INPUT = INPUT_EL;

		//ファイル内容をパース
		for (let I = 0; I < CONTENTS.split("\n").length; I++) {
			const LINE = CONTENTS.split("\n")[I];
			this.TEXT_DATA.push(LINE.split(""));

			this.EDIT_STAKK["STAKK"].push(
				{
					"X": 0,
					"Y": I,
					"TYPE": "NEW_LINE"
				}
			);
			this.EDIT_STAKK["STAKK"].push(
				{
					"X": 0,
					"Y": I,
					"TYPE": "ADD",
					"SIZE": 0,
					"CONTENTS": "" //※無指定しないと、ADDの処理は「前半 + CONTENTS + 後半」なのでおかしなことになるぜ
				}
			);
		}

		this.EDIT_STAKK["STAKK"].push(CURSOR_ADDSTAKK(0, 0, 0, 0));

		//表示をアップデート
		this.TEXTEDIT_FIELD_UPDATE();
	}

	//コントロールキー同時押し
	CTRL_KEY(E) {
		
	}

	//唯のキー入力
	KEY(E) {
		switch(E.key) {
			case "ArrowDown":
			case "ArrowUp":
			case "ArrowLeft":
			case "ArrowRight": {
				const RESULT_POS = CURSOR_MOVE(E.key, this.TEXT_DATA, this.POS["X"], this.POS["Y"]);

				if (RESULT_POS.X === this.POS["X"] || RESULT_POS.Y === this.POS["Y"]) {
					this.SET_OLD_POS();

					this.POS["X"] = RESULT_POS.X;
					this.POS["Y"] = RESULT_POS.Y;

					//上下に移動した時に横幅が其の行を超えていたら治すやつ
					if ((this.POS["X"]) >= (this.TEXT_DATA[this.POS["Y"]].length)) {
						this.POS["X"] = (this.TEXT_DATA[this.POS["Y"]].length);
					}

					//スタックに入れたり描画したり
					this.EDIT_STAKK["STAKK"].push(CURSOR_ADDSTAKK(this.OLD_POS["X"], this.OLD_POS["Y"], this.POS["X"], this.POS["Y"]));
					this.TEXTEDIT_FIELD_UPDATE();
				}

				break;
			}

			case "Home":
			case "End": {
				const RESULT_POS = CURSOR_HOME_END(E.key, this.TEXT_DATA, this.POS["X"], this.POS["Y"], this.INDENT);

				if (RESULT_POS.X === this.POS["X"] || RESULT_POS.Y === this.POS["Y"]) {
					this.SET_OLD_POS();

					this.POS["X"] = RESULT_POS.X;
					this.POS["Y"] = RESULT_POS.Y;

					//スタックに入れたり描画したり
					this.EDIT_STAKK["STAKK"].push(CURSOR_ADDSTAKK(this.OLD_POS["X"], this.OLD_POS["Y"], this.POS["X"], this.POS["Y"]));
					this.TEXTEDIT_FIELD_UPDATE();
				}
				break;
			}

			case "Tab": {
				E.preventDefault();

				this.INPUT_TEMP = this.INDENT;
				this.INPUT_MERGE();
				break;
			}

			case "Enter": {
					//入力欄がStringNullなら改行し、そうでないなら入力をマージする
					if (this.EL.INPUT.value === "") {
						const ZENHAN = this.TEXT_DATA[this.POS["Y"]].slice(0, this.POS["X"]);
						const KOUHAN = this.TEXT_DATA[this.POS["Y"]].slice(this.POS["X"], (this.TEXT_DATA[this.POS["Y"]].length));

						//新しい行にカーソル位置からRight側を入れる
						this.TEXT_DATA.splice(this.POS["Y"] + 1, 0, KOUHAN);
						//前の行に最初からカーソル位置までに書き換える
						this.TEXT_DATA[this.POS["Y"]] = ZENHAN;

						this.EDIT_STAKK["STAKK"].push(
							{
								"X": 0,
								"Y": this.POS["Y"] + 1,
								"TYPE": "NEW_LINE"
							}
						);

						//カーソル位置を横0にし、縦を新しく作った行にする
						this.POS["X"] = -1;//(なんか-1じゃないと1つ横にずれるｗｗ)
						this.POS["Y"] = this.POS["Y"] + 1;

						//カーソル移動を色々処理
						this.SET_OLD_POS();
						this.EDIT_STAKK["STAKK"].push(CURSOR_ADDSTAKK(this.OLD_POS["X"], this.OLD_POS["Y"], this.POS["X"], this.POS["Y"]));
					}

					this.INPUT_MERGE();
				break;
			}

			case "Backspace": {
				//入力欄が空なら実行
				if (this.INPUT_TEMP === "") {
					//その行の文字数が0なら改行を消す
					if (this.TEXT_DATA[this.POS["Y"]].length !== 0) {
						//横軸が0なら上の行にくっつける
						if (this.POS["X"] != 0) {
							//今のLeft側の文字を消す
							this.TEXT_DATA[this.POS["Y"]].splice(this.POS["X"] - 1, 1);

							//スタックに追加
							this.EDIT_STAKK["STAKK"].push(
								{
									"TYPE": "RELOAD_LINE",
									"Y": this.POS["Y"]
								}
							);
						} else {
							if (this.POS["Y"] >= 1){
								//上の行と今の行を結合する
								const UE = this.TEXT_DATA[this.POS["Y"] - 1].slice(0, this.TEXT_DATA[this.POS["Y"] - 1].length).join("");
								const IMA = this.TEXT_DATA[this.POS["Y"]].slice(this.POS["X"], (this.TEXT_DATA[this.POS["Y"]].length)).join("");

								//結合したものを上の行に入れる
								this.TEXT_DATA[this.POS["Y"] - 1] = (UE + IMA).split("");

								//今の行を消す
								this.TEXT_DATA.splice(this.POS["Y"], 1);

								//座標を今の前の行に変える
								this.POS["Y"]--;
								this.POS["X"] = (UE.split("").length + 1);

								//スタックに追加
								this.EDIT_STAKK["STAKK"].push(
									{
										"TYPE": "DEL_LINE",
										"Y": this.POS["Y"] + 1
									}
								);
								this.EDIT_STAKK["STAKK"].push(
									{
										"TYPE": "RELOAD_LINE",
										"Y": this.POS["Y"]
									}
								);
							}
						}

						//0以下じゃないなら座標をLeftにする
						if (this.POS["X"] >= 1){
							this.SET_OLD_POS();

							this.POS["X"]--;

							this.EDIT_STAKK["STAKK"].push(CURSOR_ADDSTAKK(this.OLD_POS["X"], this.OLD_POS["Y"], this.POS["X"], this.POS["Y"]));
						}
					} else {
						//しかしY軸が0で無い場合に限る
						if (this.POS["Y"] >= 1){
							//今の行を消す
							this.TEXT_DATA.splice(this.POS["Y"], 1);

							//座標を今の前の行に変える
							this.POS["Y"]--;
							this.POS["X"] = (this.TEXT_DATA[this.POS["Y"]].length);

							//スタックに追加
							this.EDIT_STAKK["STAKK"].push(
								{
									"TYPE": "DEL_LINE",
									"Y": this.POS["Y"] - 1
								}
							);
							this.EDIT_STAKK["STAKK"].push(CURSOR_ADDSTAKK(this.OLD_POS["X"], this.OLD_POS["Y"], this.POS["X"], this.POS["Y"]));
						}
					}

					this.TEXTEDIT_FIELD_UPDATE();
				}
				break;
			}

			case "Delete": {
				//入力欄が空なら実行
				if (this.INPUT_TEMP === "") {
					//その行の文字数が0なら改行を消す
					if (this.TEXT_DATA[this.POS["Y"]].slice(this.POS["X"], (this.TEXT_DATA[this.POS["Y"]].length)).length !== 0) {
						this.TEXT_DATA[this.POS["Y"]].splice(this.POS["X"], 1);

						//スタックに追加
						this.EDIT_STAKK["STAKK"].push(
							{
								"X": 0,
								"Y": this.POS["Y"],
								"TYPE": "BSDEL"
							}
						);
					} else {
						//そもそも次行があるか？
						if (this.TEXT_DATA[this.POS["Y"] + 1] != null) {
							//その次行の文字数が0じゃないなら改行を消す
							if (TEXT[this.POS["Y"] + 1].length !== 0) {
								//次行を今の行に持ってくる
								this.TEXT_DATA[this.POS["Y"]] = ( (this.TEXT_DATA[this.POS["Y"]].join("")) + (this.TEXT_DATA[this.POS["Y"] + 1].join("")) ).split("");
							}

							//次行を消す
							this.TEXT_DATA.splice(this.POS["Y"] + 1, 1);

							//スタックに追加
							this.EDIT_STAKK["STAKK"].push(
								{
									"TYPE": "DEL_LINE",
									"Y": this.POS["Y"] + 1
								}
							);
							this.EDIT_STAKK["STAKK"].push(
								{
									"TYPE": "RELOAD_LINE",
									"Y": this.POS["Y"]
								}
							);
						}
					}

					this.TEXTEDIT_FIELD_UPDATE();
				}
				break;
			}

			default: {
				console.log(E.key);
			}
		}

		this.EL.STATUS.innerText = `行${this.POS["Y"] + 1}/横${this.POS["X"] + 1} Y${this.POS["Y"]}/X${this.POS["X"]} スタック${this.EDIT_STAKK.STAKK.length}`;
	}

	SET_OLD_POS() {
		//今のを古い方に入れる
		this.OLD_POS["X"] = this.POS["X"];
		this.OLD_POS["Y"] = this.POS["Y"];
	}

	TEXTEDIT_FIELD_UPDATE() {
		for (let I = this.EDIT_STAKK.POS; I < this.EDIT_STAKK.STAKK.length; I++) {
			const STAKK = this.EDIT_STAKK.STAKK[I];
			if (STAKK.TYPE === "NEW_LINE") {
				if (this.EL.EDIT.querySelector("#TEXT_LINE-" + STAKK["Y"]) == null) {
					//前の行を更新
					let TARGET_LINE_EL = this.EL.EDIT.querySelector("#TEXT_LINE-" + (STAKK["Y"] - 1));
					if (TARGET_LINE_EL != null) {
						TARGET_LINE_EL.setAttribute("select", "false");//たぶんselectされてないだろう。。。という安直な思考
						TARGET_LINE_EL.querySelector("#LC").innerHTML = SYNTAX_ST(this.TEXT_DATA[STAKK["Y"] - 1].join(""));
					}

					//新しい行を追加
					this.EL.EDIT.innerHTML +=
						`<DIV ID="TEXT_LINE-${STAKK["Y"]}" CLASS="TEXT_LINE" data-ln="${STAKK["Y"]}" select=\"false\">`+
							`<SPAN ID="LN" CLASS="LN">` +
								`<LABEL>${STAKK["Y"] + 1}</LABEL>` +
							`</SPAN>` +
							`<SPAN ID="LC" CLASS="LC">\n</SPAN>` +
						`</DIV>`;
				} else {
					//改行した行から下をすべて削除
					for (let I = STAKK["Y"] - 1; I < this.TEXT_DATA.length; I++) {
						let TARGET_LINE_EL = this.EL.EDIT.querySelector("#TEXT_LINE-" + I);
						if (TARGET_LINE_EL != null) {
							TARGET_LINE_EL.remove();
						}
					}

					for (let I = STAKK["Y"] - 1; I < this.TEXT_DATA.length; I++) {
						const LINE = this.TEXT_DATA[I];
						this.EL.EDIT.innerHTML +=
							`<DIV ID="TEXT_LINE-${I}" CLASS="TEXT_LINE" data-ln="${I}" select=\"false\">`+
								`<SPAN ID="LN" CLASS="LN">` +
									`<LABEL>${I + 1}</LABEL>` +
								`</SPAN>` +
								`<SPAN ID="LC" CLASS="LC">${SYNTAX_ST(LINE.join(""))}\n</SPAN>` +
							`</DIV>`;
					}
				}
			} else if (STAKK.TYPE === "DEL_LINE") {
				//消したした行含むその下をすべて削除(なんかTEXITDATAの長さに+1しないとうまく消えない)
				for (let I = STAKK["Y"]; I < this.TEXT_DATA.length + 1; I++) {
					let TARGET_LINE_EL = this.EL.EDIT.querySelector("#TEXT_LINE-" + I);
					if (TARGET_LINE_EL != null) {
						TARGET_LINE_EL.remove();
					}
				}

				for (let I = STAKK["Y"]; I < this.TEXT_DATA.length; I++) {
					const LINE = this.TEXT_DATA[I];
					this.EL.EDIT.innerHTML +=
						`<DIV ID="TEXT_LINE-${I}" CLASS="TEXT_LINE" data-ln="${I}" select=\"false\">`+
							`<SPAN ID="LN" CLASS="LN">` +
								`<LABEL>${I + 1}</LABEL>` +
							`</SPAN>` +
							`<SPAN ID="LC" CLASS="LC">${SYNTAX_ST(LINE.join(""))}\n</SPAN>` +
						`</DIV>`;
				}
			} else if (STAKK.TYPE === "ADD" || STAKK.TYPE === "BSDEL" || STAKK.TYPE === "RELOAD_LINE") {
				let TL_EL = this.EL.EDIT.querySelector("#TEXT_LINE-" + STAKK["Y"]);

				//指定された行は有るか
				if (TL_EL != null) {
					let LC = TL_EL.querySelector("#LC");
					const ZENHAN = SYNTAX_ST(this.TEXT_DATA[STAKK["Y"]].slice(0, this.POS["X"]).join(""));
					const KOUHAN = SYNTAX_ST(this.TEXT_DATA[STAKK["Y"]].slice(this.POS["X"]).join(""));

					if (STAKK.TYPE === "ADD") {
						LC.innerHTML = ZENHAN + STAKK["CONTENTS"] + KOUHAN;
					} else {
						LC.innerHTML = ZENHAN + KOUHAN;
					}
				}
			} else if (STAKK.TYPE === "MOVE_CURSOR") {
				let OLD_TL_EL = this.EL.EDIT.querySelector("#TEXT_LINE-" + STAKK["OLD_Y"]);
				let NEW_TL_EL = this.EL.EDIT.querySelector("#TEXT_LINE-" + STAKK["Y"]);

				//指定された行は有るか
				if (OLD_TL_EL != null && NEW_TL_EL != null) {
					let OLD_LC = OLD_TL_EL.querySelector("#LC");
					let NEW_LC = NEW_TL_EL.querySelector("#LC");
					const NEW_ZENHAN = SYNTAX_ST(this.TEXT_DATA[STAKK["Y"]].slice(0, STAKK["X"]).join(""));
					const NEW_KOUHAN = SYNTAX_ST(this.TEXT_DATA[STAKK["Y"]].slice(STAKK["X"]).join(""));

					//古い方と新しい方の内容を書き換える
					OLD_LC.innerHTML = SYNTAX_ST(this.TEXT_DATA[STAKK["OLD_Y"]].join(""));
					NEW_LC.innerHTML = NEW_ZENHAN + "<SPAN CLASS=\"CURSOR\"></SPAN>" + NEW_KOUHAN

					//古い方のselectをfalseに、新しい方をtrueに
					OLD_TL_EL.setAttribute("select", "false");
					NEW_TL_EL.setAttribute("select", "true");
				}
			}
		}

		//スタックの位置をアップデート
		this.EDIT_STAKK.POS = this.EDIT_STAKK.STAKK.length;
	}

	INPUT_MERGE() {
		const ZENHAN = this.TEXT_DATA[this.POS["Y"]].slice(0, this.POS["X"]).join("");
		const KOUHAN = this.TEXT_DATA[this.POS["Y"]].slice(this.POS["X"], (this.TEXT_DATA[this.POS["Y"]].length)).join("");
		const MERGE_TEXT = ZENHAN + this.INPUT_TEMP + KOUHAN;

		//スタックに入れる
		this.EDIT_STAKK["STAKK"].push(
			{
				"TYPE": "ADD",
				"X": this.POS["X"],
				"Y": this.POS["Y"],
				"SIZE": this.INPUT_TEMP.length,
				"CONTENTS": this.INPUT_TEMP
			}
		);

		//マージ
		this.TEXT_DATA[this.POS["Y"]] = MERGE_TEXT.split("");

		//横軸を変える
		this.KEY({"key":"ArrowRight"});

		//一時変数をクリア
		this.INPUT_TEMP = "";
		
		//表示面を更新
		this.TEXTEDIT_FIELD_UPDATE();
	}
}