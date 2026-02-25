<?php
session_start();

$VIDEO_ID = $_POST['Cooment_ID'];
$Comment_TEXT = $_POST['Comment_text'];


$Login_success = "Y";
$Comment_OK = "Y";

if (isset($_SESSION['UID'])){
}
else{
  header('Location: /rumiserveraccount/Login/index.html?rd=rumialand');
  exit;
}

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
$stmt = $dbh->query($sql);
 
// foreach文で配列の中身を一行ずつ出力
foreach ($stmt as $row) {
    if (hash("sha3-512", $row['uid']) == $_SESSION['UID']){
      session_regenerate_id();
      $Login_success = "Y";
      $USER_ID = $row['uid'];
    }
}
?>

<?php
// データベースに接続するために必要なデータソースを変数に格納
// mysql:host=ホスト名;dbname=データベース名;charset=文字エンコード
$dsn = 'mysql:host=192.168.0.130;dbname=RumiVideo_Comment;charset=utf8';
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
$sql = "SELECT * FROM `".$VIDEO_ID."`";
 
// SQLステートメントを実行し、結果を変数に格納
$stmt = $dbh->query($sql);
 
// foreach文で配列の中身を一行ずつ出力
foreach ($stmt as $row) {
    if ($row['UID'] == $USER_ID){
        if ($row['TEXT'] == $Comment_TEXT){
            $Comment_OK = "N";
            $Error_MSG = "すでに投稿されています";
        }
    }
}

if(isset($_COOKIE["RumiVideo_Comment_Session"])){
    $Comment_OK = "N";
    $Error_MSG = "連続で投稿することは出来ません。";
}

if($Comment_OK == "Y"){
    try {
        $date = time();
        $date = date("Y-m-d H:i.s.".microtime(true));
    
    
        //送信コード
        // DB接続
        $pdo = new PDO(
            // ホスト名、データベース名
            'mysql:host=192.168.0.130;dbname=RumiVideo_Comment;',
            // ユーザー名
            'user',
            // パスワード
            'sin1234zxntv',
            // レコード列名をキーとして取得させる
            [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
        );
     
        // SQL文をセット
        $stmt = $pdo->prepare('INSERT INTO `'.$VIDEO_ID.'` (`DATE`, `UID`, `TEXT`) VALUES(:DATE, :UID, :TEXT)');
    
    
        //名無しとかの設定
        if($Comment_TEXT == "") {
            //名無しの場合
            echo "内容が無いようです(は？)";
        }
        else{
            // 値をセット
            $stmt->bindValue(':DATE', $date);
            $stmt->bindValue(':UID', $USER_ID);
            $stmt->bindValue(':TEXT', $Comment_TEXT);
            setcookie("RumiVideo_Comment_Session", "YES", time()+5);

            // SQL実行
            $stmt->execute();
            echo 'コメントしました！！';
        }

     
    } catch (PDOException $e) {
        // エラー発生
        echo $e->getMessage();
     
    } finally {
        // DB接続を閉じる
        $pdo = null;
    }
}else{
    echo $Error_MSG;
}
?>