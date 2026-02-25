const PROGRAM = document.getElementById("PROGRAM");
let PROGRAM_DATA;
let PROGRAM_COUNT = 0;

PROGRAM_GET();

setInterval(() => {
	PROGRAM_VIEW();
}, 3000);

setInterval(() => {
	PROGRAM_GET();
}, 10000);

function PROGRAM_GET(){
	let ajax = new XMLHttpRequest();
	ajax.open("GET", "/API/Rumisan/ANIME.php");
	ajax.addEventListener("load", (e)=>{
		const DATA = JSON.parse(ajax.responseText);
		PROGRAM_DATA = DATA;
		PROGRAM_VIEW();
	});

	ajax.send();
}

function PROGRAM_VIEW(){
	if(PROGRAM_DATA == undefined){
		return;
	}

	PROGRAM.innerHTML = "<a target=\"_blank\" href=\"" + PROGRAM_DATA[PROGRAM_COUNT].URL + "\">・" + "( " + PROGRAM_DATA[PROGRAM_COUNT].PLATFORM + " )" + PROGRAM_DATA[PROGRAM_COUNT].TITLE + "</a>";
	PROGRAM_COUNT++;

	if(PROGRAM_DATA.length == PROGRAM_COUNT){
		PROGRAM_COUNT = 0;
	}
}