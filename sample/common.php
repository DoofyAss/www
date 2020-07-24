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
		Crypt
	*/

	// generate hash
	$hash = secret('paSSword');

	// string to hash match
	echo secret('paSSword', $hash) ? 'valid' : 'invalid';

?>
