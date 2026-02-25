const CLOCK_DATE = document.getElementById("CLOCK_DATE");
const CLOCK_DAY = document.getElementById("CLOCK_DAY");
const CLOCK_CLOCK = document.getElementById("CLOCK_CLOCK");

const DAY = [{"TEXT":"日"},{"TEXT":"月"},{"TEXT":"火"},{"TEXT":"水"},{"TEXT":"木"},{"TEXT":"金"},{"TEXT":"土"}];

setInterval(() => {
	const DATE = new Date();
	CLOCK_DATE.innerHTML = ("0" + DATE.getDate()).slice(-2);
	CLOCK_DAY.innerHTML = "(" + DAY[DATE.getDay()].TEXT + ")";

	CLOCK_CLOCK.innerHTML = ("0" + DATE.getHours()).slice(-2) + ":" + ("0" + DATE.getMinutes()).slice(-2) + "." + ("0" + DATE.getSeconds()).slice(-2);
}, 900);