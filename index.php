<?php
	require_once 'classes/Player.php';
	require_once 'classes/Match.php';
	require_once 'conf/settings.php';
	
	$players = Player::getAllPlayers();
	
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $label['index']['title'] ?></title>
		<link rel="stylesheet" type="text/css" href="styles/default.css">
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#insertNewPlayers').on('submit', function(e){
					e.preventDefault();
					var len = $('#insertNewPlayers_name').val().length;
					if (len == 0) {
						alert("<?php echo $label['index']['error_insertNewPlayers_missingname'] ?>");
					} else if (len < 30 && len > 0) {
						this.submit();
					} else if (len > 30) {
						alert("<?php echo $label['index']['error_insertNewPlayers_nametoolong'] ?>");
					}
				});
				$('#insertNewScores').on('submit', function(e){
					e.preventDefault();
					if ($('#player1').val() != $('#player2').val()) {
						this.submit();
					} else {
						alert("<?php echo $label['index']['error_insertNewScores_playersaresame'] ?>");
					}
				});
			});
		</script>
	</head>
	<body>
		<div class="wrapper">
			<div id="menu">
				<ul><!-- test commit  -->
					<li><a href="index.php"><?php echo $label['menu']['Home'] ?></a></li>
					<li><a href="stats.php"><?php echo $label['menu']['Stats'] ?></a></li>
				</ul>
			</div>
			<br />
			<h1><?php echo $label['index']['title'] ?></h1>
			<br />
			<br />
			<div class="quicky">
				<h2><?php echo $label['index']['insertNewScores'] ?></h2>
				<form id="insertNewScores" name="insertNewScores" method="get" action="insertNewScores.php">
					<select id="player1" name="player1" autofocus >
<?php 
	foreach ($players as $player) {
?>
						<option value ="<?php echo $player->getId() ?>"><?php echo $player->getName() ?></option>
<?php 
	}
?>
					</select>
					<select id="player2" name="player2">
<?php 
	foreach ($players as $player) {
?>
						<option value ="<?php echo $player->getId() ?>"><?php echo $player->getName() ?></option>
<?php 
	}
?>
					</select>
					<br />
					<select id="score1" name="score1">
<?php 
	for ($i=0;$i<10;$i++) {
?>
						<option value ="<?php echo $i ?>"><?php echo $i ?></option>
<?php 
	}
?>
					</select>
					<select id="score2" name="score2">
<?php 
	for ($i=0;$i<10;$i++) {
?>
						<option value ="<?php echo $i ?>"><?php echo $i ?></option>
<?php 
	}
?>
					</select>
					<br />
					<input type="submit" value="<?php echo $label['index']['submit'] ?>">
				</form>
			</div>
			<br />
			<br />
			<div class="quicky">
				<h2><?php echo $label['index']['insertNewPlayers'] ?></h2>
				<form id="insertNewPlayers" name="insertNewPlayers" method="get" action="insertNewPlayers.php">
					<input id="insertNewPlayers_name" name="name" type="text">
					<br />
					<input type="submit" value="<?php echo $label['index']['submit'] ?>">
				</form>
			</div>
		</div>
	</body>

</html>