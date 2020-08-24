<?php

	cookie('token', 'qeqqe'); // temp auth



	/*
		Route
	*/

	// Main

	Route()->get(function() {

		view()->render();
	});



	/*
		Request
	*/

	// test

	Request('test')
	->get(fn() => 'ok');

?>
