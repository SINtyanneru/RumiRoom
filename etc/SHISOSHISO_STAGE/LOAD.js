function LOAD(){
	const BLOCK_LIST = [
		"block_glass_square_2_1",
		"block_glass_square_2_2",
		"block_glass_slope_diamond",
		"block_glass_slope_2_2",
		"block_glass_slope_2_1",
		"block_glass_slope_1_2",
		"block_glass_slope_1_1",
		"block_flower04",
		"block_flower03",
		"block_flower02",
		"block_flower01",
	];
	
	BLOCK_LIST.forEach(BLOCK_DATA => {
		//マップの素材を入れる
		let DART = new Image();
		DART.src = "./ASSETS/" + BLOCK_DATA + ".png";

		BLOCK_ENVENT.push({
			NAME:BLOCK_DATA,
			IMG:DART
		});
	});
}