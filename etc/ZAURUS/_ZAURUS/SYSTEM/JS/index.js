var INDEX_APP_ID;
var INDEX_APP_MODE = false;

const INDEX_HOME1 = "[{\"ID\":\"TEST\",\"NAME\":\"TEST\"},{\"ID\":\"TEST2\",\"NAME\":\"TEST2\"},{\"ID\":\"TEST2\",\"NAME\":\"TEST2\"},{\"ID\":\"TEST2\",\"NAME\":\"TEST2\"}]";
const INDEX_HOME2 = "[{\"ID\":\"TEST\",\"NAME\":\"TEST\"},{\"ID\":\"TEST2\",\"NAME\":\"TEST2\"},{\"ID\":\"TEST2\",\"NAME\":\"TEST2\"},{\"ID\":\"TEST2\",\"NAME\":\"TEST2\"}]";
const INDEX_ORIGINAL = "[{\"ID\":\"TEST\",\"NAME\":\"TEST\"},{\"ID\":\"TEST2\",\"NAME\":\"TEST2\"},{\"ID\":\"TEST2\",\"NAME\":\"TEST2\"},{\"ID\":\"TEST2\",\"NAME\":\"TEST2\"}]";
const INDEX_DATA = "[{\"ID\":\"TEST\",\"NAME\":\"TEST\"},{\"ID\":\"TEST2\",\"NAME\":\"TEST2\"},{\"ID\":\"TEST2\",\"NAME\":\"TEST2\"},{\"ID\":\"TEST2\",\"NAME\":\"TEST2\"}]";
const INDEX_SYSTEM_SETTING = "[{\"ID\":\"TEST\",\"NAME\":\"TEST\"},{\"ID\":\"TEST2\",\"NAME\":\"TEST2\"},{\"ID\":\"TEST2\",\"NAME\":\"TEST2\"},{\"ID\":\"TEST2\",\"NAME\":\"TEST2\"}]";
const INDEX_SYSTEM = "[{\"ID\":\"TEST\",\"NAME\":\"TEST\"},{\"ID\":\"TEST2\",\"NAME\":\"TEST2\"},{\"ID\":\"TEST2\",\"NAME\":\"TEST2\"},{\"ID\":\"TEST2\",\"NAME\":\"TEST2\"}]";
const INDEX_MORE = "[{\"ID\":\"TEST\",\"NAME\":\"TEST\"},{\"ID\":\"TEST2\",\"NAME\":\"TEST2\"},{\"ID\":\"TEST2\",\"NAME\":\"TEST2\"},{\"ID\":\"TEST2\",\"NAME\":\"TEST2\"}]";

window.onload = (e) => {
	INDEX_APP_ID = TaskStart("INDEX");
	INDEX_APP_MODE = true;
};

function index_close(){
	document.getElementById("INDEX").style.display = "none";

	TaskExit(INDEX_APP_ID);

	INDEX_APP_MODE = false;

	console.log("INDEX EXIT");
}

function keypress_event(e) {
	if(e.key == 6){
		if(!INDEX_APP_MODE){
			document.getElementById("INDEX").style.display = "block";
	
			INDEX_APP_ID = TaskStart("INDEX");
	
			INDEX_APP_MODE = true;
		}
	}
}

document.addEventListener('keypress', keypress_event);

function Index_onch(){
	const index_value = document.getElementById("INDEX_SELECT").value;
	switch(index_value){
		case "HOME1":
			Index_ch(INDEX_HOME1);
			break;
		case "HOME2":
			Index_ch(INDEX_HOME2);
			break;
		case "ORIGINAL":
			Index_ch(INDEX_ORIGINAL);
			break;
		case "DATA":
			Index_ch(INDEX_DATA);
			break;
		case "SYSTEM_SETTING":
			Index_ch(INDEX_SYSTEM_SETTING);
			break;
		case "SYSTEM":
			Index_ch(INDEX_SYSTEM);
			break;
		case "MORE":
			Index_ch(INDEX_MORE);
			break;
	}
}

function Index_ch(INDEX_JSONDATA){
	var INDEX = document.getElementById("INDEX_HOME");

	var JSON_DATA = JSON.parse(INDEX_JSONDATA);

	INDEX.innerHTML = "";

	JSON_DATA.forEach(element => {
		INDEX.innerHTML += "<DIV class=\"ITEM\"><IMG width=\"50px\" src=\"./ETC/" + element.ID + "/icon.png\"><R class=\"NAME\">" + element.NAME + "</R>";
	});
}

window.onload = (e) => {
	Index_onch();
};