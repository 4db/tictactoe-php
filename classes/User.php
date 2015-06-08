<?php

/**
 * Class User
 */
Class User extends ErrorLog{
	/**
	 * @var PDO
	 */
	protected $db;
	/**
	 * @var Game
	 */
	protected $game;
	/**
	 * @var array
	 */
	protected $gameInfo;
	/**
	 * @var array
	 */
	public $info;
	/**
	 * @var array
	 */
	public $usersOnline;

	public function __construct() {
		$this->db = DB::getInstance();
		$this->game = new Game();
	}
	/**
	 * @param string $username
	 * @return bool|string
	 */
	public function login($username) {
		if(!isset($_POST['username'])) return false;
		$name = $_POST['username'];
		if(!is_string($name)) return false;
		if(trim($name) === '') return false;
		if(count($name) > 255) return false;

		try {
			$sql = "INSERT INTO users (name) VALUES ('{$name}')";
			$query = $this->db->prepare($sql);
			if(!$query->execute()){
				throw new PDOException('Error in SQL ' . $sql);
			}
			return $this->db->lastInsertId();
		} catch (PDOException $e) {
			$this->error($e->getMessage());
			return false;
		}
	}
	/**
	 * @param $userId
	 * @return array|bool
	 */
	public function online($userId) {
		try {
			$sql = "UPDATE users SET updated = NOW() WHERE id = '{$userId}'";
			$query = $this->db->prepare($sql);
			if(!$query->execute()){
				throw new PDOException('Error in SQL ' . $sql);
			}
			$sql = "SELECT u.id, u.name, u.is_play, u.game_id as u_game_id,
						g.id as g_id, g.board, g.user_x_id, g.user_o_id,
						g.turn_x, g.turn_o, g.status
					 FROM users u
					LEFT JOIN game g ON u.game_id = g.id
					WHERE u.updated BETWEEN DATE_SUB(NOW(), INTERVAL 15 SECOND ) AND NOW()";
			$query = $this->db->prepare($sql);
			if(!$query->execute()){
				throw new PDOException('Error in SQL ' . $sql);
			}
			$arr = $query->fetchAll(PDO::FETCH_ASSOC);

			foreach($arr as $k=>$v) {
				if ($userId == $v['id']) {
					$this->userKey = $v['id'];
					$arr[$k]['currentUser'] = true;
					$this->info = $v;
					$this->info['board'] = $this->game->getBoard($v['board']);
				}
			}
			$this->usersOnline = $arr;
			return true;
		} catch (PDOException $e) {
			$this->error($e->getMessage());
			return false;
		}
	}
	/**
	 * Block users for game
	 * @param $from
	 * @param $to
	 * @return bool
	 */
	public function block($from, $to) {
		try {
			$where ="WHERE id IN('{$from}', '{$to}')";

			$sql = "SELECT id FROM users {$where}";
			$query = $this->db->prepare($sql);

			if(!$query->execute()){
				throw new PDOException('Error in SQL ' . $sql);
			}
			if ($query->rowCount() !== 2) return false;

			$sql = "UPDATE users SET is_play = 1 {$where}";

			$query = $this->db->prepare($sql);
			if(!$query->execute()){
				throw new PDOException('Error in SQL ' . $sql);
			}
			return true;
		} catch (PDOException $e) {
			$this->error($e->getMessage());
			return false;
		}
	}
	/**
	 * @param $from
	 * @param $to
	 * @return bool
	 */
	public function updateGameId($from, $to) {
		try {
			$gameId = $this->game->create($to, $from);

			$sql = "UPDATE users SET game_id = '{$gameId}' WHERE id IN('{$from}', '{$to}')";

			$query = $this->db->prepare($sql);
			if(!$query->execute()){
				throw new PDOException('Error in SQL ' . $sql);
			}
			return true;
		} catch (PDOException $e) {
			$this->error($e->getMessage());
			return false;
		}
	}
	/**
	 * @param $userId
	 * @param $ch
	 * @return bool
	 */
	public function getGameId($userId, $ch) {
		try {

			$sql = "SELECT u.game_id, g.turn_x, g.turn_o, g.status
					 FROM users u
					LEFT JOIN game g ON u.game_id = g.id
					WHERE
						u.updated BETWEEN DATE_SUB(NOW(), INTERVAL 15 SECOND ) AND NOW()
						AND u.id = '{$userId}'
					";
			$query = $this->db->prepare($sql);
			if(!$query->execute()){
				throw new PDOException('Error in SQL ' . $sql);
			}
			$arr = $query->fetchAll(PDO::FETCH_ASSOC);

			if (!isset($arr[0])) return false;

			if (
				($arr[0]['turn_x'] === '1' && $ch === 'X') ||
				($arr[0]['turn_o'] === '1' && $ch === 'O')
			) {
				$this->gameInfo = $arr[0];
				return true;
			}
			return false;
		} catch (PDOException $e) {
			$this->error($e->getMessage());
			return false;
		}
	}
	/**
	 * @param $board
	 */
	public function turn($board){
		if (isset($this->gameInfo)) {
			$status = $this->game->update($board, $this->gameInfo);
			if ($status !== 0) {
				$this->unBlock();
			}
		}
	}
	/**
	 * @return bool
	 */
	public function unBlock() {
		try {
			$sql = "UPDATE users SET is_play = 0
			WHERE game_id = '{$this->gameInfo['game_id']}'";
			$query = $this->db->prepare($sql);
			if(!$query->execute()){
				throw new PDOException('Error in SQL ' . $sql);
			}
			return true;
		} catch (PDOException $e) {
			$this->error($e->getMessage());
			return false;
		}
	}
}