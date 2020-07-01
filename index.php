<?php

	set_include_path($_SERVER['DOCUMENT_ROOT'].PATH_SEPARATOR);
	include_once 'common.php';

	DB('user')

	->error(function ($message) {
		echo $message; // Base table or view not found
	})

	->each(function ($user) {
		echo '<br>'. $user->login;
	});

?>
