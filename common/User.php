<?php

	const user = 'user';
	const role = 'role';

	// USER::init();
	// ROLE::init();










	function User($id = null) {

		global $user;

		return $user[$id] = $user[$id] ?? new USER(
			$id ? DB(user, $id)->get() : null
		);
	}










	class USER {

		public $id;
		public $login;
		public $password;
		public $mail;
		public $name;
		public $role;
		public $date;



		private $data;

		function __construct($data) {

			$this->data = $data ?? (cookie('token') ?
				DB(user, 'token', cookie('token'))->get() : null
			);

			eachPublic($this, function($key) {

				$this->$key = $this->data->$key ?? null;
			});
		}










		function Role($array = null) {

			if ( is_array($array) ) {

				$role = $this->role = ($array ? implode(', ', $array) : null);

				return DB(user, $this->id)
				->update('role', $role);

			} else {

				$role = ($this->role ? explode(', ', $this->role) : []);

				return array_map('intval', $role);
			}
		}


		function addRole($id) {

			$id = is_numeric($id) ? $id : Role($id)->id;

			$array = $this->Role();

			if ( in_array($id, $array) ) return false;

			array_push($array, $id);
			asort($array);
			return $this->Role($array);
		}


		function removeRole($id) {

			$id = is_numeric($id) ? $id : Role($id)->id;

			$array = $this->Role();

			if ( !in_array($id, $array) ) return false;

			$array = array_diff($array, [$id]);
			return $this->Role($array);
		}










		static function init() {

			DB(user)
			->drop();



			DB(user)
				->id()
				->var('login')->unique()
				->var('password')
				->var('mail')->null()
				->var('name')->null()
				->var('role')->null()
				->int('date')->null()
				->var('token')->null()
			->create();



			DB(user)
			->insert([
				'login' => 'Admin',
				'password' => secret('admin'),
				'mail' => 'mr.black.developer@gmail.com',
				'name' => 'Администратор',
				'date' => time(),
				'token' => 'qeqqe'
			]);
		}
	}










	class PERMISSION {

		public $ROOT = 0x00000001;

		public $ADD = 0x00000002;
		public $EDIT = 0x00000004;
		public $DELETE = 0x00000008;
	}










	function Role($id = null) {

		global $role;



		$role ?: DB(role)->each(function ($r) use (&$role) {

			$role[$r->id] = new ROLE($r);
		});



		$i = is_numeric($id) ? $id : array_search($id,
		array_map(function($r) { return $r->name; }, $role));

		return $role[$i] ?? (func_num_args() ?
			new ROLE( (object)['name' => $id] ) :
		$role);
	}










	class ROLE {

		public $id;
		public $name;
		public $permission;
		public $description;



		private $data;

		function __construct($data) {

			$this->data = $data ?? null;

			eachPublic($this, function($key) {
				$this->$key = $this->data->$key ?? null;
			});
		}



		function create() {

			$result = DB(role)
			->insert([
				'name' => $this->name,
				'permission' => $this->permission,
				'description' => $this->description
			]);

			unset($GLOBALS['role']);
			return $result;
		}



		function name($name) {

			$this->name = $name;
			return $this;
		}



		function permission($permission) {

			$this->permission = $permission;
			return $this;
		}



		function description($description) {

			$this->description = $description;
			return $this;
		}



		function update() {

			return

			DB(role)
			->where('id', $this->id)
			->update([
				'name' => $this->name,
				'permission' => $this->permission,
				'description' => $this->description
			]);
		}



		function delete() {

			DB(user)
			->order('role')
			->like('role', $this->id)
			->each(function ($user) {
				User($user->id)->removeRole($this->id);
			});

			$result = DB(role)
			->where('id', $this->id)
			->delete();

			unset($GLOBALS['role']);
			return $result; // true always
		}



		static function init() {

			DB(role)
			->drop();



			DB(role)
				->id()
				->var('name')->unique()
				->int('permission')
				->var('description')->null()
			->create();



			DB(role)
			->insert([
				'name' => 'root',
				'permission' => 0x00000001
			]);



			DB(user)
			->like('role', '')
			->update('role', null);

			DB(user, 1)->update('role', 1);
		}
	}
?>
