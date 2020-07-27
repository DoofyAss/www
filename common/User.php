<?php

	// USER::init();
	// ROLE::init();



	// eachPublic(new PERMISSION,
	// function($key, $value) {
	// 	// echo $key.': '.$value.'<br>';
	// 	global $perms;
	// 	$perms |= $value;
	//
	// });
	

	echo Role('Admin')->delete() ?
	'Роль Admin удалена' : 'Ошибка при удалении роли Admin';



	echo Role('Admin')
		->name('User')
		->permission(0x40 | 0x800)
		->description('qeqqe')
	->update() ?
	'роль обновлена' : 'ошибка обновления роли';



	echo Role()
		->name('Admin')
		->permission(0x40 | 0x800)
		->description('qeqqe')
	->create() ?
	'Роль Admin создана' : 'Ошибка при создании роли Admin';










	function User($id = null) {

		global $user;

		return $user[$id] = $user[$id] ?? new USER(
			$id ? DB('user', $id)->get() : null
		);
	}










	class USER {

		const table = 'user';



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
				DB(self::table, 'token', cookie('token'))->get() : null
			);

			eachPublic($this, function($key) {
				$this->$key = $this->data->$key ?? null;
			});
		}










		function role($set) {

			return true;
		}










		static function init() {

			DB(self::table)
			->drop();



			DB(self::table)
				->id()
				->var('login')->unique()
				->var('password')
				->var('mail')->null()
				->var('name')->null()
				->int('role')->null()
				->int('date')->null()
				->var('token')->null()
			->create();



			DB(self::table)
			->insert([
				'login' => 'Admin',
				'password' => secret('admin'),
				'mail' => 'mr.black.developer@gmail.com',
				'name' => 'Администратор',
				'role' => 1,
				'date' => time()
			]);
		}
	}










	class PERMISSION {

		public $ROOT = 0x00000001;
		public $ADD_CONTENT = 0x00000010;
		public $EDIT_CONTENT = 0x00000020;
		public $DELETE_CONTENT = 0x00000030;
	}










	function Role($id = null) {

		global $role;

		return $role[$id] = $role[$id] ?? new ROLE(
			$id ? DB('role', (is_numeric($id) ? 'id' : 'name'), $id)->get() : null
		);
	}










	class ROLE {

		const table = 'role';



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

			return

			DB(self::table)
			->insert([
				'name' => $this->name,
				'permission' => $this->permission,
				'description' => $this->description
			]);
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

			DB(self::table)
			->where('id', $this->id)
			->update([
				'name' => $this->name,
				'permission' => $this->permission,
				'description' => $this->description
			]);
		}



		function delete() {

			return // true always

			DB(self::table)
			->where('id', $this->id)
			->delete();
		}



		static function init() {

			DB(self::table)
			->drop();



			DB(self::table)
				->id()
				->var('name')->unique()
				->int('permission')
				->var('description')->null()
			->create();



			DB(self::table)
			->insert([
				'name' => 'root',
				'permission' => 1
			]);
		}
	}
?>
