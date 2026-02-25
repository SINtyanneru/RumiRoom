const DISPLAY = document.getElementById("DISPLAY");
const DISPLAY_PIC_LIST = [{"SRC":"./DISPLAY/3605.png"}, {"SRC":"./DISPLAY/ADS_0001.png"}, {"SRC":"./DISPLAY/ADS_0002.png"}, {"SRC":"./DISPLAY/SOUND.png"}, {"SRC":"./DISPLAY/RTMP.png"}]
let DISPLAY_COUNT = 0;

DISPLAY_VIEW();

setInterval(() => {
	DISPLAY_VIEW();
}, 8000);

function DISPLAY_VIEW(){
	if(DISPLAY_PIC_LIST == undefined){
		return;
	}

	DISPLAY.innerHTML = "<IMG src=\"" + DISPLAY_PIC_LIST[DISPLAY_COUNT].SRC + "\" style=\"width: 100%;\">";
	DISPLAY_COUNT++;

	if(DISPLAY_PIC_LIST.length == DISPLAY_COUNT){
		DISPLAY_COUNT = 0;
	}
}