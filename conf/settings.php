<?php
	require_once 'lang/eng_UK.php';

	$dbConnection["host"]		= "localhost";
	$dbConnection["username"]	= "fussball";
	$dbConnection["password"]	= "lamaindedieu";
	$dbConnection["dbName"]		= "fussball";
	
	$refTimeWindowWhereClause	= " `fixture` >= DATE_SUB(NOW(), INTERVAL 1 MONTH) ";
?>