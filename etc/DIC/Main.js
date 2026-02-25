let LF_TYPE_EL = document.getElementById("LF_TYPE");
let FILE_EL = document.getElementById("DIC");
let BF_EL = document.getElementById("BF");
let AF_EL = document.getElementById("AF");
let RESULT_EL = document.getElementById("RESULT");

let DIC_RESULT = undefined;

function START(){
	//選択されたファイルを取得します
	let file = FILE_EL.files[0];

	//ファイルリーダーオブジェクトを作成します
	let reader = new FileReader();

	//ファイルの読み込みが完了した時の処理を定義します
	reader.onload = function(e) {
		//読み込んだファイルの内容を取得します
		let DIC_CONTENTS = e.target.result;
	
		let LF_TYPE;
		switch(LF_TYPE_EL.value){
			case "N":
				LF_TYPE = "\n";
				break;
			default:
				LF_TYPE = "\n";
				break;
		}

		let DIV_AF_CONTENTS = [];

		const DATA = DIC_CONTENTS.split(LF_TYPE);
		for (let i = 0; i < DATA.length; i++) {
			console.log(DATA[i]);
			if(DATA[i] !== undefined && DATA[i] !== ""){//GoogleIMEからGBord
				if(BF_EL.value === "G_IME" && AF_EL.value === "G_B"){
					const DIC_CONTENT = DATA[i].split("\t");
					DIV_AF_CONTENTS.push(DIC_CONTENT[0] + "\t" + DIC_CONTENT[1] + "\tja-JP");
				}
			}
		}

		console.log(DIV_AF_CONTENTS);

		RESULT_EL.innerHTML = DIV_AF_CONTENTS.join("\n");
		DIC_RESULT = DIV_AF_CONTENTS.join("\n");

		//ダウンロードさせる
		DOWNLOAD();
		alert("完了しました！\nGBordの場合は、ZIPファイルに圧縮する必要があります");
	};

	// ファイルをテキストとして読み込みます
	reader.readAsText(file);
}

function DOWNLOAD(ZIP){
	const BLOB = new Blob([DIC_RESULT], { type: "text/plain" });
	const D_URL = URL.createObjectURL(BLOB);

	const LINK = document.createElement("a");
	LINK.href = D_URL;
	LINK.download = "dictionary.txt";
	LINK.click();
}