<?php
	require_once 'classes/DBConnector.php';
	
	class Match {
		private $id;
		private $player1;	// these contain ids, not objects
		private $player2;
		private $score1;
		private $score2;
		private $fixture;
		private $winner;
		
		public function __construct($id, $player1, $player2, $score1, $score2, $fixture) {
			$this->id = $id;
			$this->player1 = $player1;
			$this->player2 = $player2;
			$this->score1 = $score1;
			$this->score2 = $score2;
			$this->fixture = $fixture;
			if ($score1 > $score2) {
				$this->winner = $player1;
			} else if ($score1 < $score2) {
				$this->winner = $player2;
			} else {
				$this->winner = 0;
			}
		}
		
		public static function WithRow($row) {
			$instance = new self($row['id'], $row['player1_id'], $row['player2_id'], $row['score1'], $row['score2'], $row['fixture']);
			return $instance;
		}
		
		public function getId() {
			return $this->id;
		}
		
		public function setId($id) {
			$this->id = $id;
		}
		
		public function getPlayers_id() {
			$players[0]=$this->player1;
			$players[1]=$this->player2;
			return $players;
		}
		
		public function getScore() {
			$score[0] = $this->score1;
			$score[1] = $this->score2;
			return $score;
		}
		
		public function getFixture() {
			return $this->fixture;
		}
		
		public function getWinner() {
			return $this->winner;
		}
		
		public function saveOrUpdate() {
			$DBconn = DBconnector::getConn();
			if (isset($this->id) && $this->id != 0) {
				// update
				mysqli_query($DBconn, "UPDATE Matches SET player1_id = ".$this->player1.",  player2_id = ".$this->player2." ,  score1 = ".$this->score1." ,  score2 = ".$this->score2." ,  `fixture` = '".$this->fixture."', ".$this->winner." WHERE `id` = ".$this->id) or die('Query failed: ' . mysqli_error($DBconn));
			} else {
				// insert
				mysqli_query($DBconn, "INSERT INTO Matches (`player1_id`, `player2_id`, `score1`, `score2`, `fixture`, `winner`) VALUES (".$this->player1.", ".$this->player2.", ".$this->score1.", ".$this->score2.", '".$this->fixture."', ".$this->winner.")") or die('Query failed: ' . mysqli_error($DBconn));
				$this->id = mysqli_insert_id($DBconn);
			}
		}
	}
	
?>