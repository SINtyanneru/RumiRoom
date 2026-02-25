/**
 * 初心者でもわかりやすいようにヘルプを表示するのだ！
 */

const HELP = {
	"BROWSER":{
		"TITLE":"ブラウザ",
		"TEXT":"貴様が今使っているものだよ！！"
	},
	"BROWSER_NAME":{
		"TITLE":"ブラウザ名",
		"TEXT":"これは、ブラウザの名前です、そのまんまです<BR>Chrome/FireFox/Floorp/Opera/Edge/IE/Safari/に対応"
	},
	"BROWSER_VER":{
		"TITLE":"バージョン",
		"TEXT":"これは、ブラウザのバージョンです"
	},
	"OS":{
		"TITLE":"OS",
		"TEXT":"オペレーティングシステム"
	},
	"OS_NAME":{
		"TITLE":"OS名",
		"TEXT":"LINUXならLINUX、WindowsならWindows！"
	},
	"OS_VER":{
		"TITLE":"バージョン",
		"TEXT":"OSのバージョンです"
	},
	"CLIENT":{
		"TITLE":"クライアント",
		"TEXT":"貴　様　の　こ　と　だ　よ"
	},
	"CLIENT_IP":{
		"TITLE":"IP",
		"TEXT":"インターネット上の住所みたいなもの<BR>よく、「IPは緯度経度、ドメイン(URL)は住所」と言われることがある"
	},
	"CLIENT_UA":{
		"TITLE":"ユーザーエージェント",
		"TEXT":"お前の使っているブラウザとデバイス名がここに入っている、みんな公表しているものなので怖がる心配はない、嫌なら偽造することもできる"
	},
	"CLIENT_ENC":{
		"TITLE":"許可エンコード",
		"TEXT":"クライアントが許可しているエンコード形式、圧縮の方であり文字列ではない！"
	},
	"CLIENT_LANG":{
		"TITLE":"言語",
		"TEXT":"あなたの言語です、英語わからんのに英語にしてるのはただのイキり野郎です"
	},
	"CLIENT_AC":{
		"TITLE":"HTTP許可",
		"TEXT":"クライアントが許可しているファイル形式"
	},
	"SERVER":{
		"TITLE":"鯖",
		"TEXT":"私です"
	},
	"SERVER_IP":{
		"TITLE":"IP",
		"TEXT":"わたしのローカルでの住所です()"
	},
	"SERVER_SOFT":{
		"TITLE":"サーバーソフト",
		"TEXT":"ApacheとかNGINXとか、、るみ鯖はApache(外側がNGINX)"
	},
	"SERVER_PORT":{
		"TITLE":"ポート",
		"TEXT":"玄関の番号です、80版は鍵してないので誰でも入れるってわけ"
	},
	"SERVER_TIME":{
		"TITLE":"リクエスト時間",
		"TEXT":"たぶんUNIX時間"
	},
	"SERVER_PROT":{
		"TITLE":"プロトコル",
		"TEXT":"ぷろｔこる"
	}
};

let HELP_POP = document.getElementById("HELP_POP");

window.addEventListener("mousemove", (e)=>{
	HELP_POP.style.top = e.y + 10;
	HELP_POP.style.left = e.x + 10;
	if(HELP[e.target.dataset.help_id] !== undefined){
		//表示する
		HELP_POP.style.display = "block";

		//中身に説明を入れる
		HELP_POP.innerHTML = HELP[e.target.dataset.help_id]["TITLE"]+
							"<HR>"+
							HELP[e.target.dataset.help_id]["TEXT"];
	}else{
		//中身を消す
		HELP_POP.innerHTML = "";

		//消す
		HELP_POP.style.display = "none";
	}
});