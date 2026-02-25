/**
 * 変数とかー
 */
search_window = document.getElementById("Search_Window"); //検索窓
status_window = document.getElementById("STATUS"); //検索窓

/**
 * ホームに戻る
 */
function home(){
    document.getElementById("CONTENTS_IFRAME").src = "./video_index.php" //IFRAMEのSRCを変更

}


/**
 * 検索ウィンドウ関連↓↓↓↓↓↓↓↓
 */
//非表示に
search_window.style.display = "none";
//検索窓表示/非表示
function search_window_oc(){
    if (search_window.style.display == "none"){
        search_window.style.display = "block";
        console.log("Search_Window is [block]");
    }
    else{
        search_window.style.display = "none";
        console.log("Search_Window is [none]");
    }
}
//検索
function serach_start(){
    console.log("Search now..... [" + document.getElementById("Search_input").value + "]");
    document.getElementById("CONTENTS_IFRAME").src = "./search.html?word=" + document.getElementById("Search_input").value //IFRAMEのSRCを変更
    search_window.style.display = "none";//非表示に
}

/**
 * ステータスウィンドウ関連↓↓↓↓↓↓↓↓
 */
//非表示に
status_window.style.display = "none";
function status_window_oc(){
    if (status_window.style.display == "none"){
        status_window.style.display = "block";
        console.log("Search_Window is [block]");
    }
    else{
        status_window.style.display = "none";
        console.log("Search_Window is [none]");
    }
}