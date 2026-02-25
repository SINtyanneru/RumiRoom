let BLOG_TEXT_TEXTAREA_EL =document.getElementById("BLOG_TEXT_TEXTAREA");
let BLOG_TITLE_INPUT_EL = document.getElementById("BLOG_TITLE_INPUT");
let PUBLIC_CHECKBOX_EL = document.getElementById("PUBLIC_CHECKBOX");
let BLOG_VIEW_EL =document.getElementById("BLOG_VIEW");
let MSG_BOX_OWNER_EL = document.getElementById("MSG_BOX_OWNER");
let LOCK_CHECKBOX_EL = document.getElementById("LOCK_CHECKBOX");
let LOCK_PASS_EL = document.getElementById("LOCK_PASS");
let FILE_EL = document.getElementById("FILE");
let FILE_NAME_EL = document.getElementById("FILE_NAME");

let TEMP_BLOG_TEXT = "";
setInterval(() => {
	if(TEMP_BLOG_TEXT !== BLOG_TEXT_TEXTAREA_EL.value){
		BLOG_VIEW_EL.innerHTML = RMD_CONV(BLOG_TEXT_TEXTAREA_EL.value);

		TEMP_BLOG_TEXT = BLOG_TEXT_TEXTAREA_EL.value;
	}
}, 1);

async function SAVE(){
	let AJAX = await fetch("./SAVE.php", {
		method:"POST",
		body: JSON.stringify({
			ID: new URLSearchParams(location.search).get("ID"),
			TITLE: BLOG_TITLE_INPUT_EL.value,
			TEXT: BLOG_TEXT_TEXTAREA_EL.value,
			PUBLIC: PUBLIC_CHECKBOX_EL.checked,
			LOCK:LOCK_CHECKBOX_EL.checked,
			LOCK_PASS:LOCK_PASS_EL.value
		})
	});

	if(AJAX.ok){
		let RESULT = await AJAX.json();
		if(RESULT.STATUS){
			DIALOG("保存した" + new Date().toDateString());
		}else{
			alert("登録できん買ったわ、笑");
		}
	}else{
		alert("AJAXがエラー");
	}
}

window.addEventListener("keydown", (E)=>{
	if(E.ctrlKey && E.key === "s"){
		E.preventDefault();

		SAVE();
	}
});

function DIALOG(TEXT){
	//成功
	let MSG_BOX = document.createElement("DIV");
	MSG_BOX.className = "MSG_BOX";
	MSG_BOX.innerHTML = TEXT;

	MSG_BOX_OWNER_EL.appendChild(MSG_BOX);
	setTimeout(() => {
		MSG_BOX.remove();
	}, 5000);
}

async function FILE_UPLOAD(){
	//ファイルを読み込む
	const FILE = FILE_EL.files[0];
	let PostDATA = new FormData();
	PostDATA.append("ID", new URLSearchParams(location.search).get("ID"));
	PostDATA.append("DATA", FILE);

	let AJAX = await fetch("./UPLOAD.php", {
		method:"POST",
		body: PostDATA
	});

	const RESULT = await AJAX.json();
	if(RESULT.STATUS){
		FILE_NAME_EL.innerText = RESULT.FILE_NAME;
	} else {
		DIALOG("ファイルをアップロードできませんでした");
	}
}