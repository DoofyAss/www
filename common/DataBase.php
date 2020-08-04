<?php

	$db = new PDO('mysql:host=127.0.0.1;dbname=data', 'root', null, [
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
	]);

	// $db->exec("SET NAMES UTF8");










	function DB($table, ...$arg) {

		return

		count($arg) == 2 ?
		(new DB($table))->where($arg[0], $arg[1]) :

		(
			count($arg) == 1 ?
			(new DB($table))->where('id', $arg[0]) : new DB($table)
		);
	}










	class DB {

		private $table;
		private $query;
		private $where;
		private $order;
		private $limit;

		private $error;

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










		function error($function) {

			$this->error = $function;
			return $this;
		}










		function query($SQL) {

			global $db;

			try {

				return $db->query($SQL);

			} catch (PDOException $e) {

				if (isset($this->error))
				call_user_func ($this->error, $e->getMessage());

				return false;
			}

		}










		function where($key, $value, $where = 'WHERE') {

			if ($where == 'WHERE') $this->where = null;

			$this->where .= " $where $key".
			(gettype($value) == 'NULL' ? ' IS ' : ' = ').
			$this->type($value);

			return $this;
		}

		function like($key, $value) {

			$this->where = " WHERE $key LIKE '%$value%'";
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

			$this->order = " ORDER BY $key ". ($sort ? 'ASC' : 'DESC');
			return $this;
		}










		function get(...$arg) {

			$column = $arg ? implode(', ', $arg) : '*';
			$this->query = "SELECT $column FROM $this->table";

			// echo '<br>'. $this->SQL(); // debug

			global $db;
			$result = $db->query( $this->SQL() )->fetch();
			return count($arg) == 1 ? $result->$column : $result;
		}










		function count() {

			$this->query = "SELECT * FROM $this->table";

			global $db;
			return $db->query( $this->SQL() )->rowCount();
		}










		function each($function) {

			$this->query = "SELECT * FROM $this->table";

			// echo '<br>'. $this->SQL(); // debug

			foreach ($this->query( $this->SQL() )->fetchAll() as $key => $row) {
				// $function($row);
				call_user_func ($function, $row, $key);
			}

			return $this;
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

			// echo '<br>'. $this->SQL(); // debug

			return $this->query( $this->SQL() );
		}










		function insert($data) {

			foreach($data as $key => $value) {

				$data[$key] = $this->type($value);
			}

			$column = implode(', ', array_keys($data));
			$values = implode(', ', array_values($data));

			$this->query = "INSERT INTO $this->table ($column) VALUES ($values)";

			// echo '<br>'. $this->SQL(); // debug

			return $this->query( $this->SQL() );
		}










		function delete($alter = true) {

			$this->query = "DELETE FROM $this->table";

			$result = $this->query( $this->SQL() );

			if ($alter)
			$this->query("ALTER TABLE $this->table AUTO_INCREMENT = 1;");

			// echo '<br>'. $this->SQL(); // debug

			return $result;
		}










		private $create = [];
		private $column;

		private $id;
		private $null;
		private $unique;
		private $collate;
		private $increment;



		function column() {

			if ($this->column) {

				array_push($this->create,
					$this->column.
					($this->null ? ' DEFAULT NULL' : ' NOT NULL').
					($this->unique ? ' UNIQUE' : '').
					($this->collate ? ' COLLATE utf8_general_ci' : '').
					($this->increment ? ' AUTO_INCREMENT' : '')
				);
			}

			$this->null = false;
			$this->unique = false;
			$this->collate = false;
			$this->increment = false;
		}

		function null() {

			$this->null = true;
			return $this;
		}

		function unique() {

			$this->unique = true;
			return $this;
		}

		function id() {

			$this->id = ", PRIMARY KEY (`id`)";
			$this->column = "id INT(16)";
			$this->increment = true;
			return $this;
		}

		function int($column) {

			$this->column();
			$this->column = "{$column} INT(16)";
			return $this;
		}

		function var($column) {

			$this->column();
			$this->collate = true;
			$this->column = "{$column} VARCHAR(128)";
			return $this;
		}

		function str($column) {

			$this->column();
			$this->collate = true;
			$this->column = "{$column} TEXT";
			return $this;
		}

		function create() {

			$this->column();
			$this->create = implode($this->create, ",\n");

			return $this->query("
				CREATE TABLE {$this->table} (
					{$this->create}
				{$this->id}) ENGINE = MyISAM;
			");
		}










		function drop() {

			return $this->query("DROP TABLE {$this->table}");
		}
	}

?>
