/**
 * はい。
 */

let DISPLAY_EL = document.getElementById("DISPLAY");//ここにCANVASを
let CTX = DISPLAY_EL.getContext("2d");

//これが素材
let BLOCK_ENVENT = []
let BLOCK_SELECT = 0;
let BLOCK_ROTATE = 0;
//これがマップのデータ
let MAP_DATA = []

//マウスの状態
let MOUSE_POS = {X:0, Y:0};
let MOUSE_BTN = [false, false, false];

let GSIZE = 64;

//FPS用
let FPS_SEC = undefined;
let FPS_COUNT = 0;
let FPS = 0;


//読み込み
LOAD();

//初期化
function INTI(){
	DISPLAY_EL.width = document.documentElement.clientWidth;
	DISPLAY_EL.height = document.documentElement.clientHeight;
}

//マウス移動
DISPLAY_EL.addEventListener("mousemove", (e)=>{
	const rect = DISPLAY_EL.getBoundingClientRect();
	const X = e.clientX - rect.left;
	const Y = e.clientY - rect.top;

	MOUSE_POS.X = X;
	MOUSE_POS.Y = Y;
});

//マウスを押す
DISPLAY_EL.addEventListener("mousedown", (e)=>{
	if(e.button === 0){//Left側を押した
		MOUSE_BTN[0] = true;
	}
	if(e.button === 1){//Center側を押した
		MOUSE_BTN[1] = true;
	}
	if(e.button === 2){//Right側を押した
		MOUSE_BTN[2] = true;
	}
});

//マウスを離す
DISPLAY_EL.addEventListener("mouseup", (e)=>{
	if(e.button === 0){//Left側をはなした
		MOUSE_BTN[0] = false;
	}
	if(e.button === 1){//Center側をはなした
		MOUSE_BTN[1] = false;
	}
	if(e.button === 2){//Right側をはなした
		MOUSE_BTN[2] = false;
	}
});

//コンテキストメニュー
DISPLAY_EL.addEventListener("contextmenu", (e)=>{
	e.preventDefault();
});

DISPLAY_EL.addEventListener("wheel", (E) =>{
	//event.deltaY は垂直方向のスクロール量を示すプロパティです
	console.log("スクロール量: " + E.deltaY);
	const RESULT = GSIZE + ((E.deltaY * -1) / 8);

	if(RESULT > 49){
		console.log(RESULT);
		GSIZE = RESULT;
	}
});

window.addEventListener("keydown", (E)=>{
	if(E.key !== "F5" && E.key !== "F12"){
		E.preventDefault();
	}

	console.log(E);

	if(E.key === "ArrowUp"){
		if(BLOCK_ENVENT[BLOCK_SELECT + 1] !== undefined && BLOCK_ENVENT[BLOCK_SELECT + 1] !== null){
			BLOCK_SELECT++;
		}
	}else if(E.key === "ArrowDown"){
		if(!((BLOCK_SELECT - 1) < 0)){
			BLOCK_SELECT--;
		}
	}else if(E.key === "ArrowLeft"){
		if(!((BLOCK_ROTATE - 1) < 0)){
			BLOCK_ROTATE -= 90;
		}else{
			BLOCK_ROTATE = 270;
		}
	}else if(E.key === "ArrowRight"){
		if(!((BLOCK_ROTATE + 1) > 270)){
			BLOCK_ROTATE += 90;
		}else{
			BLOCK_ROTATE = 0;
		}
	}
});

//接地とかの処理
function OBJECT_FUNC(){
	const GRID_X = Math.floor(MOUSE_POS.X / GSIZE);//X軸の選択しているグリッド
	const GRID_Y = Math.floor(MOUSE_POS.Y / GSIZE);//Y軸の選択しているグリッド

	if(MOUSE_BTN[0]){
		for (let I = 0; I < MAP_DATA.length; I++) {
			const DATA = MAP_DATA[I];
			if(DATA.X === GRID_X && DATA.Y === GRID_Y){
				return;
			}
		}
		
		MAP_DATA.push({
			TYPE:BLOCK_ENVENT[BLOCK_SELECT].NAME,
			X:GRID_X,
			Y:GRID_Y,
			ROTATE:BLOCK_ROTATE
		});
	}else if(MOUSE_BTN[2]){
		for (let I = 0; I < MAP_DATA.length; I++) {
			const DATA = MAP_DATA[I];
			if(DATA.X === GRID_X && DATA.Y === GRID_Y){
				MAP_DATA.splice(I, 1)
			}
		}
	}else if(MOUSE_BTN[1]){
		GSIZE = 50;
	}
}

//描画する
function DRAW(){
	//いろいろ計算
	const GRID_X = Math.floor(MOUSE_POS.X / GSIZE);//X軸の選択しているグリッド
	const GRID_Y = Math.floor(MOUSE_POS.Y / GSIZE);//Y軸の選択しているグリッド

	//とりま全消し
	CTX.clearRect(0, 0, DISPLAY_EL.width, DISPLAY_EL.height);

	//共通の設定
	CTX.strokeStyle = "rgb(255, 255, 255)";
	CTX.font = '48px serif';

	for (let I = 0; I < MAP_DATA.length; I++) {
		const DATA = MAP_DATA[I];
		CTX.save();//描画コンテキストの状態を保存
		BLOCK_ENVENT.forEach(BLOCK => {
			if(BLOCK.NAME === DATA.TYPE){
				CTX.beginPath();
				CTX.translate(DATA.X * GSIZE + GSIZE / 2, DATA.Y * GSIZE + GSIZE / 2);
				CTX.rotate((DATA.ROTATE * Math.PI) / 180);

				CTX.arc(0, 0, 10, 0, Math.PI * 2, true);
				CTX.strokeStyle = 'deepskyblue';
				CTX.lineWidth = 5;
				CTX.stroke();

				CTX.drawImage(BLOCK.IMG, -GSIZE / 2, -GSIZE / 2, GSIZE, GSIZE);
			}
		});
		CTX.restore();//描画コンテキストの状態を元に戻す
	}

	//グリッドの描画
	for(let X = 0; X < DISPLAY_EL.width; X += GSIZE){
		CTX.beginPath();
		CTX.moveTo(X, 0);
		CTX.lineTo(X, DISPLAY_EL.height);
		CTX.stroke();
	}
	for(let Y = 0; Y < DISPLAY_EL.height; Y += GSIZE){
		CTX.beginPath();
		CTX.moveTo(0, Y);
		CTX.lineTo(DISPLAY_EL.width, Y);
		CTX.stroke();
	}


	//選択しているグリッドの描画
	CTX.fillStyle = "rgba(255, 255, 255, 0.5)";
	CTX.fillRect(GRID_X * GSIZE, GRID_Y * GSIZE, GSIZE, GSIZE);


	//選択しているブロックの描画
	CTX.save();//描画コンテキストの状態を保存
	CTX.translate(DISPLAY_EL.width - 64, DISPLAY_EL.height - 64);
	CTX.rotate((BLOCK_ROTATE * Math.PI) / 180);
	CTX.drawImage(BLOCK_ENVENT[BLOCK_SELECT].IMG, -64 / 2, -64 / 2, 64, 64);
	CTX.restore();//描画コンテキストの状態を元に戻す

	//デバッグ(要　ら　な　い)
	CTX.fillStyle = "rgb(255, 255, 255)";
	CTX.fillText("グリッド位置:[" + GRID_X + ", " + GRID_Y + "]", 0, 50);
	CTX.fillText("FPS:" + FPS, 0, 100);
	CTX.fillText("ROTATE:" + BLOCK_ROTATE, 0, 150)


	//FPS関連(要　ら　な　い)
	const NOW_SEC = new Date().getSeconds();//現在の秒数
	if(FPS_SEC === NOW_SEC){//1秒経過したか
		FPS_COUNT++;//FPSをインクリメント
	}else{//経過した
		FPS = FPS_COUNT;//FPS数を適応させる
		FPS_SEC = NOW_SEC;//現在の秒数をFPS_SECに
		FPS_COUNT = 0;//FPSのカウントを0に
	}


	//ぬ
}

//処理
setInterval(() => {
	INTI();
	OBJECT_FUNC();
	DRAW();
}, 1);