<link rel="stylesheet" href="./style.css" media="screen and (min-width: 600px)">
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
    echo "<DIV class='home_video'>";
    foreach ($stmt as $row) {
      // ファイルが存在するかチェックする
      if (file_exists($_SERVER['DOCUMENT_ROOT']."/Data_Server/DATA/RumiVideo/thumbnail/".$row['ID'].".png")) {
        // ファイルが存在したら、ファイル名を付けて存在していると表示
        echo "<DIV>
          <a href='./view.php?ID=".$row['ID']."'>
          <IMG src='/Data/DATA/RumiVideo/thumbnail/".$row['ID'].".png' width='300' height='200'><BR>
          ".$row['TITLE']."
          </a>
        </DIV>";
      } else {
        // ファイルが存在していなかったら、見つからないと表示
        echo "
        <DIV>
          <a href='./view.php?ID=".$row['ID']."'>
          <IMG src='/Data/DATA/RumiVideo/thumbnail/!error.png' width='300' height='200'><BR>
          ".$row['TITLE']."
          </a>
          </DIV>
        ";
      }
    }
    echo "</DIV>";
    ?>