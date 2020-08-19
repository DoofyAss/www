<?php

	define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

	set_include_path(__ROOT__.'/system/');
	include_once 'index.php';

	cookie('token', 'qeqqe'); // temp auth



	// Main

	Route()->get(function() {

		view()->render();
	});



	// User

	Route('/[user]')
	->get(function($login) {

		echo ($user = DB('user', 'login', $login)->get()) ?
		$user->name : NotFound();
	});



	NotFound();

?>
