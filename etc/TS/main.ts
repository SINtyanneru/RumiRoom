let count = 0;

function refresh_display() {
	let el = document.getElementById("DISPLAY");
	if (el == null) return;
	const val:string = count.toString();
	el.innerText = val;
}

function add() {
	count += 1;
}

function sub() {
	count -= 1;
}

function mul() {
	count = count * 2;
}

function div() {
	count = count / 2;
}