<video id="HLS_video" class="HLS_VIDEO" controls></video>
<?php
session_start();
//変数類
$Login = "N";
?>

<?php
if (isset($_SESSION['UID'])){
  /**
  * ==================================ログイン
  */
  // データベースに接続するために必要なデータソースを変数に格納
    // mysql:host=ホスト名;dbname=データベース名;charset=文字エンコード
    $dsn = 'mysql:host=192.168.0.130;dbname=account;charset=utf8';
  
    // データベースのユーザー名
  $user = 'user';
  
    // データベースのパスワード
  $password = 'sin1234zxntv';
  
  // tryにPDOの処理を記述
  try {
      
    // PDOインスタンスを生成
    $dbh = new PDO($dsn, $user, $password);
    
  // エラー（例外）が発生した時の処理を記述
  } catch (PDOException $e) {
    
    // エラーメッセージを表示させる
    echo 'データベースにアクセスできません！' . $e->getMessage();
    
    // 強制終了
    exit;
  }

  // SELECT文を変数に格納
  $sql = "SELECT * FROM `account` ";
  
  // SQLステートメントを実行し、結果を変数に格納
  $stmt_account = $dbh->query($sql);
  foreach ($stmt_account as $row_account) {
    if (hash("sha3-512", $row_account['uid']) == $_SESSION['UID']){
      session_regenerate_id();
      $Login = "Y";
    }
  }
}
?>

<?php
/**
 * ==================================SQLからブログのデータを取得
 */
// データベースに接続するために必要なデータソースを変数に格納
// mysql:host=ホスト名;dbname=データベース名;charset=文字エンコード
$dsn = 'mysql:host=192.168.0.130;dbname=RumiVideo;charset=utf8';
$user = 'user';// データベースのユーザー名
$password = 'sin1234zxntv';// データベースのパスワード
// tryにPDOの処理を記述
try {
  // PDOインスタンスを生成
  $dbh = new PDO($dsn, $user, $password);
// エラー（例外）が発生した時の処理を記述
} catch (PDOException $e) {
  // 強制終了
  exit;
}

// SELECT文を変数に格納
$sql = "SELECT * FROM `Video_Data` ORDER BY `Video_Data`.`DATE` DESC ";
 
// SQLステートメントを実行し、結果を変数に格納
$stmt = $dbh->query($sql);
 
// foreach文で配列の中身を一行ずつ出力
foreach ($stmt as $row) {
	if($row['ID'] === $_GET['ID']){
		echo "<TITLE>るみビデオ | ".$row['TITLE']."</TITLE>";
    $VIDEO_ID = $row['ID'];
		$VIDEO_TITLE = $row['TITLE'];
		$VIDEO_DESC = $row['DESC'];
		$VIDEO_Up_uid = $row['UID'];
    $VIDEO_Date = $row['DATE'];
	}
}
?>

<?php
/**
 * ==================================SQLからアカウントのデータを取得
 */
// データベースに接続するために必要なデータソースを変数に格納
  // mysql:host=ホスト名;dbname=データベース名;charset=文字エンコード
  $dsn = 'mysql:host=192.168.0.130;dbname=account;charset=utf8';
 
  // データベースのユーザー名
$user = 'user';
 
  // データベースのパスワード
$password = 'sin1234zxntv';
 
// tryにPDOの処理を記述
try {
 
  // PDOインスタンスを生成
  $dbh = new PDO($dsn, $user, $password);
 
// エラー（例外）が発生した時の処理を記述
} catch (PDOException $e) {
 
  // エラーメッセージを表示させる
  echo 'データベースにアクセスできません！' . $e->getMessage();
 
  // 強制終了
  exit;
 
}

// SELECT文を変数に格納
$sql = "SELECT * FROM `account` ";
 
// SQLステートメントを実行し、結果を変数に格納
$stmt_account = $dbh->query($sql);
foreach ($stmt_account as $row_account) {
	if ($row_account['uid'] == $VIDEO_Up_uid){
		$Upload_user = $row_account['user_name'];
	}
}
?>

<div style="padding: 10px; margin-bottom: 10px; border: 1px solid #333333;" class="ETC_VIDEO">
<div style="padding: 10px; margin-bottom: 10px; border: 1px solid #333333;" class="Desc">
<?php echo "<FONT style='font-size: 30px;'>".$VIDEO_TITLE."</FONT>"; ?><BR>
<HR>
<BR>
<?php echo "<FONT style='font-size: 20px;'>".$VIDEO_Date."<BR>".$VIDEO_DESC."</FONT>"; ?>
<BR>
<HR>
<?php echo "<IMG src='/Data/DATA/icon/".$VIDEO_Up_uid.".png' width='50' height='50'><FONT style='font-size: 20px;'>".$Upload_user."</FONT><BR>"; ?>
<BUTTON onclick="DATA_OC()">データ放送</BUTTON>
</div>
<?php
if ($Login == "Y"){
  echo '
  <!--コメント関連-->
  <form id="Comment_form" class="Comment_form">
    <textarea name="Comment_text"></textarea>
    <BR>
    <input type="button" value="送信" onclick="comment_send();" style="width: 100%;">
  </form>
  ';

}else{
  echo '
  <!--コメント関連-->
  <BR>
  <DIV class="Comment_form" style="border: solid;">
    <BR>
    <a href="/rumiserveraccount/Login?rd=sinch/etc/HLS_TEST_2" target="_blank">コメントを利用したいならログインしてください！</a><BR>
    <BR>
  </DIV>
  <BR>
  ';
}
?>
<?php
/*================================ニックネーム取得================================*/
// データベースに接続するために必要なデータソースを変数に格納
  // mysql:host=ホスト名;dbname=データベース名;charset=文字エンコード
$dsn = 'mysql:host=192.168.0.130;dbname=account;charset=utf8';
 
  // データベースのユーザー名
$user = 'user';
 
  // データベースのパスワード
$password = 'sin1234zxntv';
 
// tryにPDOの処理を記述
try {
 
  // PDOインスタンスを生成
  $dbh_accounr = new PDO($dsn, $user, $password);
 
// エラー（例外）が発生した時の処理を記述
} catch (PDOException $e) {
 
  // エラーメッセージを表示させる
  echo 'アカウントデータベースにアクセスできません！' . $e->getMessage();
 
  // 強制終了
  exit;
 
}

// SELECT文を変数に格納
$sql_account = "SELECT * FROM `account`";
 
// SQLステートメントを実行し、結果を変数に格納
$stmt_account = $dbh_accounr->query($sql_account);
/*================================コメント取得================================*/
// データベースに接続するために必要なデータソースを変数に格納
  // mysql:host=ホスト名;dbname=データベース名;charset=文字エンコード
$dsn = 'mysql:host=192.168.0.130;dbname=RumiVideo_Comment;charset=utf8';
 
  // データベースのユーザー名
$user = 'user';
 
  // データベースのパスワード
$password = 'sin1234zxntv';
 
// tryにPDOの処理を記述
try {
 
  // PDOインスタンスを生成
  $dbh = new PDO($dsn, $user, $password);
 
// エラー（例外）が発生した時の処理を記述
} catch (PDOException $e) {
 
  // エラーメッセージを表示させる
  echo 'リプデータベースにアクセスできません！' . $e->getMessage();
 
  // 強制終了
  exit;
 
}

// SELECT文を変数に格納
$sql = "SELECT * FROM `".$_GET['ID']."` ORDER BY `".$_GET['ID']."`.`DATE` DESC ";
 
// SQLステートメントを実行し、結果を変数に格納
$stmt_comment = $dbh->query($sql);

// foreach文で配列の中身を一行ずつ出力
foreach ($stmt_comment as $row) {
    $Comment_UID = $row['UID'];
    //echo $row['UID'];
    foreach ($stmt_account as $row_account) {
        $Account_UID = $row_account['uid'];
        if ($Account_UID == $Comment_UID){
            echo ("<div class='Comment'>");
            echo ("<IMG src='/Data/DATA/icon/".$Comment_UID.".png' width='50' height='50'><FONT style='font-size: 20px;'>".$row_account['user_name']." | ".$row['DATE']);
            echo ("<HR>");
            echo (nl2br($row['TEXT'])."<BR>");
            echo ("</div>\n");
          }
        //echo '|Read_Account_End|';
        // SQLステートメントを実行し、結果を変数に格納
        $stmt_account = $dbh_accounr->query($sql_account);
    }
    //echo '|Read_Comment_End|';
}
?>

</div>

<DIV id="Debug_window" class="Debug_window">
  <p>===========[ RumiVideo DebugTool ]===========</p>
  <p id="Debug_Status"></p>
  <p id="Debug_key"></p>
</DIV>

<DIV class="DATA_BroadCast"id="DATA_BroadCast">
  <BUTTON onclick="DATA_OC()">X</BUTTON>
  データ放送
  <HR>
  <IFRAME src="./Data_BroadCast.php"></IFRAME>
</DIV>

<!--CSS/JSをロード-->
<link rel="stylesheet" href="./view_CSS.CSS">

<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="./view_js.js?ID=<?php echo $_GET["ID"]; ?>"></script>