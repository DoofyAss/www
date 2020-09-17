<?php

	const user = 'user';
	const role = 'role';

	// USER::init();
	// ROLE::init();










	function User($id = null) {

		global $user;

		return $user[$id] = $user[$id] ??
		new USER($id ? DB(user, $id)->get() : null);
	}










	class USER {

		public $id;
		public $login;
		public $password;
		public $mail;
		public $name;
		public $role;
		public $date;

		function __construct($data) {

			// if user not exist - don't eat cookie
			if (!is_bool($data)) {

				$data = $data ?? !cookie('token') ?:
				DB(user, 'token', cookie('token'))->get();
			}

			assignClassData($this, $data);
		}










		function Authorized() {

			if (!$this->id) {

				http_response_code(401);
				exit ( 'Unauthorized' );
			}

			return $this->id;
		}










		function Role($array = null) {

			return is_array($array) ?

			// update data
			DB(user, $this->id)
			->update('role', $this->role = nullstr(implode(', ', $array))) :

			// return array
			array_filter(array_map('intval', explode(', ', $this->role)));
		}



		function addRole($id) {

			$array = $this->Role();

			if ( in_array($id, $array) ) return false;

			array_push($array, $id);
			asort($array);

			return $this->Role($array);
		}



		function removeRole($id) {

			$array = $this->Role();

			if ( !in_array($id, $array) ) return false;

			$array = array_diff($array, [$id]);
			return $this->Role($array);
		}



		function has($permission) {

			foreach (array_map(fn($id) =>
			Role($id)->permission, $this->Role()) as $p) {

				if ($p & $permission || $p & 1) // 1: root
				return true;
			}

			return false;
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

		const ROOT = 0x00000001;

		const MANAGE_CONTENT = 0x00000010;
		const MANAGE_YOUR_ASS = 0x00000020;
	}










	function Role($id = null) {

		global $role;

		if (!$role) {

			DB(role)->each(function($data) use (&$role) {
				$role[$data->id] = new ROLE($data);
			});
		}



		$idByName = function($id, $role) {

			$i = array_search($id, array_map(fn($r) => $r->name, $role));
			return $id ? $i ? $role[$i] : null : $role;
		};



		return

		$role[$id] ?? $idByName($id, $role) ??
		new ROLE( (object)['name' => $id] );
	}










	class ROLE {

		public $id;
		public $name;
		public $permission;
		public $description;
		public $color;

		function __construct($data) {

			assignClassData($this, $data);
		}










		function create() {

			$result = DB(role)
			->insert([
				'name' => $this->name,
				'permission' => $this->permission,
				'description' => $this->description,
				'color' => $this->color
			]);

			globalUnset('role');
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



		function color($color) {

			$this->color = $color;
			return $this;
		}



		function update() {

			return

			DB(role)
			->where('id', $this->id)
			->update([
				'name' => $this->name,
				'permission' => $this->permission,
				'description' => $this->description,
				'color' => $this->color
			]);
		}



		function delete() {

			DB(user)
			->order('role')
			->like('role', $this->id)
			->each(function ($user) {
				User($user->id)->removeRole($this->id);
			});

			DB(role)
			->where('id', $this->id)
			->delete();

			globalUnset('role');
		}



		static function init() {

			DB(role)
			->drop();



			DB(role)
				->id()
				->var('name')->unique()
				->int('permission')->null()
				->var('description')->null()
				->var('color')->null()
			->create();



			DB(role)
			->insert([
				'name' => 'root',
				'permission' => 0x00000001
			]);



			DB(user)->update('role', null);
			DB(user, 1)->update('role', 1);
		}
	}
?>
