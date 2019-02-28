<?php
// セッションのスタート
session_start();

// 関数ファイルの読み込み
include('functions.php');

// ログイン状態のチェック
chk_ssid();
// kanri_ssid();

$menu1 = menu1();


//1. DB接続
$pdo = db_conn();

//2. データ表示SQL作成
$sql = 'SELECT * FROM gs_bm_table ORDER BY indate ASC';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//3. データ表示
$view='';
if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit('sqlError:'.$error[2]); //失敗はエラー表示する
} else {
    //Selectデータの数だけ自動でループしてくれる
    //http://php.net/manual/ja/pdostatement.fetch.php
    //while=全レコードを順番に取得 $resultに配列で格納。
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<li class="list-group-item">';
        $view .= '<p>'.$result['id'].'</p>';
        $view .= '<p>'.$result['name'].'</p>';
        $view .= '<p>'.$result['indate'].'</p>';
        $view .= '<p>'.$result['comment'].'</p>';
        $view .= '<p>'.$result['url'].'</p>';
        $view .= '<a href="kanri_detail.php?id='.$result[id].'" class="badge badge-primary">Edit</a>'; 
        $view .= '<a href="kanri_delete.php?id='.$result[id].'" class="badge badge-danger">Delete</a>';
        $view .= '<?li>';
        
    }
}
?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BOOKMARKリスト表示</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">BOOKMARK一覧</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                   <?=$menu1?>
                </ul>
            </div>
        </nav>
    </header>

    <div>
        <ul class="list-group">
            <!-- ここにDBから取得したデータを表示しよう -->
            <?=$view?>
        </ul>
    </div>

</body>

</html>