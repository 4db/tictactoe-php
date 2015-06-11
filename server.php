<?php
include_once('classes/ErrorLog.php');
include_once('classes/DB.php');
include_once('classes/User.php');
include_once('classes/Game.php');

require_once 'vendor/autoload.php';

$smarty = new Smarty();
$user = new User();

/**
 * POST login
 */
if(isset($_POST['username'])) {

	$id = $user->login($_POST['username']);

	if ($user->online((int) $id)) {
		if (is_array($user->usersOnline) && !empty($user->usersOnline)) {
			$smarty->assign('users', $user->usersOnline);

			echo json_encode([
				'userId'=>$id,
				'html' =>$smarty->fetch('users.tpl'),
			]);
		}
	}
}
/**
 * GET online users
 */
else if(isset($_GET['userId'])) {
	if ($user->online((int) $_GET['userId'])) {
		if (is_array($user->usersOnline) && !empty($user->usersOnline)) {

			$board = '';
			if ($user->info['u_game_id'] !== '0') {
				$smarty->assign('info', $user->info);
				$board = $smarty->fetch('board.tpl');
			}

			$smarty->assign('users', $user->usersOnline);

			echo json_encode([
				'html' =>$smarty->fetch('users.tpl'),
				'board' =>$board,
			]);
		}
	}
}
/**
 * POST start Play game
 */
else if(isset($_POST['fromUser']) && isset($_POST['toUser'])) {
	if($user->block($_POST['fromUser'],$_POST['toUser'] )) {
		$user->updateGameId($_POST['fromUser'], $_POST['toUser']);
	}
}
/**
 * POST turn
 */
else if(isset($_POST['board']) && isset($_POST['fromUserId']) && isset($_POST['char'])) {
	if ($user->getGameId($_POST['fromUserId'], $_POST['char'])) {
		$user->turn($_POST['board']);
	}
}
