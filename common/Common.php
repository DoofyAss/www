<?php

	// error_reporting(0);

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
		CRYPT
	*/

	function secret($string, $hash = null) {

		$salt = 'sakmadik';

		return $hash ?

		password_verify($string. $salt, $hash) :
		password_hash($string. $salt, CRYPT_SHA256);
	}










	/*
		BITMASK
	*/

	function bitmask($data, $id = false) {

		$bitmask = null;

		if (gettype($data) == 'array') {

			foreach ($data as $i) {

				$bitmask |= ( $id ? pow(2, $i) : $i );
			}
		}

		elseif (gettype($data) == 'integer' || 'string') {

			$bitmask = [];

			for ($i=1; pow(2, $i) <= $data; $i++) {

				if (pow(2, $i) & $data)
				array_push($bitmask, ( $id ? $i : pow(2, $i) ));
			}
		}

		return $bitmask;
	}










	/*
		each class public variables
	*/

	function eachPublic($class, $function) {

		$refClass = new ReflectionClass($class);

		$props = array_map(function($array) {
			return $array->name;
		}, $refClass->getProperties(ReflectionProperty::IS_PUBLIC));

		foreach ($props as $key) {

			$function($key, $class->{$key});
		}
	}
?>
