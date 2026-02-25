window.addEventListener("keypress", (e)=>{
	switch(e.key){
		case "1":
			SOUND_CHECK();
			break;
		case "2":
			SOUND_SELECT();
			break;
		case "3":
			SOUND_SELECT();
			break;
		case "4":
			SOUND_SELECT();
			break;
		case "5":
			SOUND_SELECT();
			break;
		case "6":
			SOUND_SELECT();
			break;
		case "7":
			SOUND_SELECT();
			break;
		case "8":
			SOUND_SELECT();
			break;
		case "9":
			SOUND_SELECT();
			break;
		case "0":
			SOUND_SELECT();
			break;

		default:
			SOUND_SELECT();
			break;
	}
});

function SOUND_CHECK(){
	let SOUND = new Audio();
	SOUND.src = "./SOUNDS/Check.wav";
	SOUND.play();
}

function SOUND_SELECT(){
	let SOUND = new Audio();
	SOUND.src = "./SOUNDS/Select.wav";
	SOUND.play();
}

function BGM_PLAY(){

}