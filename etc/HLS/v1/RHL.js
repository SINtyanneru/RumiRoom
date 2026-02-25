class RHL{
	VIDEO_EL = null;
	SEEKBAR_EL = null;
	RHL_DATA = null;
	SOURCE_BUFFER = null;
	LATEST_DURATION = null;
	MIME = "video/webm; codecs=\"vp9\"";
	TEMP_BUFFER = null;

	constructor(VIDEO_EL, SEEKBAR_EL){
		this.VIDEO_EL = VIDEO_EL;
		this.SEEKBAR_EL = SEEKBAR_EL;

		let MEDIA_SOURCE = new MediaSource();
		this.VIDEO_EL.src = URL.createObjectURL(MEDIA_SOURCE);

		MEDIA_SOURCE.addEventListener("sourceopen", async (E)=>{
			console.log("MediaSource準備完了");

			//MEDIA_SOURCE.duration = 149;

			this.SOURCE_BUFFER = MEDIA_SOURCE.addSourceBuffer(this.MIME);
		});

		this.EVENT();
	}

	//RHLデータをセットする
	SET_RHL(RHL_DATA){
		this.RHL_DATA = RHL_DATA;
	}

	async INIT(){
		this.I = 0;
		this.LATEST_DURATION = 0;

		for(this.I = this.I; this.RHL_DATA.length > this.I; this.I++){
			await this.WEBM_FETCH(this.RHL_DATA[this.I].URI);
		}

		this.I++;
	}

	PLAY(){
		this.VIDEO_EL.play();
	}

	EVENT(){
		/*
		this.VIDEO_EL.addEventListener("timeupdate", async (E)=>{
			//現在の再生位置のほうが、現在読み込んだ秒数より大きければ続きを読み込む
			if(VIDEO_EL.currentTime > (this.LATEST_DURATION - 5)){
				//続きはあるか？
				if(this.RHL_DATA[this.I] != undefined){
					await this.WEBM_FETCH(this.RHL_DATA[this.I].URI);
					this.I++;
				}
			}

			this.SEEKBAR_EL.value = this.VIDEO_EL.currentTime;
		});*/

		this.SEEKBAR_EL.addEventListener("change", (E)=>{
			this.VIDEO_EL.currentTime = this.SEEKBAR_EL.value;
		});

		this.SEEKBAR_EL.addEventListener("mouseup", async (E)=>{
			for (let I_ = this.I; I_ < this.RHL_DATA.length; I_++) {
				const VIDEO_DATA = this.RHL_DATA[I_];

				await this.WEBM_FETCH(VIDEO_DATA.URI);

				this.I++;

				if(this.VIDEO_EL.currentTime < this.LATEST_DURATION){
					break;
				}
			}
		})
	}

	async WEBM_FETCH(TS_URL){
		return new Promise(async (resolve, reject) => {
			let AJAX = await fetch(TS_URL, {
				method:"GET"
			});

			//取得おｋ
			if(AJAX.ok){
				this.TEMP_BUFFER = await AJAX.arrayBuffer();
				const CHUNK_SIZE = 1024*1024;
				const TOTAL_SIZE = this.TEMP_BUFFER.byteLength;
				let SLICE_OFFSET= 0;

				//なぜかJSはこうしないと動きません、ゴミ
				const SLICE_APPEND = async () => {
					if(SLICE_OFFSET < TOTAL_SIZE){
						const END = Math.min(SLICE_OFFSET + CHUNK_SIZE, TOTAL_SIZE);
						const CHUNK = this.TEMP_BUFFER.slice(SLICE_OFFSET, END);

						//動画のデータを追加
						this.SOURCE_BUFFER.appendBuffer(CHUNK);

						//オフセットを書き換え
						SLICE_OFFSET = END;

						this.LATEST_DURATION = this.LATEST_DURATION + await this.GET_WEBM_DURATION(this.TEMP_BUFFER);
					}
				}

				//読み込み完了イベント
				const UPDATE_END = async () => {
					//追記する位置を調整
					this.SOURCE_BUFFER.timestampOffset += await this.GET_WEBM_DURATION(this.TEMP_BUFFER);

					SLICE_APPEND();

					//イベントを殺す(大事)
					//this.SOURCE_BUFFER.removeEventListener("updateend", UPDATE_END);

					resolve();
				}

				SLICE_APPEND();

				//イベントをセット
				this.SOURCE_BUFFER.addEventListener("updateend", UPDATE_END);
			}else{//取得失敗
				console.error("動画が読み込めません、" + AJAX.status + "、URL：" + TS_URL);
				reject();
			}
		});
	}
	
	async GET_WEBM_DURATION(BUFFER){
		return new Promise((resolve) => {
			let MEDIA_SOURCE = new MediaSource();
			let TEMP_VIDEO_EL = document.createElement("VIDEO");

			TEMP_VIDEO_EL.src = URL.createObjectURL(MEDIA_SOURCE);

			MEDIA_SOURCE.addEventListener("sourceopen", ()=>{
				let SOURCE_BUFFER = MEDIA_SOURCE.addSourceBuffer(this.MIME);
			
				SOURCE_BUFFER.addEventListener("updateend", ()=>{
					resolve(MEDIA_SOURCE.duration);
				});

				SOURCE_BUFFER.appendBuffer(BUFFER);
			});
		});
	}
}