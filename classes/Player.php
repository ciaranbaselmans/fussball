<?php
	require_once 'classes/DBConnector.php';

	class Player {
		private $id;
		private $name = "";
		
		public function __construct($id, $name) {
			$this->id = $id;
			$this->name = $name;
		}
		
		public static function WithRow($row) {
			$instance = new self($row['id'], $row['name']);
			return $instance;
		}
		
		public function getName() {
			return $this->name;
		}
		
		public function getId() {
			return $this->id;
		}
		
		public function setId($id) {
			$this->id = $id;
		}
		
		public function saveOrUpdate() {
			$DBconn = DBconnector::getConn();
			if (isset($this->id) && $this->id != 0) {
				// update
				mysqli_query($DBconn, "UPDATE Players SET `name` = '".$this->name."' WHERE `id` = ".$this->id) or die('Query failed: ' . mysqli_error($DBconn));
			} else {
				// insert
				mysqli_query($DBconn, "INSERT INTO Players (`name`) VALUES ('".$this->name."')") or die('Query failed: ' . mysqli_error($DBconn));
				$this->id = mysqli_insert_id($DBconn);
			}
		}
		
		public function getPlayedMatches($where = NULL) {
			$matches = array();
			$i = 0;
			if (isset($this->id) && $this->id != 0) {
				$where = Player::where($where);
				$DBconn = DBconnector::getConn();
				$result = mysqli_query($DBconn, "SELECT * from Matches WHERE (player1_id = ".$this->id." OR player2_id = ".$this->id.")".$where." ORDER BY fixture ASC");
				if (!empty($result)) {
					while ($row = mysqli_fetch_array($result)) { 
						$matches[$i] = Match::WithRow($row);
						$i++;
					}
				}
			} else {
				//
			}
			return $matches;
		}
		
		public function getAllPlayedMatches($where = NULL) {
			return $this->getPlayedMatches($where);
		}
		
		public function getMatchesLost($where = NULL) {
			$where = Player::where($where);
			return $this->getPlayedMatches(" winner != ".$this->id." ".$where);
		}
		
		public function getMatchesDraw($where = NULL) {
			$where = Player::where($where);
			return $this->getPlayedMatches(" winner = 0"." ".$where);
		}
		
		public function getMatchesWon($where = NULL) {
			$where = Player::where($where);
			return $this->getPlayedMatches(" winner = ".$this->id." ".$where);
		}
		
		public function getAllPlayedMatchesVs($player2, $where = NULL) {
			$where = Player::where($where);
			return $this->getPlayedMatches(" (player1_id = ".$player2->id." OR player2_id = ".$player2->id.")"." ".$where);
		}
		
		public function getMatchesLostVs($player2, $where = NULL) {
			$where = Player::where($where);
			return $this->getPlayedMatches(" (player1_id = ".$player2->id." OR player2_id = ".$player2->id.") AND winner != ".$this->id." ".$where);
		}
		
		public function getMatchesDrawVs($player2, $where = NULL) {
			$where = Player::where($where);
			return $this->getPlayedMatches(" (player1_id = ".$player2->id." OR player2_id = ".$player2->id.") AND winner = 0"." ".$where);
		}
		
		public function getMatchesWonVs($player2, $where = NULL) {
			$where = Player::where($where);
			return $this->getPlayedMatches(" (player1_id = ".$player2->id." OR player2_id = ".$player2->id.") AND winner = ".$this->id." ".$where);
		}
		
		public function getGoalSum($allmatches) {
			$goals['for']=0;
			$goals['against']=0;
			foreach ($allmatches as $match) {
				$players_id = $match->getPlayers_id();
				$scores = $match->getScore();
				if ($players_id[0] == $this->id) {
					$goals['for']+=$scores[0];
					$goals['against']+=$scores[1];
				} else {
					$goals['for']+=$scores[1];
					$goals['against']+=$scores[0];
				}
			}
			return $goals;
		}
		
		public static function getAllPlayers() {
			$players = array();
			$i = 0;
			$DBconn = DBconnector::getConn();
			$query = mysqli_query($DBconn, "SELECT * FROM Players ORDER BY name");
			if(!empty($query)) {
				$totalRows = mysqli_num_rows($query);
// 				var_dump($totalRows);
				while ($row = mysqli_fetch_array($query)) {
					$players[$i] = Player::WithRow($row);
					$i++;
				}
			}
			return $players;
		}
		
		public static function where($where = NULL) {
			if (isset($where)) {
				$where = " AND ".$where;
			} else {
				$where = "";
			}
			return $where;
		}
	}
?>