<?php
//関連ファイルを全て読み込むためのクラス
require_once 'vendor/autoload.php';
//databaseを呼び出す
require_once('database.php');

// テンプレートファイルがあるディレクトリ（本サンプルではカレントディレクトリ）
$loader = new Twig_Loader_Filesystem('./views/');

$twig = new Twig_Environment($loader);

//テンプレートファイルを$twigに入れる
$template = $twig->loadTemplate('index.html.twig');

//グローバル関数から取得したデータを取り込む
     if ($_POST['tasks_title'] && $_POST['tasks_content']) {
        // 実行するSQLを作成
        //var_dump($_POST);
        $sql = 'INSERT INTO tasklist.tasks (tasks_title, tasks_content) VALUES(:tasks_title, :tasks_content)';
        // ユーザ入力に依存するSQLを実行するので、セキュリティ対策をする
        $statement = $database->prepare($sql);
        // ユーザ入力データ($_POST['book_title'])をVALUES(?)の?の部分に代入する
        $statement->bindParam(':tasks_title', $_POST['tasks_title']);
        $statement->bindParam(':tasks_content', $_POST['tasks_content']);
        // SQL文を実行する
        $statement->execute();
        // ステートメントを破棄する
        $statement = null;
    }




// 実行するSQLを作成
$sql = 'SELECT * FROM tasklist.tasks ORDER BY created_at DESC';
    
// SQLを実行する(booleanで確認する)
$statement = $database->query($sql);
    
    
// 結果レコード（ステートメントオブジェクト）を配列に変換する
$records = $statement->fetchAll();

// ステートメントを破棄する
$statement = null;
// MySQLを使った処理が終わると、接続は不要なので切断する
$database = null;

$data = array(
    'tasks' => $records,
    'registerLocation' => 'input.php',
    'registerLogo' => 'glyphicon glyphicon-pencil',
    'register' => 'タスクを登録する'
);

echo $template->render($data);

?>