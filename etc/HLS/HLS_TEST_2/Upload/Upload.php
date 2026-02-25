<?php
session_start();

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

$Login = "N";
$Tum_Sucses = "N";

/**
 * ===========================================================================================[ 変数・ID取得 ]===========================================================================================
 */
$DB_USER = "user";
$DB_PASS = "sin1234zxntv";
$path = $_SERVER['DOCUMENT_ROOT'].'/Data_Server/DATA/RumiVideo/Video/'; // ファイルへのパス
$path_tum = $_SERVER['DOCUMENT_ROOT'].'/Data_Server/DATA/RumiVideo/thumbnail/'; // ファイルへのパス
$DATE = date("Y-m-d H:i.s.".microtime(true)); //時刻
$VIDEO_ID = md5(date("y-m-d-H-u-s-y-m-d-H-u-s")).md5(mt_rand()); //ID生成
echo $VIDEO_ID;
?>

<?php
/**
 * ===========================================================================================[ アカウントにログイン・ユーザーID取得 ]===========================================================================================
 */
// データベースに接続するために必要なデータソースを変数に格納
  // mysql:host=ホスト名;dbname=データベース名;charset=文字エンコード
$dsn = 'mysql:host=192.168.0.130;dbname=account;charset=utf8';
 
  // データベースのユーザー名
$user = $DB_USER;
 
  // データベースのパスワード
$password = $DB_PASS;
 
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
      $ACOUNT_UID = $row['uid'];
      $Login = "Y";
    }
}
?>

<?php
    // DB接続
    $pdo = new PDO(
        // ホスト名、データベース名
        'mysql:host=192.168.0.130;dbname=RumiVideo;',
        // ユーザー名
        $DB_USER,
        // パスワード
        $DB_PASS,
        // レコード列名をキーとして取得させる
        [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
?>

<?php
/**
 * ===========================================================================================[ アップロード・変換 ]===========================================================================================
 */
if ($Login == "Y"){
  $finfo = new finfo();//ファイルの型式確認
  if ($finfo->file( $_FILES['video_file']['tmp_name'], FILEINFO_MIME_TYPE) == "video/mp4"){
    if ($finfo->file( $_FILES['img_file']['tmp_name'], FILEINFO_MIME_TYPE) == "image/png"){

      /*アップロード開始！*/
      $uploadfile = is_uploaded_file($_FILES['video_file']['tmp_name']); //アップロードされたファイル
      if( !empty($_FILES['video_file']['tmp_name']) && $uploadfile) { // 動画ファイルがアップロードされているかと、POST通信でアップロードされたかを確認
        if( !empty($_FILES['video_file']['tmp_name']) && $uploadfile) { // サムネイル画像ファイルがアップロードされているかと、POST通信でアップロードされたかを確認
          mkdir($path.$VIDEO_ID, 0700);
          if( move_uploaded_file( $_FILES['video_file']['tmp_name'], $path.$VIDEO_ID."/".$VIDEO_ID.".mp4") ) { // 動画ファイルを指定したパスへ保存する
            if( move_uploaded_file( $_FILES['img_file']['tmp_name'], $path_tum.$VIDEO_ID.".png") ) { // サムネイル画像ファイルを指定したパスへ保存する
              $Tum_Sucses = "Y";
            }
            if($Tum_Sucses == "Y"){
              // SQL文をセット
              $stmt = $pdo->prepare("INSERT INTO `Video_Data` (`ID`, `DATE`, `UID`, `TITLE`, `DESC`, `Good`) VALUES (:ID, :DATE, :UID, :TITLE, :DESC, '0');");
              if ($_POST['Title'] == ""){
                echo ("タイトルがありません。");
                exit;
              }
              else{
                  // 値をセット
                  $stmt->bindValue(':ID', $VIDEO_ID); //idはnull
                  $stmt->bindValue(':DATE', $DATE);
                  $stmt->bindValue(':UID', $ACOUNT_UID);
                  $stmt->bindValue(':TITLE', $_POST['Title']);
                  $stmt->bindValue(':DESC', $_POST['Explanation']);
                  // SQL実行
                  $stmt->execute();
                  echo "SQL_1_OK";
              }
              
              //DB接続
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
              $stmt = $pdo->prepare('CREATE TABLE `RumiVideo_Comment`.`'.$VIDEO_ID.'` ( `DATE` VARCHAR(256) NOT NULL , `UID` VARCHAR(256) NOT NULL , `TEXT` TEXT NOT NULL , PRIMARY KEY (`DATE`)) ENGINE = InnoDB;');
              // SQL実行
              $stmt->execute();
              echo "SQL_2_OK";
              echo 'アップロード成功。：'.$VIDEO_ID;	
              include("./Convert.php");
              // DB接続を閉じる
              $pdo = null;
            }else{
              echo 'サムネイル画像のアップロードに失敗しました。';	
              exit;
            }
        } else {
            echo 'アップロードに失敗しました。';	
            exit;
        }
        }
      }
    }
  }
}else{
  echo "ログインしてください。";
  exit;
}
?>