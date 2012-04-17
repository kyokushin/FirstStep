<?php
require('Smarty.class.php');

class Smarty {
  private static $smarty;

  public static function GetSmarty(){
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