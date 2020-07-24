<?php

	// USER::init();










	function User($id = null) {

		global $user;

		return $user[$id] = $user[$id] ?? new USER(
			$id ? DB('user', $id)->get() : null
		);
	}










	class USER {

		public $id;
		public $login;
		public $password;
		public $mail;
		public $name;
		public $permission;
		public $date;



		private $data;

		function __construct($data) {

			$this->data = $data ?? (cookie('token') ?
				DB('user', 'token', cookie('token'))->get() : null
			);

			listPublic($this, function($key) {
				$this->$key = $this->data->$key ?? null;
			});
		}









		static function init() {

			DB('user')->drop();



			DB('user')
				->id()
				->var('login')->unique()
				->var('password')

				->var('mail')->null()
				->var('name')->null()
				->int('permission')->null()
				->int('date')->null()

				->var('token')->null()
			->create();



			DB('user')
			->insert([
				'login' => 'Admin',
				'password' => secret('admin'),
				'mail' => 'mr.black.developer@gmail.com',
				'name' => 'Администратор',
				'permission' => 1,
				'date' => time()
			]);
		}
	}
?>
