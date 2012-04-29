<?php
/*Youtube APIを利用して動画検索を行い、URLを返すメソッド*/

define("URL_YOUTUBE_API", "http://gdata.youtube.com/feeds/api/videos?vq=");

function get_url_list($keyword) {
  if (!$keyword) {
    throw new Exception('keyword is not defined');
  }
  else {
    $request = URL_YOUTUBE_API . urlencode($keyword) . "&format=5" . "&max-results=1";
    $curl_obj = curl_init($request);
    
    $xml = simplexml_load_file($request) or die("XML parser error");

    $url = _get_url_from_xml($xml);

    return $url;
  }
}

function get_url_list_from_json($keyword) {
  $request =  URL_YOUTUBE_API . urlencode($keyword) .  "&alt=json" . "&format=5";
  $curl_obj = curl_init($request);

  $json = file_get_contents($request);
  $decoded_json = json_decode($json);
  
  $url;
  $list_entry = $decoded_json->{"feed"}->{"entry"};
  foreach ( $list_entry as $entry) {
    $url = $entry->{'media$group'}->{'media$content'}[0]->{'url'};
    if(isset($url)) { break; }
  }
  
  curl_close($curl_obj);
  return $url;
}

function _get_url_from_xml($xml) {
  $url = $xml->entry[0]->link["href"];
  return $url;
}

# example
get_url_list_from_json("take me out");
?>