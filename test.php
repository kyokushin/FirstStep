<?php
// エラーが発生した場合にエラー表示をする設定
ini_set( 'display_errors', 1 );

// Smartyインストールディレクトリを定数定義
//define( 'SMARTY_DIR', 'C:\php\libs\' );
require('Smarty.class.php');

// Smartyを使うための準備
require_once( SMARTY_DIR . 'Smarty.class.php' );
$smarty = new Smarty();
?>