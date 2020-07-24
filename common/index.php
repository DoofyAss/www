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










	/*
		Crypt
	*/

	function secret($string, $hash = null) {

		$salt = 'sakmadik';

		return $hash ?

		password_verify($string. $salt, $hash) :
		password_hash($string. $salt, CRYPT_SHA256);
	}










	/*
		list Public variables
	*/

	function listPublic($class, $function) {

		$class = new ReflectionClass($class);

		$props = array_map(function($array) {
			return $array->name;
		}, $class->getProperties(ReflectionProperty::IS_PUBLIC));

		foreach ($props as $key) { $function($key); }
	}
?>
