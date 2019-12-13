<?php

	set_include_path($_SERVER['DOCUMENT_ROOT'].PATH_SEPARATOR);
	include_once 'common.php';

	// DB('user')
	// ->where('id', 1)
	// ->update('name', 'Admin');

	DB('user')->each(function ($user) {
		echo "<br>". $user->login. ", ". $user->name;
	});
?>
