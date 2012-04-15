<html>
  <head>
    <title>Smarty::Confirm</title>
  </head>
  <body>
    プレイリストを作成します
    <ul>
      {foreach from=$music_url_list item=url}
      <li>{$url}</li>
      {/foreach}
      {$play_list_data}
    </ul>
    <form action="?mode=finish" method="POST">
      <input type="hidden" name="data" value='{$play_list_data}'>
      <input type="submit" value="OK">
    </form>
    <form action="./index.php" method="get">
      <input type="submit" value="NO">
    </form>
  </body>
</html>
