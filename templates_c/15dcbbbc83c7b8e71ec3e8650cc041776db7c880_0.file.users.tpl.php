<?php /* Smarty version 3.1.24, created on 2015-06-07 21:02:44
         compiled from "./templates/users.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:679349147557513e4e7dd65_03616715%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '15dcbbbc83c7b8e71ec3e8650cc041776db7c880' => 
    array (
      0 => './templates/users.tpl',
      1 => 1433730311,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '679349147557513e4e7dd65_03616715',
  'variables' => 
  array (
    'users' => 0,
    'value' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_557513e4e9ecc4_52657169',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_557513e4e9ecc4_52657169')) {
function content_557513e4e9ecc4_52657169 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '679349147557513e4e7dd65_03616715';
?>
Users online:
<ul>
	<?php
$_from = $_smarty_tpl->tpl_vars['users']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['value']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
$foreach_value_Sav = $_smarty_tpl->tpl_vars['value'];
?>
		<li>
			<?php if (isset($_smarty_tpl->tpl_vars['value']->value['currentUser']) && $_smarty_tpl->tpl_vars['value']->value['currentUser'] === true) {?>
				<b><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
</b>
			<?php } else { ?>
				<?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>

				<?php if ($_smarty_tpl->tpl_vars['value']->value['is_play'] === "0") {?>
					<input class="play" type="button" value="play" onclick="play(<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
)">
				<?php }?>
			<?php }?>
		</li>
	<?php
$_smarty_tpl->tpl_vars['value'] = $foreach_value_Sav;
}
?>
</ul>
<?php }
}
?>