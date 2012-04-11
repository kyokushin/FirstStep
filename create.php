<?php
// エラーが発生した場合にエラー表示をする設定
ini_set( 'display_errors', 1 );
// Smartyを使うための準備
require('Smarty.class.php');
date_default_timezone_set('Asia/Tokyo');
$smarty = new Smarty();

$smarty->template_dir = '/templates/';
$smarty->compile_dir  = '/templates_c/';
$smarty->config_dir   = '/configs/';
$smarty->cache_dir    = '/cache/';

$smarty->display( 'create.tpl' );
?> 
