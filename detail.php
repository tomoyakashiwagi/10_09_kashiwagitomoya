<?php
// セッションのスタート
session_start();

// 関数ファイルの読み込み
include('functions.php');

// ログイン状態のチェック
chk_ssid();

$menu = menu();


// getで送信されたidを取得
$id = $_GET['id'];

//DB接続します
$pdo = db_conn();

//データ登録SQL作成，指定したidのみ表示する
$sql = 'SELECT * FROM gs_bm_table WHERE id =:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//データ表示
if ($status==false) {
    // エラーのとき
    errorMsg($stmt);
} else {
    // エラーでないとき
    $rs = $stmt->fetch();
    // fetch()で1レコードを取得して$rsに入れる
    // $rsは配列で返ってくる．$rs["id"], $rs["task"]などで値をとれる
    // var_dump()で見てみよう
}


// $view='';
// if ($status==false) {
//     //execute（SQL実行時にエラーがある場合）
//     $error = $stmt->errorInfo();
//     exit('sqlError:'.$error[2]); //失敗はエラー表示する
// } else {
//     //Selectデータの数だけ自動でループしてくれる
//     //http://php.net/manual/ja/pdostatement.fetch.php
//     //while=全レコードを順番に取得 $resultに配列で格納。
//     while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
//         $view .= '<li class="list-group-item">';
//         $view .= '<p>'.$result['id'].'</p>';
//         $view .= '<p>'.$result['name'].'</p>';
//         $view .= '<p>'.$result['indate'].'</p>';
//         $view .= '<p>'.$result['comment'].'</p>';
//         $view .= '<p>'.$result['url'].'</p>';
//         // imgタグで出力しよう！
//         $view .= '<img src="'.$result['image'].'" alt="" height="150px">'.'</p>';
//         $view .= '<?li>';
        
//     }
// }
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>データ更新ページ</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <style>
        div{
            padding: 10px;
            font-size:16px;
            }
    </style>
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">BOOKMARK</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <?=$menu?>
                </ul>
            </div>
        </nav>
    </header>
    <form method="post" action="update.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name</label>
            <!-- 受け取った値をvaluesに埋め込もう -->
            <input type="text" class="form-control" id="name" name="name" value="<?=$rs['name']?>">
        </div>
        <div class="form-group">
            <label for="comment">Comment</label>
            <!-- 受け取った値挿入しよう -->
            <textarea class="form-control" id="comment" name="comment" rows="3" ><?=$rs['comment']?></textarea>
        </div>
        <div class="form-group">
            <label for="url">URL</label>
            <!-- 受け取った値をvaluesに埋め込もう -->
            <input type="text" class="form-control" id="url" name="url" value="<?=$rs['url']?>">
        </div>
        <img src="<?=$rs['image']?>" alt="" height="150px">
        <div class="form-group">
            <label for="upfile">Image</label>
        <!--inputを追加 -->
            <input type="file" class="form-control-file" accept="image/*" capture="camera" id="upfile" name="upfile">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <!-- idは変えたくない = ユーザーから見えないようにする-->
        <input type="hidden" name="id" value="<?=$rs['id']?>">
    </form>

</body>

</html>