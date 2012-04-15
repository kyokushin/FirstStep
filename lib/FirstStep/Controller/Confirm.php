<?php
/**/
require('/usr/local/lib/php/Smarty/Smarty.class.php');

require('FirstStep/Fetcher.php');
require('FirstStep/DB/db_functions.php');

class ConfirmController {
  private $mode_list = array('confirm', 'finish', 'test');
  private $smarty;
  private $MusicPlayListDBHandler;

  function __construct() {
    $this->smarty = new Smarty();

    $this->smarty->setTemplateDir('/Users/stenpel/Sites/FirstStep/smarty/templates');
    $this->smarty->setCompileDir('/Users/stenpel/Sites/FirstStep/smarty/templates_c');
    $this->smarty->setCacheDir('/Users/stenpel/Sites/FirstStep/smarty/cache');
    $this->smarty->setConfigDir('/Users/stenpel/Sites/FirstStep/smarty/configs');

    $this->MusicPlayListDBHandler = new MusicPlayListDB();
  }

  public function run($mode, $data) {
    if ($this->is_valid_mode($mode)) {
      $this->$mode($data);
    }
    else $this->error();
  }

  private function is_valid_mode($input_mode) {
    $mode_list = $this->mode_list;
    foreach ($mode_list as $mode) {
      if($mode === $input_mode) {
	return true;
      }
    }
    return false;
  }

  private function confirm($data) {
    $decoded_playlist_data = json_decode($data);
    $query_list = $decoded_playlist_data->{'query_list'};
    
    $music_url_list;
    foreach ($query_list as $q) {
      $song_name = $q->{'song_name'};
      $artist_name = $q->{'artist_name'};

      $music_url = $this->get_music_url($song_name, $artist_name);
      if(!$music_url) {
	$query = $song_name . "+" . $artist_name;
	$music_url = get_url_list($query);
	$q->{'downloaded'} = "1";
      }

      $music_url_list["$query"] = $music_url;
      $q->{'url'} = "$music_url";
    }

    $encode_playlist_data = json_encode($decoded_playlist_data);

    $this->smarty->assign('music_url_list', $music_url_list);
    $this->smarty->assign('play_list_data', $encode_playlist_data);
    $this->smarty->display('confirm.tpl');
  }

  private function finish($data) {
    //
    $decoded_playlist_data = json_decode($data);
    $user_id = $decoded_playlist_data->{'user_id'};
    $title   = $decoded_playlist_data->{'title'};
    $comment = $decoded_playlist_data->{'comment'};
    $genre = $decoded_playlist_data->{'genre'};
    $music_list = $decoded_playlist_data->{'query_list'};

    // insert play-list.
    $this->MusicPlayListDBHandler->open();

    $play_list_id = $this->MusicPlayListDBHandler->addNewPlayList($user_id,
								  $title,
								  $comment,
								  $genre);

    foreach ( $music_list as $music_data ) {
      $song_name    = $music_data->{'song_name'};
      $artist_name  = $music_data->{'artist_name'};
      $url          = $music_data->{'url'};
      $order_number = $music_data->{'order_number'} || '1';
      $sinc         = $music_data->{'sinc'} || '1';
      $bpm          = $music_data->{'bpm'} || '120';
      $genre        = $music_data->{'genre'} || 'rock';
      $in_out       = $music_data->{'in_out'} || '1';
      $comment      = $music_data->{'comment'} || 'hogehoge';

      if($music_data->{'downloaded'}) {
	$this->MusicPlayListDBHandler->addNewMusic(
						   $this->normalize_query($song_name),
						   $this->normalize_query($artist_name),
						   $url);
      }

      $music_id = $this->MusicPlayListDBHandler->getMusicId($song_name, $artist_name);
      
      $this->MusicPlayListDBHandler->addNewPlayListItem($play_list_id,
							$music_id,
							$order_number,
							$sinc,
							$bpm,
							$genre,
							$in_out,
							$comment);
      
    }	

    $this->MusicPlayListDBHandler->close();

    $this->smarty->display('finish.tpl');
  }
  
  private function error() {
    $this->smarty->display('error.tpl');
  }

  private function test() {
    $this->smarty->assign('name', 'FirstStep::Confirm TEST');
    $this->smarty->display('index.tpl');
  }

  private function normalize_query($query) {
    return htmlspecialchars( strtolower( str_replace(" ", "", $query) ) );    
  }

  private function get_music_url($song_name, $artist_name) {
    $url;

    $this->MusicPlayListDBHandler->open();
    $url = $this->MusicPlayListDBHandler->getMusicUrl($this->normalize_query($song_name),
						      $this->normalize_query($artist_name));    
    $this->MusicPlayListDBHandler->close();

    return $url;      
  }

}
?>