<?php

	// get DataBase data and authorize user
	var_dump(USER()->name());

	// get DataBase data user id 2
	var_dump(USER(2)->name());

	// get exist data without DataBase request
	var_dump(USER()->name());
	var_dump(USER(2)->name());
	var_dump(USER()->name());
	var_dump(USER(2)->name());










	function USER($id = null) {

		global $user;
		if (isset($user[$id])) return $user[$id];

		return $user[$id] = new USER(
			$id ? DB('user', $id)->get() : null
		);
	}










	class USER {

		private $data;

		function __construct($data) {

			$this->data = $data ?? (cookie('token') ?
				DB('user', 'token', cookie('token'))->get() : null
			);
		}










		function name() {

			return $this->data->name ?? null;
		}
	}
?>
