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
		private $order;
		private $limit;

		function __construct($table) {

			$this->table = $table;
		}

		function SQL() {

			return
			$this->query.
			$this->where.
			$this->order.
			$this->limit;
		}










		function where($key, $value, $where = 'WHERE') {

			$this->where .= " $where $key = '$value'";
			return $this;
		}

		function and($key, $value) {

			return $this->where($key, $value, 'AND');
		}

		function or($key, $value) {

			return $this->where($key, $value, 'OR');
		}

		function limit($begin, $end = null) {

			$this->limit = " LIMIT ". (empty($end) ? "$begin" : "$begin, $end");
			return $this;
		}

		function order($key, $sort = null) {

			$this->order = " ORDER BY $key ". ($sort ? 'DESC' : 'ASC');
			return $this;
		}










		function query($SQL) {

			global $db;
			return $db->query($SQL);
		}

		function get(...$column) {

			$column = $column ? implode(', ', $column) : '*';
			$this->query = "SELECT $column FROM $this->table";

			// echo '<br>'. $this->SQL(); // Debug

			global $db;
			return $db->query( $this->SQL() )->fetch();
		}

		function each($function) {

			$this->query = "SELECT * FROM $this->table";

			// $result = $this->query($this->SQL());
			// while($row = $result->fetch()) { $function($row); }

			// echo '<br>'. $this->SQL(); // Debug

			foreach($this->query($this->SQL())->fetchAll() as $row) {
				$function($row);
			}
		}
	}










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
