let SIMBOL_EL = document.getElementById("SIMBOL");
let Y_MODE_EL = document.getElementById("Y_MODE");
let CORP_NAME_EL = document.getElementById("CORP_NAME");
let ARR_EL = document.getElementById("ARR");

let CPR_RESULT_EL = document.getElementById("CPR_RESULT");

function START(){
	let Y;
	switch(Y_MODE_EL.value){
		case "NW":
			Y = new Date().getFullYear();
			break;
		case "AUTO":
			Y = "&lt;R ID=\"CPR_YO\"&gt;&lt;/R&gt;&lt;SCRIPT&gt;document.getElementById(\"CPR_YO\").innerHTML = new Date().getFullYear();&lt;/SCRIPT&gt;";
			break;
		case "PHP_AUTO":
			Y = "&lt;?php echo Date(\"Y\"); ?&gt;";
			break;
		case "Y_NW":
			Y = new Date().getFullYear();
			break;
		case "Y_AUTO":
			Y = new Date().getFullYear();
			break;
		case "Y_PHP_AUTO":
			Y = "&lt;?php echo Date(\"Y\"); ?&gt;";
			break;
	}
	let ARR;
	if(ARR_EL.checked){
		ARR = "All rights reserved";
	}else{
		ARR = "";
	}
	CPR_RESULT_EL.innerHTML = SIMBOL_EL.value + " " + Y + " " + CORP_NAME_EL.value + " " + ARR;
}