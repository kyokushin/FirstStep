<?php

// put full path to Smarty.class.php
require('/usr/local/lib/php/Smarty/Smarty.class.php');
$smarty = new Smarty();

$smarty->setTemplateDir('/Users/stenpel/DREGS/GIT/FirstStep/smarty/templates');
$smarty->setCompileDir('/Users/stenpel/DREGS/GIT/FirstStep/smarty/templates_c');
$smarty->setCacheDir('/Users/stenpel/DREGS/GIT/FirstStep/smarty/cache');
$smarty->setConfigDir('/Users/stenpel/DREGS/GIT/FirstStep/smarty/configs');

$smarty->assign('name', 'Ned');
$smarty->display('index.tpl');

?>