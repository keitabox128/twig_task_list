<?php
//文字化け解消
header("Content-type: text/html; charset=utf-8");

//関連ファイルを全て読み込むためのクラス
require_once 'vendor/autoload.php';
//databaseを呼び出す
require_once('database.php');

// テンプレートファイルがあるディレクトリ（本サンプルではカレントディレクトリ）
$loader = new Twig_Loader_Filesystem('./views/');

$twig = new Twig_Environment($loader);

//テンプレートファイルを$twigに入れる
$template = $twig->loadTemplate('delete.html.twig');

//idがあるか判定
if(empty($_POST)){
    echo "<a href='index.php'>タスクリストに戻る</a>";
    exit();
}else{


//数値判定
        $id_string = $_POST['id'];

        $id = (int)$id_string;
        var_dump($id);
  
    //SQL文：プリペアステートメント
    $sql = 'DELETE FROM tasklist.tasks WHERE id ='.$id;
    //$sql = 'DELETE FROM tasklist.tasks WHERE id = :id';
    $stmt = $database->prepare($sql);
       
        //プリペアステートメント実行
        //print $sql;
        //$stmt->bindParam(':id',$id);
        
        $stmt->execute();

        //変更された行の数が1かどうか
        if($stmt->rowCount() == 1){
            echo "削除しました。";
        }else{
            echo "削除失敗です";
        }

        
        //ステートメント切断
        $stmt->null;
        
    
}

$data = array('backLocation' => 'index.php',
            'backLogo' => 'glyphicon glyphicon-chevron-left',
            'back' => 'タスクリストに戻る'
);

//出力する
echo $template->render($data);




?>
