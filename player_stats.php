<?php
	require_once 'classes/Player.php';
	require_once 'classes/Match.php';
	require_once 'conf/settings.php';
	
	$players = Player::getAllPlayers();
	
	$context_player_id = $_GET['id'];
	if (!isset($context_player_id)) {
		die("Player Id missing");
	}
	$context_player = null;
	foreach($players as $player) {
		if ($player->getId() == $context_player_id) {
			$context_player = $player;
		}
	}
	if ($context_player==null) {
		die("Wrong player Id");
	}

	// -----------------------------------------------
	//stats
	$stats = array();
	
	foreach ($players as $player) {
		if ($player->getId()==$context_player_id) {
			$allOfThem = $context_player->getAllPlayedMatches();
		} else {
			$allOfThem = $context_player->getAllPlayedMatchesVs($player);
		}
		$stats[$player->getId()]['matches'] = $allOfThem;

		$stats[$player->getId()]["wins"] = array();
		$stats[$player->getId()]["draws"] = array();
		$stats[$player->getId()]["losses"] = array();
		$stats[$player->getId()]["goalSum"] = array("for" => 0, "against" => 0);
		
		if (sizeof($allOfThem) > 0) {
	
			$currentVstreak = 0;
			$beststreak = 0;
			$currentDstreak = 0;
			$worststreak = 0;
				
				
			foreach ($allOfThem as $match) {
				if ($match->getWinner() == $context_player_id) {
					$currentDstreak = 0;
					$currentVstreak++;
					if ($currentVstreak > $beststreak) {
						$beststreak = $currentVstreak;
					}
				} else {
					$currentVstreak = 0;
					$currentDstreak++;
					if ($currentDstreak > $worststreak) {
						$worststreak = $currentDstreak;
					}
				}
			}

			$stats[$player->getId()]["currentVstreak"] = $currentVstreak;
			$stats[$player->getId()]["currentDstreak"] = $currentDstreak;
			$stats[$player->getId()]["worststreak"] = $worststreak;
			$stats[$player->getId()]["beststreak"] = $beststreak;
			
			$wins = $context_player->getMatchesWonVs($player);
			$draws = $context_player->getMatchesDrawVs($player);
			$losses = $context_player->getMatchesLostVs($player);
			$goalSum = $context_player->getGoalSum($allOfThem);
			$stats[$player->getId()]["wins"] = isset($wins)?$wins:array();
			$stats[$player->getId()]["draws"] = isset($draws)?$draws:array();
			$stats[$player->getId()]["losses"] = isset($losses)?$losses:array();
			$stats[$player->getId()]["goalSum"] = isset($goalSum)?$goalSum:array("for" => 0, "against" => 0);
		}
	}
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $label['player_stats']['title'] ?></title>
		<link rel="stylesheet" type="text/css" href="styles/default.css">
		<link rel="stylesheet" type="text/css" href="styles/jquery.jqplot.min.css">
		<style type="text/css">
			#chart3 .jqplot-point-label {
			  border: 1.5px solid #aaaaaa;
			  padding: 1px 3px;
			  background-color: #eeccdd;
			}
		</style>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jqplot.min.js"></script>
		<script type="text/javascript" src="js/jqplot.barRenderer.min.js"></script>
		<script type="text/javascript" src="js/jqplot.categoryAxisRenderer.min.js"></script>
		<script type="text/javascript" src="js/jqplot.pointLabels.min.js"></script>
		<script type="text/javascript">

		function makeHistoryBarChart(playerid, serie1, serie2) {
			var ratios1 = new Array(serie1.length);
			var ratios2 = new Array(serie1.length);
			var labelarray = new Array(serie1.length);
			var barcolour = new Array(serie1.length);
			for (var i = 0; i < serie1.length; i++) {
				ratios1[i] = serie1[i] / (serie1[i] + serie2[i]);
				ratios2[i] = serie2[i] / (serie1[i] + serie2[i]);
				labelarray[i] = serie1[i]+"-"+serie2[i];
				if (serie1[i] > serie2[i]) {
					barcolour[i] = "#00FF00";
				} else if (serie1[i] == serie2[i]) {
					barcolour[i] = "#0000FF";
				} else {
					barcolour[i] = "#FF0000";
				}
			}
			var graph = $.jqplot('score_progress_'+playerid,
					[ratios1],
					{
						title: '<?php echo $label['player_stats']['Score_history']?>',
						seriesDefaults: {
							renderer: $.jqplot.BarRenderer,
							rendererOptions:{
								varyBarColor : true,
								barMargin: 1
							}
						},
						series:[{pointLabels: {
									show: true,
									labels: labelarray
								}
						}],
						axes: {
							xaxis: {
								renderer:$.jqplot.CategoryAxisRenderer
							},
							yaxis: {
								label: "<?php echo $label['player_stats']['Score']?>",
								padMax:1.3,
								min: 0,
								max: 1
							}
						},
						seriesColors: barcolour
					}
			);
			return graph;
		}

		function makeHistoryBarChart_old(playerid, serie1, serie2) {
			var ratios1 = new Array(serie1.length);
			var ratios2 = new Array(serie1.length);
			var labelarray  = new Array(serie1.length);
			for (var i = 0; i < serie1.length; i++) {
				ratios1[i] = serie1[i] / (serie1[i] + serie2[i]);
				ratios2[i] = serie2[i] / (serie1[i] + serie2[i]);
				labelarray[i] = serie1[i]+"-"+serie2[i];
			}
			var graph = $.jqplot('score_progress_'+playerid,
					[ratios1, ratios2],
					{
						title: '<?php echo $label['player_stats']['Score_history']?>',
						stackSeries: true,
						seriesDefaults: {
							renderer: $.jqplot.BarRenderer,
							rendererOptions:{
								varyBarColor : true,
								barMargin: 1
							}
						},
						series:[{pointLabels: {
									show: true,
									labels: labelarray
								}
						}],
						axes: {
							xaxis: {
								renderer:$.jqplot.CategoryAxisRenderer
							},
							yaxis: {
								label: "<?php echo $label['player_stats']['Score']?>",
								padMax:1.3,
								min: 0,
								max: 1
							}
						},
						seriesColors: ["#00FF00", "#FF0000", "#0000FF", "#FFFF00"]
					}
			);
			return graph;
		}
			
			$(document).ready(function() 
				{ 
					$("#player2").val(<?php echo $context_player_id ?>);
<?php 
	foreach ($players as $player) {
// 		if ($context_player_id == $player->getId()) continue; 
?>
		// Player: <?php echo $player->getName() ?>
		
<?php 	
		
		if (sizeof($stats[$player->getId()]['matches']) > 0) {
		
			$s1string = "";
			$s2string = ""; 
			
			foreach ($stats[$player->getId()]['matches'] as $match) {
				$context_player_score = 0;
				$opponent_player_score = 0;
				// which score is which
				$players_id = $match->getPlayers_id();
				$scores = $match->getScore();
				if ($players_id[0] == $context_player_id) {
					$context_player_score = $scores[0];
					$opponent_player_score = $scores[1];
				} else {
					$context_player_score = $scores[1];
					$opponent_player_score = $scores[0];
				}
				// TODO: change score to %
				// now append
				if (strlen($s1string) > 0) {
					$s1string = $s1string.", ";
					$s2string = $s2string.", ";
				}
				$s1string = $s1string.$context_player_score;
				$s2string = $s2string.$opponent_player_score;
				
			}
?>
					var s1_<?php echo $context_player_id ?>_vs_<?php echo $player->getId() ?> = [<?php echo $s1string ?>];
					var s2_<?php echo $context_player_id ?>_vs_<?php echo $player->getId() ?> = [<?php echo $s2string ?>];
					var score_plot_<?php echo $context_player_id ?>_vs_<?php echo $player->getId() ?> = makeHistoryBarChart(<?php echo $player->getId() ?>, s1_<?php echo $context_player_id ?>_vs_<?php echo $player->getId() ?>, s2_<?php echo $context_player_id ?>_vs_<?php echo $player->getId() ?>);
					
<?php 
		}
		if ($context_player_id != $player->getId()) {
?>
					$("#stats_vs_player_<?php echo $player->getId() ?>").hide();

<?php 
		}
		
	}
?>
					$("#player2").on('change', function() {
						var newplayerid = $("#player2 option:selected").val();
						$("#stats_vs_player_"+newplayerid).parent().children('div').hide();
						$("#stats_vs_player_"+newplayerid).show();
					});
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
			<h1><?php echo $label['player_stats']['title']." - ".$context_player->getName() ?></h1>
			<br />
			<br />
			<div class="stats">
				<div id="vs">
					<h3><?php echo $label['player_stats']['Showing_stats_against'] ?>:</h3>
					<select id="player2" name="player2">
						<option value ="<?php echo $context_player->getId() ?>" selected>All</option>
<?php 
	foreach ($players as $player) {
		if ($player->getId()==$context_player->getId()) continue;
?>
						<option value ="<?php echo $player->getId() ?>"><?php echo $player->getName() ?></option>
<?php 
	}
?>
					</select>
<?php 
	foreach ($players as $player) {
		if ($player->getId()==$context_player->getId()) {
			$name = "All";
		} else {
			$name = $player->getName();
		}
?>				
					<div id="stats_vs_player_<?php echo $player->getId() ?>">
						<h2>Stats vs player <?php echo $name ?></h2>
						<h3><?php echo $label['player_stats']['status'] ?></h3>
<?php 

?>
						<table id="Ranking" class="tablesorter">
							<thead>
								<tr>
									<th title="<?php echo $label['stats']['title_Played'] ?>" ><?php echo $label['stats']['Played'] ?></td>
									<th title="<?php echo $label['stats']['title_Wins'] ?>" ><?php echo $label['stats']['Wins'] ?></td>
									<th title="<?php echo $label['stats']['title_Draws'] ?>" ><?php echo $label['stats']['Draws'] ?></td>
									<th title="<?php echo $label['stats']['title_Losses'] ?>" ><?php echo $label['stats']['Losses'] ?></td>
									<th title="<?php echo $label['stats']['title_Goals_For'] ?>" ><?php echo $label['stats']['Goals_For'] ?></td>
									<th title="<?php echo $label['stats']['title_Goals_Against'] ?>" ><?php echo $label['stats']['Goals_Against'] ?></td>
									<th title="<?php echo $label['stats']['title_Goals_Diff'] ?>" ><?php echo $label['stats']['Goals_Diff'] ?></td>
								</tr>
							</thead>
							<tbody>
								<tr>
								<td><?php echo sizeof($stats[$player->getId()]["matches"]) ?></td>
								<td><?php echo sizeof($stats[$player->getId()]["wins"]) ?></td>
								<td><?php echo sizeof($stats[$player->getId()]["draws"]) ?></td>
								<td><?php echo sizeof($stats[$player->getId()]["losses"]) ?></td>
								<td><?php echo $stats[$player->getId()]["goalSum"]['for'] ?></td>
								<td><?php echo $stats[$player->getId()]["goalSum"]['against'] ?></td>
								<td><?php echo $stats[$player->getId()]["goalSum"]['for']-$stats[$player->getId()]["goalSum"]['against'] ?></td>
								</tr>
<?php 
	//
?>
							</tbody>
						</table>
<?php 
		if (sizeof($stats[$player->getId()]["matches"]) == 0) {
?>
						<span><?php echo $label['player_stats']['Never_played'] ?></span><br />
<?php 
		} else {
			if ($stats[$player->getId()]["matches"][sizeof($stats[$player->getId()]["matches"])-1]->getWinner() == $context_player_id) {
?>
						<span><?php echo $label['player_stats']['Current_victory_streak'] ?>:</span>&nbsp;<?php echo $stats[$player->getId()]["currentVstreak"] ?><br />
<?php 
			} else {
?>
						<span><?php echo $label['player_stats']['Current_defeat_streak'] ?>:</span>&nbsp;<?php echo $stats[$player->getId()]["currentDstreak"] ?><br />
<?php 
			}
?>
						<span><?php echo $label['player_stats']['Best_victory_streak'] ?>:</span>&nbsp;<?php echo $stats[$player->getId()]["beststreak"] ?><br />
						<span><?php echo $label['player_stats']['Worst_defeat_streak'] ?>:</span>&nbsp;<?php echo $stats[$player->getId()]["worststreak"] ?><br />
						<br />
						<span><?php echo $label['player_stats']['Average_score_by']." ".$context_player->getName() ?>:</span>&nbsp;<?php echo round($stats[$player->getId()]["goalSum"]["for"] / count($stats[$player->getId()]["matches"]), 2) ?><br />
						<span><?php echo $label['player_stats']['Average_score_by']." ".$name ?>:</span>&nbsp;<?php echo round($stats[$player->getId()]["goalSum"]["against"] / count($stats[$player->getId()]["matches"]), 2) ?><br />
<?php 
		}
?>
						<div id="score_progress_<?php echo $player->getId(); ?>" class="jqplot jqplot-target">
							
						</div>
					</div> <!-- stats_vs_player_* -->
<?php 
	}
?>
				</div> <!-- vs -->
			</div> <!-- stats -->
		</div> <!-- wrapper -->
	</body>	
</html>