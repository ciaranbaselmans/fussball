<?php
	require_once 'classes/Player.php';
	require_once 'classes/StatRow.php';
	
	class Utils {
		
		public static function getStats($where = NULL) {
			error_log("getStats says hi");
			$players = Player::getAllPlayers();
			$statrows = array();
			for ($i=0;$i<sizeof($players); $i++) {
				$wins = $players[$i]->getMatchesWon($where);
				$draws = $players[$i]->getMatchesDraw($where);
				$losses = $players[$i]->getMatchesLost($where);
				$played = sizeof($wins) + sizeof($draws) + sizeof($losses);
				$allOfThem = $players[$i]->getAllPlayedMatches($where);
				$goalSum = $players[$i]->getGoalSum($allOfThem);
				
				$winRatio = 0;
				if ($played > 0) {
					$winRatio = (float)((float)sizeof($wins)/(float)$played);
					$winRatio = 100* $winRatio;
					$winRatio = round($winRatio, 2);
				}
				$statrows[$i] = new StatRow(
											$players[$i]->getId(),
											$played,
											sizeof($wins),
											number_format($winRatio, 2),
											sizeof($draws),
											sizeof($losses),
											$goalSum['for'],
											$goalSum['against'],
											$goalSum['for']-$goalSum['against']
											);
				
			}
			return $statrows;
		}
		
		
		
	}
	
?>