<?php

Class Game extends ErrorLog{
	protected $db;

	protected $status = [
		'in_process' => 0,
		'win_x' => 1,
		'win_o' => 2,
		'cat"s game' => 3
	];

	protected $board = [
		[0,0,0],
		[0,0,0],
		[0,0,0]
	];

	public function __construct() {
		$this->db = DB::getInstance();
	}

	/**
	 * @return string
	 */
	public function boardToStr($board = '') {
		if (!empty($board)) $this->board = $board;
		$res = '';
		foreach($this->board as $k=>$arr) {
			if ($k !== 0) $res .= '-';
			$res .= join(',', $arr);
		}
		return $res;
	}

	/**
	 * @return bool|string
	 */
	public function create($user_x_id, $user_o_id){
		try {
			$sql = "INSERT INTO game (user_x_id, user_o_id, board, status)
					 VALUES (
					 '{$user_x_id}',
					 '{$user_o_id}',
					 '{$this->boardToStr()}',
					 '{$this->status['in_process']}'
					)";
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

	public function getBoard($board) {
		$board =  explode('-', $board);

		foreach($board as $k=>$v) {
			$board[$k] = explode(',', $v);
		}
		return $board;
	}

	public function update($board, $game) {
		$status = $this->check($board);
		$set = ",status='{$status}'";
		if ($game['turn_x'] === '1') $set.= ",turn_x=0,turn_o=1";
		if ($game['turn_o'] === '1') $set.= ",turn_x=1,turn_o=0";

		try {

			$sql = "UPDATE game
						SET board = '{$board}' {$set}
					WHERE id = '{$game["game_id"]}'";

			$query = $this->db->prepare($sql);
			if(!$query->execute()){
				throw new PDOException('Error in SQL ' . $sql);
			}
			return $status;
		} catch (PDOException $e) {
			$this->error($e->getMessage());
			return false;
		}
	}

	public function check($board) {
		$board = str_replace(',', '', $board);

		if( preg_match("/222|2...2...2|2....2....2|2..2..2/",$board) == true) {
			return $this->status['win_o'];
		}
		if( preg_match("/111|1...1...1|1....1....1|1..1..1/",$board) == true) {
			return $this->status['win_x'];
		}
		if(preg_match("/0/",$board) == true) return $this->status['in_process'];
		return $this->status['cat"s game'];
	}
}