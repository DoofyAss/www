<?php

	/*
		direct route
	*/

	// domain/user

	Route('/user')
	->get(function() { ... });



	/*
		string
	*/

	// domain/user/admin

	Route('/user/[name]')
	->get(function($name) { ... });



	/*
		numeric
	*/

	// domain/user/1

	Route('/user/(id)')
	->get(function($id) { ... });



	/*
		any type
	*/

	// domain/direct/1
	// domain/direct/name

	Route('/direct/{any}')
	->get(function($any) { ... });

?>
