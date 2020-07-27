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
	echo secret('paSSword', $hash) ? 'valid' : 'invalid';

?>
