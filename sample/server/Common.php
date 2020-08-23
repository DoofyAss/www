<?php

	/*
		COOKIE
	*/

	// get
	cookie('key');

	// set
	cookie('key', 'value');

	// remove
	cookie('key', null);










	/*
		CRYPT
	*/

	// generate hash
	$hash = secret('paSSword');

	// string to hash match
	secret('paSSword', $hash); // true / false










	/*
		BITMASK
	*/
	
	// array [16, 32]
	$array = bitmask(48);

	// int 48
	$int = bitmask([16, 32]);

?>
