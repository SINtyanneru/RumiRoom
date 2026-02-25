console.log("[ OK ]system script load")

var TASK_NAME = Array();
var TASK_ID = Array();
var TASK_ID_BK;

function TaskStart(NAME){
	var ID = Math.floor( Math.random() * 100 );
	retry:
	if(TASK_ID_BK == ID){
		TASK_ID_BK = ID;
	}else{
		ID = Math.floor( Math.random() * 100 );
		break retry;
	}

	TASK_NAME.push(NAME);
	TASK_ID.push(ID);

	return ID;
}

function TaskExit(ID){
	const INDEXOF = TASK_ID.indexOf(ID);
	TASK_NAME.splice(INDEXOF,INDEXOF + 1)
	TASK_ID.splice(INDEXOF,INDEXOF + 1)

	return"OK";
}

function TaskList(){
	return TASK_ID + TASK_NAME;
}

function keypress_event(e) {
	console.log(e.key);
}

document.addEventListener('keypress', keypress_event);

window.onload = (e) => {
};