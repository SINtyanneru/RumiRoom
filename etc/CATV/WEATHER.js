const SIDE_MAIN = document.getElementById("SIDE_MAIN");
const WEATHER_TEMP = document.getElementById("WEATHER_TEMP");
const WEATHER = true;

let WEATHER_SIDE_MODE = 0;
let WEEK_WEATHER = [];

WEATHER_GET();
WEATHER_TEMP_GET();

setInterval(() => {
	WEATHER_GET();
	WEATHER_TEMP_GET();
}, 100000);

setInterval(() => {
	WEATHER_SIDE_CH();
}, 5000);

function WEATHER_GET(){
	let ajax = new XMLHttpRequest();
	ajax.open("GET", "https://api.open-meteo.com/v1/forecast?latitude=33.84&longitude=132.77&hourly=weathercode");
	ajax.addEventListener("load", (e)=>{
		const DATA = JSON.parse(ajax.responseText);

		let TEST;
		let COUNT = 0;
		let WEEK_WEATHER_TEMP = [];
		DATA.hourly.time.forEach(element => {
			const ts = Date.parse(element);
			const dt = new Date(ts);
			if(dt.getDate() == TEST){
			}else{
				TEST = dt.getDate();
				WEEK_WEATHER_TEMP.push({"DAY":dt.getDate(), "WDAY":dt.getDay(), "FULLDATE":element, "WEATHER_CODE": DATA.hourly.weathercode[COUNT]});
				console.log(dt);
			}

			COUNT++;
		});

		WEEK_WEATHER = WEEK_WEATHER_TEMP;

		WEATHER_SIDE_CH();
	});

	if(WEATHER){
		ajax.send();
	}
}

function WEATHER_SIDE_CH(){
	switch(WEATHER_SIDE_MODE){
		case 0:
			SIDE_MAIN.innerHTML = "<DIV style=\"background: linear-gradient(180deg, rgba(255, 255, 255, 0.5) 0%, rgba(0,0,0,0) 100%);\">今日の天気"+
										"<DIV style=\"margin-left: 20px;\">" + "<IMG src=\"./WeatherIconPack_png/Icons/" + WEATHER_CODE(WEEK_WEATHER[0].WEATHER_CODE).IMG + ".png\">" + WEATHER_CODE(WEEK_WEATHER[0].WEATHER_CODE).TEXT + "</DIV>"+
									"</DIV>"+
									"<HR>"+
									"<DIV style=\"background: linear-gradient(180deg, rgba(255, 255, 255, 0.5) 0%, rgba(0,0,0,0) 100%);\">明日の天気予報"+
										"<DIV style=\"margin-left: 20px;\">" + "<IMG src=\"./WeatherIconPack_png/Icons/" + WEATHER_CODE(WEEK_WEATHER[1].WEATHER_CODE).IMG + ".png\">" + WEATHER_CODE(WEEK_WEATHER[1].WEATHER_CODE).TEXT + "</DIV>"+
									"</DIV>";
			break;
		case 1:
			SIDE_MAIN.innerHTML = "";
			WEEK_WEATHER.forEach(element => {
				SIDE_MAIN.innerHTML += "<DIV style=\"background: linear-gradient(180deg, rgba(255, 255, 255, 0.5) 0%, rgba(0,0,0,0) 100%);\">" + element.DAY + "日の天気"+
											"<DIV style=\"margin-left: 20px;\">" + "<IMG src=\"./WeatherIconPack_png/Icons/" + WEATHER_CODE(element.WEATHER_CODE).IMG + ".png\" style=\"width: 50px;\">" + WEATHER_CODE(element.WEATHER_CODE).TEXT + "</DIV>"+
										"</DIV>";
			});
			break;

		case 2:
			SIDE_MAIN.innerHTML = "お知らせチャンネル再現サイト V1.0<HR>"+
									"天気API：Open-Meteo";
			break;

		default:
			WEATHER_SIDE_MODE = 0;
			WEATHER_SIDE_CH();
			return;
	}

	WEATHER_SIDE_MODE++;
}

function WEATHER_TEMP_GET(){
	let ajax = new XMLHttpRequest();
	ajax.open("GET", "https://api.open-meteo.com/v1/forecast?latitude=33.8391&longitude=132.7655&hourly=temperature_2m&timezone=Asia%2FTokyo");
	ajax.addEventListener("load", (e)=>{
		const DATA = JSON.parse(ajax.responseText);
		WEATHER_TEMP.innerHTML = Math.floor(DATA.hourly.temperature_2m[0]);
	});

	if(WEATHER){
		ajax.send();
	}
}

//参考 https://github.com/neos21/frontend-sandboxes/blob/master/practice-open-meteo/index.html https://www.jodc.go.jp/data_format/weather-code_j.html
//WMOコードが難しい
function WEATHER_CODE(CODE){
	if(CODE === 0){
		return { TEXT: '快晴'  , IMG: '100' };  // 0 : Clear Sky
	}else if(CODE === 1){
		return { TEXT: '晴れ'  , IMG: '100' };  // 1 : Mainly Clear
	}else if(CODE === 2){
		return { TEXT: '一部曇', IMG: '201' };  // 2 : Partly Cloudy
	}else if(CODE === 3){
		return { TEXT: '曇り'  , IMG: '200' };  // 3 : Overcast
	}else if(CODE <= 49){
		return { TEXT: '霧'    , IMG: '🌫' };  // 45, 48 : Fog And Depositing Rime Fog
	}else if(CODE <= 59){
		return { TEXT: '霧雨'  , IMG: '🌧' };  // 51, 53, 55 : Drizzle Light, Moderate And Dense Intensity ・ 56, 57 : Freezing Drizzle Light And Dense Intensity
	}else if(CODE <= 69){
		return { TEXT: '雨'    , IMG: '300' };  // 61, 63, 65 : Rain Slight, Moderate And Heavy Intensity ・66, 67 : Freezing Rain Light And Heavy Intensity
	}else if(CODE <= 79){
		return { TEXT: '雪'    , IMG: '400' };  // 71, 73, 75 : Snow Fall Slight, Moderate And Heavy Intensity ・ 77 : Snow Grains
	}else if(CODE <= 84){
		return { TEXT: '俄か雨', IMG: '🌧' };  // 80, 81, 82 : Rain Showers Slight, Moderate And Violent
	}else if(CODE <= 94){
		return { TEXT: '雪・雹', IMG: '☃' };  // 85, 86 : Snow Showers Slight And Heavy
	}else if(CODE <= 99){
		return { TEXT: '雷雨'  , IMG: '⛈' };  // 95 : Thunderstorm Slight Or Moderate ・ 96, 99 : Thunderstorm With Slight And Heavy Hail
	}else{
		return { TEXT: '不明'  , IMG: '✨' };
	}
}