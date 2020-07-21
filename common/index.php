<?php

	// error_reporting(0);

	header('Content-type: text/html; charset=utf-8');
	date_default_timezone_set('Etc/GMT-11');

	set_include_path($_SERVER['DOCUMENT_ROOT'].PATH_SEPARATOR);
	include_once 'DataBase.php';
	include_once 'User.php';










	/*
		COOKIE
	*/

	function cookie($key, $value = null) {

		$time = isset($value) ? time() + 86400 : -1; // 24h

		return func_num_args() > 1 ?

		setcookie($key, $value, $time, '/') :
		($_COOKIE[$key] ?? null);
	}
?>
