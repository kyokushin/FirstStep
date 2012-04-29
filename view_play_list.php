<?php
require('./lib/FirstStep/Controller/ViewPlayList.php');

$mode = $_GET["mode"] ? $_GET["mode"] : 'test';
$data = $_POST["data"] 
  ? $_POST["data"]
  : '{"user_id":"1", "title":"sample", "comment":"hoge", "genre":"rock", "query_list":[{"song_name":"Basket Case","artist_name":"greenday"},{"song_name":"one","artist_name":"Metallica"},{"song_name":"hell yeah","artist_name":"Zebrahead"}]}';

$controller = new ViewPlayListController();
$controller->run($mode, $data);

?>