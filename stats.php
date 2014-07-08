<?php
	require_once 'classes/Player.php';
	require_once 'classes/Match.php';
	require_once 'classes/Utils.php';
	require_once 'conf/settings.php';
	
	$players = Player::getAllPlayers();
	$hof = Utils::getStats();
	$currentRanking = Utils::getStats($refTimeWindowWhereClause);
	
	
	
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
			        $("#HoF").tablesorter( {sortList: [[1,1], [2,1], [3,1], [5,1], [6,0]]}); 
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
				<h2><?php echo $label['stats']['Player_ranking'] ?></h2>
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
?>
					<tr>
						<td><a href="player_stats.php?id=<?php echo $players[$i]->getId() ?>"><?php echo $players[$i]->getName() ?></a></td>
						<td><?php echo $currentRanking[$i]->gp ?></td>
						<td><?php echo $currentRanking[$i]->w ?></td>
						<td><?php echo $currentRanking[$i]->wpgp ?></td>
						<td><?php echo $currentRanking[$i]->d ?></td>
						<td><?php echo $currentRanking[$i]->l ?></td>
						<td><?php echo $currentRanking[$i]->gf ?></td>
						<td><?php echo $currentRanking[$i]->ga ?></td>
						<td><?php echo $currentRanking[$i]->gd ?></td>
					</tr>
<?php 
	}
?>
					</tbody>
				</table>
			</div> <!-- stats -->
			<div class="stats">
				<h2><?php echo $label['stats']['AllTime_Player_ranking'] ?></h2>
				<table id="HoF" class="tablesorter">
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
?>
					<tr>
						<td><a href="player_stats.php?id=<?php echo $players[$i]->getId() ?>"><?php echo $players[$i]->getName() ?></a></td>
						<td><?php echo $hof[$i]->gp ?></td>
						<td><?php echo $hof[$i]->w ?></td>
						<td><?php echo $hof[$i]->wpgp ?></td>
						<td><?php echo $hof[$i]->d ?></td>
						<td><?php echo $hof[$i]->l ?></td>
						<td><?php echo $hof[$i]->gf ?></td>
						<td><?php echo $hof[$i]->ga ?></td>
						<td><?php echo $hof[$i]->gd ?></td>
					</tr>
<?php 
	}
?>
					</tbody>
				</table>
			</div> <!-- stats -->
			<div style="clear: left;"></div>
		</div> <!-- wrapper -->
	</body>	
</html>