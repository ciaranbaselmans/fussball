<?php
	require_once 'lang/eng_UK.php';
	//change settings to suit your needs
	$dbConnection["host"]		= "localhost";
	$dbConnection["username"]	= "---";
	$dbConnection["password"]	= "---";
	$dbConnection["dbName"]		= "fussball";
	
	$refTimeWindowWhereClause	= " `fixture` >= DATE_SUB(NOW(), INTERVAL 1 MONTH) ";
?>