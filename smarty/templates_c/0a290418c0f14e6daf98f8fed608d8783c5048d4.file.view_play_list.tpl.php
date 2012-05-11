<?php /* Smarty version Smarty-3.1.8, created on 2012-05-06 17:38:55
         compiled from "/Users/stenpel/Sites/FirstStep/smarty/templates/view_play_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1076585534f9d0f9a30ec25-15872647%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0a290418c0f14e6daf98f8fed608d8783c5048d4' => 
    array (
      0 => '/Users/stenpel/Sites/FirstStep/smarty/templates/view_play_list.tpl',
      1 => 1336293531,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1076585534f9d0f9a30ec25-15872647',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f9d0f9a3a3f14_38956295',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f9d0f9a3a3f14_38956295')) {function content_4f9d0f9a3a3f14_38956295($_smarty_tpl) {?><html>
  <head>
    <title>PlayList</title>
    <script src="js/jquery.js"></script>
    <script src="js/jquery.swfobject.1-1-1.min.js"></script>
    <script src="js/lib/firststep/flash_player_controller.js"></script>
  </head>
  <body bgcolor=#FF3399>
    <div id="flash_player"></div>
    <input type="button" id="next_button" value="next">
    <input type="button" id="stop_button" value="play">
    <input type="button" id="prev_button" value="prev">
    <div id="play_lists" next_song_url="hoge" prev_song_url="huga" display="none">
      
    </div>
  </body>
</html>
<?php }} ?>