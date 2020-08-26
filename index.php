<?php

	cookie('token', 'qeqqe'); // temp auth



	/*
		Route
	*/

	// Main

	Route()->get(function() {

		// echo $hash = hash_file('crc32b', __ROOT__."/README.md" );

		$v = view();

		$v->upload = true;
		$v->file = [
			(object) ['name' => 'document.xlsx'],
			(object) ['name' => 'документ.docx']
		];

		$v->render();
	});



	/*
		Request
	*/

	// test

	Request('test')
	->get(fn() => 'ok');

?>
