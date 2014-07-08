<?php
	require_once 'lang/eng_UK.php';

	$dbConnection["host"]		= "localhost";
	$dbConnection["username"]	= "root";
	$dbConnection["password"]	= "Baselmans112";
	$dbConnection["dbName"]		= "fussball";
	
	$refTimeWindowWhereClause	= " `fixture` >= DATE_SUB(NOW(), INTERVAL 1 MONTH) ";
?>