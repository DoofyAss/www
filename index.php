<?php

	set_include_path($_SERVER['DOCUMENT_ROOT'].PATH_SEPARATOR);
	include_once 'common.php';

	DB('user')
	->where('id', 1)
	->update('name', 'User');
	// ->update(['login' => 'user', 'name' => 'User']);
?>
