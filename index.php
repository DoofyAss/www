<?php

	set_include_path($_SERVER['DOCUMENT_ROOT'].PATH_SEPARATOR);
	include_once 'system/index.php';

	cookie('token', 'qeqqe'); // temp auth

	$v = view('main');
	$v->user = DB('user')->all();
	$v->render();
?>
