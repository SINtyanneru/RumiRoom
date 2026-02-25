const WebSocket = require('ws');

//WebSocketサーバーのポート番号
const port = 8089;

//WebSocketサーバーの作成
const server = new WebSocket.Server({ port: port });
let clients = [];
let TYPING = {};
let SENDED = {};

//BANリスト
const WHITELIST = [
	"1.33.226.245",
	"192.168.100.120",
	"60.110.78.8"
];

//ユーザー名
const USER_NAME = {
	"1.33.226.245":"風緑",
	"192.168.100.120":"るみさん",
	"":"プヌスク_K"
};

//接続時の処理
server.on('connection', (socket, request)=>{
	const IP = request.headers["client-ip"];
	let SESSION = undefined;

	console.log("[ INFO ]NEW Client Connect:" + IP);

	if(!WHITELIST.includes(IP)){
		socket.send(JSON.stringify({
			"TYPE":"MSG_RSV",
			"USER":"システム",
			"TEXT":"お前はホワイトリストに入ってないです、なんでホワイトリスト方式になったのか考えてもらって"
		}));

		socket.close();

		console.log("[ KICK ]" + IP + "は、ホワイトリストに入ってないので蹴りました");
		return;
	}

	clients.push({
		SOCKET:socket,
		REQUEST:request
	});
	
	ALL_SEND(JSON.stringify({
		"TYPE":"NEW_LOGIN",
		"USER":IP
	}));

	ALL_SEND(JSON.stringify({
		"TYPE":"USER_LIST_UPDATE",
		"USER_LIST":USER_LIST()
	}));

	//メッセージ受信時の処理
	socket.on('message', (MSG)=>{
		const RESULT = JSON.parse(MSG);

		console.log("[ " + IP + " ]" + MSG);
		
		if(RESULT.TYPE === "LOGIN"){
			SESSION = RESULT.SESSION;
		}

		if(RESULT.TYPE === "MSG_SEND"){
			if(RESULT.TEXT !== "" && RESULT.TEXT.replaceAll(" ", "").replaceAll("\u3000", "").replaceAll("\u200c", "").replaceAll("\u001b", "").replaceAll("\u0000", "") !== ""){
				let DATE = new Date();
				let DATE_ = parseInt(DATE.getMinutes().toString() + DATE.getSeconds().toString());
				if(!SENDED[IP]){
					SENDED[IP] = {
						"DATE":DATE_
					};
				}else{
					if((SENDED[IP].DATE + 1) < DATE_){
						SENDED[IP] = {
							"DATE":DATE_
						};
					}else{
						return;
					}
				}

				ALL_SEND(JSON.stringify({
					"TYPE":"MSG_RSV",
					"USER":USER_NAME_TEXT(IP),
					"TEXT":RESULT.TEXT.toString().replaceAll("<", "&#60;").replaceAll(">", "&#62;")
				}));
			}
		}

		if(RESULT.TYPE === "TYPING"){
			TYPING[IP] = {
				"TYPING":RESULT.TYPEING,
				"DATE":new Date()
			};

			ALL_SEND(JSON.stringify({
				"TYPE":"TYPING",
				"TYPING_LIST":TYPING
			}));
		}

	});

	//切断時の処理
	socket.on('close', ()=>{
		console.log("[ INFO ] Client disconnected");

		ALL_SEND(JSON.stringify({
			"TYPE":"USER_LIST_UPDATE",
			"USER_LIST":USER_LIST()
		}));
	});
});
function ALL_SEND(TEXT){
	clients.forEach(client => {
		if (client.SOCKET.readyState === WebSocket.OPEN) {
			client.SOCKET.send(TEXT);
		}
	});
}

function USER_LIST(){
	let USERS = [];
	clients.forEach(client => {
		if (client.SOCKET.readyState === WebSocket.OPEN){
			USERS.push(client.REQUEST.headers["client-ip"]);
		}
	});

	return USERS;
}


setInterval(() => {
	const TYPING_KEYS = Object.keys(TYPING);
	const NOW_DATE = new Date();

	TYPING_KEYS.forEach(KEY => {
		const TYPING_USER = TYPING[KEY];

		if(NOW_DATE.getSeconds() - TYPING_USER.DATE.getSeconds() > 10){//最後にタイピングした時間から10秒以上経過したら
			if(TYPING[KEY].TYPING){
				TYPING[KEY].TYPING = false;

				ALL_SEND(JSON.stringify({
					"TYPE":"TYPING",
					"TYPING_LIST":TYPING
				}));
			}
		}
	});
}, 1000);

function USER_NAME_TEXT(IP){
	if(USER_NAME[IP]){
		return USER_NAME[IP];
	}

	return IP;
}

console.log(`WebSocket server is listening on port ${port}`);
