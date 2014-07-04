<?php
	require_once 'classes/Player.php';
	require_once 'classes/Match.php';
	require_once 'conf/settings.php';
	
	$players = Player::getAllPlayers();
	
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $label['stats']['title'] ?></title>
		<link rel="stylesheet" type="text/css" href="styles/default.css">
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
		<script type="text/javascript">
			$(document).ready(function() 
			    { 
			        $("#Ranking").tablesorter( {sortList: [[1,1], [2,1], [3,1], [5,1], [6,0]]}); 
			        //$("").focus();
			    } 
			);
		</script>
	</head>
	<body>
		<div class="wrapper">
			<div id="menu">
				<ul>
					<li><a href="index.php"><?php echo $label['menu']['Home'] ?></a></li>
					<li><a href="stats.php"><?php echo $label['menu']['Stats'] ?></a></li>
				</ul>
			</div>
			<br />
			<h1><?php echo $label['stats']['title'] ?></h1>
			<br />
			<br />
			<div class="stats">
				<h2><?php echo $label['stats']['AllTime_Player_ranking'] ?></h2>
				<table id="Ranking" class="tablesorter">
					<thead>
						<tr>
							<th title="<?php echo $label['stats']['title_Player'] ?>" ><?php echo $label['stats']['Player'] ?></td>
							<th title="<?php echo $label['stats']['title_Played'] ?>" ><?php echo $label['stats']['Played'] ?></td>
							<th title="<?php echo $label['stats']['title_Wins'] ?>" ><?php echo $label['stats']['Wins'] ?></td>
							<th title="<?php echo $label['stats']['title_Win_Ratio'] ?>" ><?php echo $label['stats']['Win_Ratio'] ?></td>
							<th title="<?php echo $label['stats']['title_Draws'] ?>" ><?php echo $label['stats']['Draws'] ?></td>
							<th title="<?php echo $label['stats']['title_Losses'] ?>" ><?php echo $label['stats']['Losses'] ?></td>
							<th title="<?php echo $label['stats']['title_Goals_For'] ?>" ><?php echo $label['stats']['Goals_For'] ?></td>
							<th title="<?php echo $label['stats']['title_Goals_Against'] ?>" ><?php echo $label['stats']['Goals_Against'] ?></td>
							<th title="<?php echo $label['stats']['title_Goals_Diff'] ?>" ><?php echo $label['stats']['Goals_Diff'] ?></td>
						</tr>
					</thead>
					<tbody>
<?php 
	for ($i=0;$i<sizeof($players); $i++) {
		$wins = $players[$i]->getMatchesWon();
		$draws = $players[$i]->getMatchesDraw();
		$losses = $players[$i]->getMatchesLost();
		$played = sizeof($wins) + sizeof($draws) + sizeof($losses);
		$allOfThem = $players[$i]->getAllPlayedMatches();
		$goalSum = $players[$i]->getGoalSum($allOfThem);

		$winRatio = 0;
		if ($played > 0) {
			$winRatio = (float)((float)sizeof($wins)/(float)$played);
			$winRatio = 100* $winRatio;
			$winRatio = round($winRatio, 2);
		}
?>
					<tr>
						<td><a href="player_stats.php?id=<?php echo $players[$i]->getId() ?>"><?php echo $players[$i]->getName() ?></a></td>
						<td><?php echo $played ?></td>
						<td><?php echo sizeof($wins) ?></td>
						<td><?php echo number_format($winRatio, 2) ?></td>
						<td><?php echo sizeof($draws) ?></td>
						<td><?php echo sizeof($losses) ?></td>
						<td><?php echo $goalSum['for'] ?></td>
						<td><?php echo $goalSum['against'] ?></td>
						<td><?php echo $goalSum['for']-$goalSum['against'] ?></td>
					</tr>
<?php 
	}
?>
					</tbody>
				</table>
			</div> <!-- stats -->
		</div> <!-- wrapper -->
	</body>	
</html>