let STAMP_DATA = [];
let STAMP_ID = "";
const BASE_URL = "/etc/LINE_Sticker/List/";

//スタンプの情報を表示する＆URLを書き換える
function STICKER_INFO_DRAW(THUMBNAIL, TITLE, AUTHOR, ID){
	EL_STAMP_INFO.innerHTML = "<IMG SRC=\"" + THUMBNAIL + "\" HEIGHT=\"48px\">" + "<SPAN>「" + TITLE + "」 制作：" + AUTHOR + "<SPAN>";

	//URL書き換え
	history.pushState("", "", BASE_URL + ID);
}

function CPI(id){
	//navigator.clipboardが使えるか判定する
	if (navigator.clipboard) {
		navigator.clipboard.writeText("https://rumi-room.net/etc/LINE_Sticker/image.gif?ID=" + id).then(() => {
			//成功
			MSG_BOX(id + "をクリップボードに書いた！")
		})
	} else {
		MSG_BOX("クリップボードが使えんｗｗ");
	}
}

function MSG_BOX(TEXT){
	let MSG_BOX = document.createElement("DIV");
	MSG_BOX.className = "MSG_BOX";
	MSG_BOX.innerHTML = TEXT;

	EL_MSG_BOX_OWNER.appendChild(MSG_BOX);
	setTimeout(() => {
		MSG_BOX.remove();
	}, 3000);
}
