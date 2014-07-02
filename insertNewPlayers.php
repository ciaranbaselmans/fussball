<?php 
	require_once 'classes/DBConnector.php';
	require_once 'classes/Player.php';
	require_once 'conf/settings.php';
	
	if (isset($_GET['name']) && strcmp("", trim($_GET['name']))!=0) {
		$name = trim($_GET['name']);
		
		$name = mysqli_real_escape_string(DBConnector::getConn(), $name);
		
		$player = new Player(0, $name);
		
		$player->saveOrUpdate();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $label['insertNewPlayers']['title'] ?></title>
		<script type="text/javascript">
			location.href = "index.php";
		</script>
	</head>
	<body>
		<?php echo $label['insertNewPlayers']['done'] ?><br />
		<a href="index.php"><?php echo $label['insertNewPlayers']['gohome'] ?></a>
	</body>
</html>