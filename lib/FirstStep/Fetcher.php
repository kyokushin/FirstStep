<?php
/*Youtube APIを利用して動画検索を行い、URLを返すメソッド*/

define("URL_YOUTUBE_API", "http://gdata.youtube.com/feeds/api/videos?vq=");

function get_url_list($keyword) {
  if (!$keyword) {
    throw new Exception('keyword is not defined');
  }
  else {
    $request = URL_YOUTUBE_API . "$keyword";
    $curl_obj = curl_init($request);
    
    $xml = simplexml_load_file($request) or die("XML parser error");

    $url = _get_url_from_xml($xml);
    return $url;
  }
}

function _get_url_from_xml($xml) {
  $url = $xml->entry[0]->link["href"];
  return $url;
}

# example
# get_url_list("acidman");
?>