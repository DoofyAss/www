<?php

	// ROUTE - GET
	// REQUEST - POST



	ROUTE('/{name}')
	->GET(function($name) {

		$user = DB('user')
		->where('name', $name)
		->get();

		echo $user ? $user->id : NotFound();
	});

?>
