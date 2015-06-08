<?php /* Smarty version 3.1.24, created on 2015-06-07 22:25:46
         compiled from "./templates/board.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:19312254255575275abe2e05_26369870%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9c7067bd9cea3c0a191308a03374e51f9d6563a2' => 
    array (
      0 => './templates/board.tpl',
      1 => 1433741146,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19312254255575275abe2e05_26369870',
  'variables' => 
  array (
    'info' => 0,
    'arr' => 0,
    'item' => 0,
    'turn' => 0,
    'char' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_5575275ac358f0_67866154',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5575275ac358f0_67866154')) {
function content_5575275ac358f0_67866154 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '19312254255575275abe2e05_26369870';
$_smarty_tpl->tpl_vars["turn"] = new Smarty_Variable(false, null, 0);?>

	You play
	<?php if ($_smarty_tpl->tpl_vars['info']->value['id'] == $_smarty_tpl->tpl_vars['info']->value['user_x_id']) {?>
		X,
		<?php if ($_smarty_tpl->tpl_vars['info']->value['turn_x'] === '1') {?>
			you turn.
			<?php $_smarty_tpl->tpl_vars["char"] = new Smarty_Variable('X', null, 0);?>
			<?php $_smarty_tpl->tpl_vars["turn"] = new Smarty_Variable(true, null, 0);?>
		<?php } else { ?>
			turn O.
		<?php }?>
	<?php } else { ?>
		O,
		<?php if ($_smarty_tpl->tpl_vars['info']->value['turn_o'] === '1') {?>
			you turn.
			<?php $_smarty_tpl->tpl_vars["char"] = new Smarty_Variable('O', null, 0);?>
			<?php $_smarty_tpl->tpl_vars["turn"] = new Smarty_Variable(true, null, 0);?>
		<?php } else { ?>
			turn X.
		<?php }?>
	<?php }?>

<br>
<?php if ($_smarty_tpl->tpl_vars['info']->value['status'] === '1') {?>
	X win!
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['status'] === '2') {?>
	O win!
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['status'] === '3') {?>
	Cat's game
<?php }?>

	<br>

	<table>
		<?php
$_from = $_smarty_tpl->tpl_vars['info']->value['board'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['arr'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['arr']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['arr']->value) {
$_smarty_tpl->tpl_vars['arr']->_loop = true;
$foreach_arr_Sav = $_smarty_tpl->tpl_vars['arr'];
?>
			<tr>
				<?php
$_from = $_smarty_tpl->tpl_vars['arr']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
					<td <?php if ($_smarty_tpl->tpl_vars['item']->value === '0' && $_smarty_tpl->tpl_vars['turn']->value === true && $_smarty_tpl->tpl_vars['info']->value['status'] === '0') {?>
						onclick="game(this, '<?php echo $_smarty_tpl->tpl_vars['char']->value;?>
');"
						<?php }?>>
						<?php if ($_smarty_tpl->tpl_vars['item']->value !== '0') {?>
							<?php if ($_smarty_tpl->tpl_vars['item']->value === '1') {?>
								X
							<?php } else { ?>
								O
							<?php }?>
						<?php }?>
					</td>
				<?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>
			</tr>
		<?php
$_smarty_tpl->tpl_vars['arr'] = $foreach_arr_Sav;
}
?>
	</table>

<?php if ($_smarty_tpl->tpl_vars['info']->value['status'] === '0') {?>
<?php echo '<script'; ?>
 language="javascript">
	var stop = false;
	function game(el, ch){

		if (stop) return false;
		el.innerText = ch;

		tds = document.getElementsByTagName('td');
		arr = Array.apply(null, new Array(3)).map(function(val, i) {
			return Array.apply(null, new Array(3)).map(function(val, j) {
				if(i != 0) j=j+3*i;
				if(tds[j].innerText === 'X') return 1;
				if(tds[j].innerText === 'O') return 2;
				return 0;
			});
		});
		var board = arr.join('-').replace("/,/g",'');

		$.ajax({
			type: 'POST',
			url: host,
			data: {
				board: board,
				fromUserId:userId,
				char:ch
			},
			dataType: 'json',
			success: function (data) {
				console.log(data);
			}
		});
		stop = true;
	}
<?php echo '</script'; ?>
>
<?php }

}
}
?>