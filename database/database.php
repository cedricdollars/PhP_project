<?php 
	
	/**
	* DatabaseManager
	*/
	class DBManager
	{
		public $database;

		private $server;
		private $dbName;
		private $userName;
		private $password;

		public function set_server ($_server) {
			$this->server = $_server;
		}
		
		public function get_server () {
			return $this->server;
		}

		public function set_db_name ($_dbName) {
			$this->dbName = $_dbName;
		}

		public function get_db_name () {
			return $this->dbName;
		}

		public function set_user_name ($_userName) {
			$this->userName = $_userName;
		}
		
		public function get_user_name () {
			return $this->userName;
		}

		public function set_password ($_password) {
			$this->password = $_password;
		}

		public function get_password () {
			return $this->password;
		}

		function __construct()
		{
			$this->server   = "127.0.0.1";
			$this->dbName   = "";
			$this->userName = "root";
			$this->password = "";

		}

		public function connect($_server='127.0.0.1', $_dbName = '', $_userName = 'root', $_password='') {
			$this->server   = $_server;
			$this->dbName   = $_dbName;
			$this->userName = $_userName;
			$this->password = $_password;

			try {
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;

			 	$this->database = new PDO(
			 		'mysql:host='.$this->server.';dbname='.$this->dbName,
			 		$this->userName,
			 		$this->password,
			 		array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

			} catch (Exception $e) {
				$return = new stdClass();
				$return->status = "error";
				$return->message = "Erreur de connection à la base de données : ".$e->getMessage();
				die($return);
			}
		}

		public static function getConnection($_server='127.0.0.1', $_dbName = '', $_userName = 'root', $_password='') {
			$dbm = new DBManager();
			$dbm->connect($_server, $_dbName, $_userName, $_password);
			return $dbm->database;
		}
	}

 ?>