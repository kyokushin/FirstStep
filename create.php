<?php
// エラーが発生した場合にエラー表示をする設定
ini_set( 'display_errors', 1 );
// Smartyを使うための準備
require('/usr/local/lib/php/Smarty/Smarty.class.php');
date_default_timezone_set('Asia/Tokyo');
$smarty = new Smarty();

$smarty->template_dir = '/Users/stenpel/Sites/FirstStep/templates';
$smarty->compile_dir  = '/Users/stenpel/Sites/FirstStep/templates_c';
$smarty->config_dir   = '/Users/stenpel/Sites/FirstStep/configs';
$smarty->cache_dir    = '/Users/stenpel/Sites/FirstStep/cache';

$smarty->display( 'create.tpl' );
?> 
