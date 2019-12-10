<?php

	// error_reporting(0);

	header('Content-type: text/html; charset=utf-8');
	date_default_timezone_set('Etc/GMT-11');










	$db = new PDO('mysql:host=127.0.0.1;dbname=data', 'root', null, array(
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	));

	$db->exec("SET NAMES utf8");










	function DB($table) {

		return new DB($table);
	}

	class DB {

		private $table;
		private $query;
		private $where;

		function __construct($table) {
			$this->table = $table;
		}

		function SQL() {
			return $this->query. $this->where;
		}



		function where($key, $value) {
			$this->where = " WHERE $key = '$value'";
			return $this;
		}



		function get(...$column) {

			$column = $column ? implode(', ', $column) : '*';
			$this->query = "SELECT $column FROM $this->table";

			global $db;
			return $db->query( $this->SQL() )->fetch();
		}
	}

	$user = DB('user')
	->where('id', 1)
	->get();

	echo $user->name;

	// DB::QUERY("INSERT INTO user (login, password) VALUES ('Пользователь', 'qweqwe')");










	// INIT::USER();

	class INIT extends DB {

		static function USER() {

			SELF::QUERY("
				CREATE TABLE IF NOT EXISTS user (
					id INT(16) NOT NULL AUTO_INCREMENT,
					login VARCHAR(64) NOT NULL,
					password VARCHAR(64) NOT NULL,
					mail VARCHAR(64),
					name VARCHAR(64),

					permission INT(1) DEFAULT NULL,
					token VARCHAR(64) DEFAULT NULL,
				PRIMARY KEY (`id`)) ENGINE = MyISAM;
			");
		}
	}

?>
