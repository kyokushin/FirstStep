<?php
require('Common/Template.php');

class ViewPlayListController {
  private $template;
  
  function __construct() {
    $this->template = Template::GetTemplate();
  }

  public function run($mode, $data) {
    $this->template->display('view_play_list.tpl');
  }
}
?>