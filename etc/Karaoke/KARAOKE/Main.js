const CONSOLE = document.getElementById("CONSOLE");
const DISPLAY = document.getElementById("DISPLAY");
const SONG_SELECT = document.getElementById("SONG_SELECT");
const SEEK_BAR = document.getElementById("SEEK_BAR");
let TRACK_INTERVAL;
let SOUND_PLAYER = new Audio();
let SONG_DATA;
let DATA_LINE = 0;

window.addEventListener("load", (e)=>{
	LOGER("==============[るみしすてむ技術デモ カラオケ]==============");
});

window.addEventListener("error", (e)=>{
	LOGER("<R style=\"color: red;\">" + e.message +"</R>");
});

function LOGER(TEXT){
	CONSOLE.innerHTML += TEXT + "<BR>";
}

function Start(){
	LOGER("再生開始命令が出されました ID:" + SONG_SELECT.value);
	let ajax = new XMLHttpRequest();
	ajax.open("GET", "./DATA/" + SONG_SELECT.value + ".json");
	ajax.addEventListener("load", (e)=>{
		if(ajax.status == 200){
			//ステータスコードが200なので続行
			LOGER("完了、ステータスコード200");
			const SONG_INFO = JSON.parse(ajax.responseText);
			console.log(SONG_INFO.LYRICS);
			SONG_DATA = SONG_INFO.LYRICS;
			LOGER("曲のタイトル：" + SONG_INFO.TITLE);

			DISPLAY.innerHTML = "<H1>" + SONG_INFO.TITLE + "</H1>";
			setTimeout(() => {
				DISPLAY.innerHTML = "";

				SOUND_PLAYER.src = "./DATA/" + SONG_INFO.SOUND;
				SOUND_PLAYER.play();
				TRACK_SHOW();
			}, 1000);
		}else{
			LOGER("失敗！ステータスコード" + ajax.status);
		}
	});
	ajax.send();
	LOGER("HTTPリクエストを送信しています、、、");
}

SOUND_PLAYER.addEventListener("loadedmetadata", (e)=>{
	DATA_LINE = 0;
	SEEK_BAR.value = 0;
	SEEK_BAR.min = 0;
	SEEK_BAR.max = SOUND_PLAYER.duration;
});

SOUND_PLAYER.addEventListener("ended", (e)=>{
	clearInterval(TRACK_INTERVAL);
});

function TRACK_SHOW(){
	TRACK_INTERVAL = setInterval(() => {
		SEEK_BAR.value = SOUND_PLAYER.currentTime;

		const TIME = SOUND_PLAYER.currentTime;

		if(SONG_DATA[DATA_LINE] != undefined){
			if(SONG_DATA[DATA_LINE].TIME < TIME){
				console.log("一致")
				DISPLAY.innerHTML = "<H2>" + SONG_DATA[DATA_LINE].TEXT + "</H2>";
				DATA_LINE++;
			}
		}
	}, 1);
}

SEEK_BAR.addEventListener("change", (e)=>{
	SOUND_PLAYER.currentTime = SEEK_BAR.value;
});