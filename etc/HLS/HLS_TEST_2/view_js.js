/*動画再生コントロール*/
var video_play = document.getElementById('HLS_video');

/*データ放送*/
var data_broadcast_window = document.getElementById('DATA_BroadCast');

/*デバッグ関連のコントロール*/
var state_window = document.getElementById('Debug_window');
var video_state = document.getElementById('Debug_Status');
var key_state = document.getElementById('Debug_key');

/*HLS.JSで動画をロード*/
if(Hls.isSupported()) {
	var hls = new Hls();
	hls.loadSource('/Data/DATA/RumiVideo/Video/<?php echo $_GET["ID"]; ?>/<?php echo $_GET["ID"]; ?>.m3u8');
	hls.attachMedia(video_play);
}
/*コメント送信*/
function comment_send(){
    const formdata = new FormData(document.getElementById('Comment_form'));
    formdata.set('Cooment_ID', '<?php echo $_GET["ID"]; ?>')
    $.ajax({
        url  : "./comment_send.php",
        type : "POST",
        data : formdata,
        processData : false,
        contentType : false
    }).done(function(data) {
        alert(data);
        console.log( data );
        window.location.reload();
    }).fail(function(data) {
        alert(data);
        console.log( data );
     });
}

/*データ放送ウィンドウ*/
data_broadcast_window.style.display = "none";
function DATA_OC(){
    if (data_broadcast_window.style.display == "none"){
        data_broadcast_window.style.display = "block";
        console.log("DataBroadCast block");
    }
    else{
        data_broadcast_window.style.display = "none";
        console.log("DataBroadCast none");
    }
}
/*キー入力*/
document.addEventListener('keypress', function (e) {
	//キー操作時
	if (e.code == 'ArrowUp') {
		//上(Vol +)
	} else if (e.code == 'ArrowDown') {
		//下(Vol -)
	} else if (e.code == 'ArrowLeft') {
        //左(Tr +)
	} else if (e.code == 'ArrowRight') {
		//右(Tr -)
	} else if (e.code == 'Space') {
		//再生・一時停止
        //jQueryで状態チェック(あんまりしたくないなあ)
        if($('video')[0].paused){
            video_play.play();
            console.log("[ VIDEO ]Play");
            //スクロールしないように
            e.preventDefault();
        }else{
            video_play.pause();
            console.log("[ VIDEO ]Pause");
            //スクロールしないように
            e.preventDefault();
        }
	}else if (e.code == 'NumpadMultiply') {
		//デバッグウィンドウ
        if (state_window.style.display == "none"){
            state_window.style.display = "block";
            console.log("Debug Mod true");
        }
        else{
            state_window.style.display = "none";
            console.log("Debug Mod false");
        }
	} 
    /*デバッグ機能*/
    //console.log(e.code);
    key_state.textContent = 'key input =' + e.code + " | " + e.charCode;
})
/*デバッグ機能*/
state_window.style.display = "none";
document.addEventListener('DOMContentLoaded', function() {
    //ロード開始
    video_play.addEventListener('loadedmetadata', function() {
        video_state.textContent = 'Video Status = Video metadata Loading now.....';
    })
    //ロード開始
    video_play.addEventListener('loadstart ', function() {
        video_state.textContent = 'Video Status = Video Loading now.....';
    })
    //読み込み完了
    video_play.addEventListener('loadeddata', function() {
        video_state.textContent = 'Video Status = Video Loding OK';
    })
    //再生可能
    video_play.addEventListener('canplay', function() {
        video_state.textContent = 'Video Status = Play OK';
    })
    //再生中
    video_play.addEventListener('playing', function() {
        video_state.textContent = 'Video Status = Play now';
    })
    //一時停止
    video_play.addEventListener('pause', function() {
        video_state.textContent = 'Video Status = Pause now';
    })
    //シーク
    video_play.addEventListener('seeking', function() {
        video_state.textContent = 'Video Status = Seeking';
    })
    //失敗
    video_play.addEventListener('stalled', function() {
        video_state.textContent = 'Video Status = Stalled';
    })
    //ボリューム変更
    video_play.addEventListener('volumechange ', function() {
        video_state.textContent = 'Video Status = Volume change now';
    })
    //エラー
    video_play.addEventListener('error ', function() {
        video_state.textContent = 'Video Status = Error';
    })
    //エラー
    video_play.addEventListener('durationchange ', function() {
        video_state.textContent = 'Video Status = Duration change';
    })
    //終了
    video_play.addEventListener('ended ', function() {
        video_state.textContent = 'Video Status = Video end';
    })
})