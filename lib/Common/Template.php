<?php
require('/usr/local/lib/php/Smarty/Smarty.class.php');

class Template {
  private static $smarty = null;

  public static function GetTemplate(){
    if(is_null(self::$smarty)) {
      self::$smarty = new Smarty();

      self::$smarty->setTemplateDir('/Users/stenpel/Sites/FirstStep/smarty/templates');
      self::$smarty->setCompileDir('/Users/stenpel/Sites/FirstStep/smarty/templates_c');
      self::$smarty->setCacheDir('/Users/stenpel/Sites/FirstStep/smarty/cache');
      self::$smarty->setConfigDir('/Users/stenpel/Sites/FirstStep/smarty/configs');
      
    }
    return self::$smarty;
  }
}
?>