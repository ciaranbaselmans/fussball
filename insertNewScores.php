<?php 
	require_once 'classes/DBConnector.php';
	require_once 'classes/Player.php';
	require_once 'classes/Match.php';
	require_once 'conf/settings.php';
	
	$msg = $label['insertNewScores']['done'];
	
	if (strcmp(trim($_GET["player1"]), trim($_GET["player2"]))==0) {
		$msg = $label['insertNewScores']['error_player_same'];
	} else {
		$mysqldate = date("Y-m-d H:i:s");
		
		$score = new Match(0, $_GET["player1"], $_GET["player2"], $_GET["score1"], $_GET["score2"], $mysqldate);
		
		$score->saveOrUpdate();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $label['insertNewScores']['title'] ?></title>
		<script type="text/javascript">
			location.href = "index.php";
		</script>
	</head>
	<body>
		<?php echo $msg ?><br />
		<a href="index.php"><?php echo $label['insertNewScores']['gohome'] ?></a>
	</body>
</html>