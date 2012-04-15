<?php
/**/
require('./Fetcher.php');
require('DB/db_functions.php');

class ConfirmController {
  private $mode_list = array('confirm', 'finish', 'error');

  public function run($mode) {
    $this->error() if !$this->is_valid_mode($mode);
    $mode();
  }

  private function is_valid_mode($input_mode) {
    $mode_list = $this->mode_list;
    foreach ($mode_list as $mode) {
      return true if $mode === $input_mode;
    }
    return false;
  }

  private function confirm($query_list) {
    $music_url_list;
    foreach ($query_list as $query) {
      get_url_list($query);
    }
  
  // view confirm.  
}

  private function finish() {
    // insert play-list.
    $MusicPlayListDBHandler = new MusicPlayListDB();
  }
  
  private function error() {
    // view error
  }
}
?>