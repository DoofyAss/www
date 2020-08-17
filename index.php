<?php

	define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

	set_include_path(__ROOT__);
	include_once 'system/index.php';

	cookie('token', 'qeqqe'); // temp auth

	$v = view('/');
	$v->user = DB('user')->all();
	$v->render();

?>
