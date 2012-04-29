<?php
require('/usr/local/lib/php/Smarty/Smarty.class.php');

class Template {
  private static $smarty;

  public static function GetTemplate(){
    if(!$smarty) {
      $smarty = new Smarty();

      $smarty->setTemplateDir('/Users/stenpel/Sites/FirstStep/smarty/templates');
      $smarty->setCompileDir('/Users/stenpel/Sites/FirstStep/smarty/templates_c');
      $smarty->setCacheDir('/Users/stenpel/Sites/FirstStep/smarty/cache');
      $smarty->setConfigDir('/Users/stenpel/Sites/FirstStep/smarty/configs');
      
    }
    return $smarty;
  }
}
?>