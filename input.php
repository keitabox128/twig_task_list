<?php
//関連ファイルを全て読み込むためのクラス
require_once 'vendor/autoload.php';

// テンプレートファイルがあるディレクトリ（本サンプルではカレントディレクトリ）
$loader = new Twig_Loader_Filesystem('./views/');

$twig = new Twig_Environment($loader);

//テンプレートファイルを$twigに入れる
$template = $twig->loadTemplate('input.html.twig');


//出力データ入力
$data = array('backLocation' => 'index.php',
            'backLogo' => 'glyphicon glyphicon-chevron-left',
            'back' => 'タスクリストに戻る'
);

//出力
echo $template->render($data);

?>