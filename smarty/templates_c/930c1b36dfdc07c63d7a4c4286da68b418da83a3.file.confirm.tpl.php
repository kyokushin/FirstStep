<?php /* Smarty version Smarty-3.1.8, created on 2012-04-29 15:40:03
         compiled from "/Users/stenpel/Sites/FirstStep/smarty/templates/confirm.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8217095444f8138b2ba8e12-32671989%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '930c1b36dfdc07c63d7a4c4286da68b418da83a3' => 
    array (
      0 => '/Users/stenpel/Sites/FirstStep/smarty/templates/confirm.tpl',
      1 => 1334492120,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8217095444f8138b2ba8e12-32671989',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f8138b2decf61_43217056',
  'variables' => 
  array (
    'music_url_list' => 0,
    'url' => 0,
    'play_list_data' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f8138b2decf61_43217056')) {function content_4f8138b2decf61_43217056($_smarty_tpl) {?><html>
  <head>
    <title>Smarty::Confirm</title>
  </head>
  <body>
    プレイリストを作成します
    <ul>
      <?php  $_smarty_tpl->tpl_vars['url'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['url']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['music_url_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['url']->key => $_smarty_tpl->tpl_vars['url']->value){
$_smarty_tpl->tpl_vars['url']->_loop = true;
?>
      <li><?php echo $_smarty_tpl->tpl_vars['url']->value;?>
</li>
      <?php } ?>
      <?php echo $_smarty_tpl->tpl_vars['play_list_data']->value;?>

    </ul>
    <form action="?mode=finish" method="POST">
      <input type="hidden" name="data" value='<?php echo $_smarty_tpl->tpl_vars['play_list_data']->value;?>
'>
      <input type="submit" value="OK">
    </form>
    <form action="./index.php" method="get">
      <input type="submit" value="NO">
    </form>
  </body>
</html>
<?php }} ?>