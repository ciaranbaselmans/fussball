<?php 
	require_once 'conf/settings.php'; 
	class DBConnector  //makes the connection for all the logs
	{
		private static $host;
		private static $user;
		private static $pass;
		private static $db;
		private static $conn = null;
		
		private function __construct() {
			
		}
		
		public static function build() {
			global $dbConnection;
			static::$host = $dbConnection['host'];		
			static::$user = $dbConnection['username'];
			static::$pass = $dbConnection['password'];
			static::$db	  = $dbConnection['dbName'];
		}
		
		private static function init() {
			static::build();
			static::$conn = mysqli_connect(static::$host, static::$user, static::$pass, static::$db);
			if (mysqli_connect_errno(static::$conn)) {
				printf("Failed to connect to MySQL: " . mysqli_connect_error());
				die("Sorry, I'm dead.");
			}
		}
		
		public static function getConn() {
			if (isset(static::$conn))
				return static::$conn;
			else {
				static::init();
				return static::$conn;
			}
		}
	}
?>