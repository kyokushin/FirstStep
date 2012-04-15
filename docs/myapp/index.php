<?php

// put full path to Smarty.class.php
require('/usr/local/lib/php/Smarty/Smarty.class.php');
$smarty = new Smarty();

$smarty->setTemplateDir('/Users/stenpel/Sites/FirstStep/smarty/templates');
$smarty->setCompileDir('/Users/stenpel/Sites/FirstStep/smarty/templates_c');
$smarty->setCacheDir('/Users/stenpel/Sites/FirstStep/smarty/cache');
$smarty->setConfigDir('/Users/stenpel/Sites/FirstStep/smarty/configs');

$smarty->assign('name', 'Ned');

$smarty->debugging = true;
$smarty->testInstall(); 

$smarty->display('index.tpl');

?>