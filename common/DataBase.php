<?php

	$db = new PDO('mysql:host=127.0.0.1;dbname=data', 'root', null, array(
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	));

	$db->exec("SET NAMES utf8");










	function DB($table, ...$arg) {

		return

		count($arg) == 2 ?
		(new DB($table))->where($arg[0], $arg[1])->get() :

		(
			count($arg) == 1 ?
			(new DB($table))->where('id', $arg[0])->get() : new DB($table)
		);
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

		function type($value) {

			switch (gettype($value)) {

				case 'integer':
					return $value;
				break;

				case 'string':
					return "'$value'";
				break;

				case 'NULL':
					return 'NULL';
				break;

				case 'boolean':
					return $value ? 'true' : 'false';
				break;
			}
		}










		function where($key, $value, $where = 'WHERE') {

			if ($where == 'WHERE') $this->where = null;

			$this->where .= " $where $key".
			(gettype($value) == 'NULL' ? ' IS ' : ' = ').
			$this->type($value);

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










		static function query($SQL) {

			global $db;
			return $db->query($SQL);
		}

		function get(...$column) {

			$column = $column ? implode(', ', $column) : '*';
			$this->query = "SELECT $column FROM $this->table";

			echo "<br>". $this->SQL(); // debug

			global $db;
			return $db->query( $this->SQL() )->fetch();
		}

		function each($function) {

			$this->query = "SELECT * FROM $this->table";

			foreach ($this->query( $this->SQL() )->fetchAll() as $row) {
				$function($row);
			}
		}

		function update() {

			if (gettype(func_get_arg(0)) == 'string') {

				$this->set = func_get_arg(0). " = ".
				$this->type( func_get_arg(1) );
			}

			if (gettype(func_get_arg(0)) == 'array') {

				$map = function ($key, $value) {
					return "$key = ". $this->type($value);
				};

				$this->set = implode(', ', array_map($map,
					array_keys( func_get_arg(0) ), func_get_arg(0))
				);
			}

			$this->query = "UPDATE $this->table SET $this->set";
			// echo "<br>". $this->SQL(); // debug

			$this->query( $this->SQL() );
			return $this;
		}
	}










	// INIT::USER();

	class INIT extends DB {

		static function USER() {

			SELF::query("
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
