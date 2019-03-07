<?php
// 共通で使うものを別ファイルにしておきましょう。

// DB接続関数（PDO）
function db_conn()
{
    // $dbname = 'gs_f02_db09';
    $db = 'mysql:dbname=gs_f02_db09;charset=utf8;port=3306;host=localhost';
    $user = 'root';
    $pwd = 'root';
    try {
        return new PDO($db, $user, $pwd);
    } catch (PDOException $e) {
        exit('dbError:'.$e->getMessage());
    }
}

// SQL処理エラー
function errorMsg($stmt)
{
    $error = $stmt->errorInfo();
    exit('ErrorQuery:'.$error[2]);
}

// SESSIONチェック＆リジェネレイト
function chk_ssid()
{
    if(!isset($_SESSION['chk_ssid']) || $_SESSION['chk_ssid']!=session_id()){
        // ログイン失敗時の処理（ログイン画面に移動）
        header('Location: login.php');
    }else{
         // ログイン成功時の処理（一覧画面に移動）
        session_regenerate_id(true);
        $_SESSION['chk_ssid'] = session_id();
    }
}
function kanri_ssid()
{ 
    if(!isset($_SESSION["kanri_flg"]) || $_SESSION["kanri_flg"] ==0){
        echo "管理者権限がありません";
        exit();
    }
//     else{
//          // ログイン成功時の処理（一覧画面に移動）
//         session_regenerate_id(true);
//         $_SESSION['kanri_flg'] = session_id();
//     }
}

// menuを決める
function menu()
{
    $menu = '<li class="nav-item"><a class="nav-link" href="index.php">BOOKMARK登録</a></li><li class="nav-item"><a class="nav-link" href="select.php">BOOKMARK一覧</a></li><li class="nav-item"><a class="nav-link" href="kanri_detail.php">管理者ページへ</a></li>';
    $menu .= '<li class="nav-item"><a class="nav-link" href="logout.php">ログアウト</a></li>';
    return $menu;
}
function menu1()
{
    $menu1 = '<li class="nav-item"><a class="nav-link" href="kanri_index.php">BOOKMARK登録</a></li><li class="nav-item"><a class="nav-link" href="kanri_select.php">BOOKMARK管理</a></li>
    <li class="nav-item"><a class="nav-link" href="user_index.php">ユーザー登録</a></li><a class="nav-link" href="user_select.php">ユーザー管理</a></li>';
    $menu1 .= '<li class="nav-item"><a class="nav-link" href="logout.php">ログアウト</a></li>';
    return $menu1;
}
//$menu=menu();これを各ページに変数で代入
//＜？=menu？＞を各ページのHTMLにぶっ込む。

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}