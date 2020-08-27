<?php

	cookie('token', 'qeqqe'); // temp auth



	/*
		Route
	*/

	// Main

	Route()->get(function() {

		// echo $hash = hash_file('crc32b', __ROOT__."/README.md" );

		/*$v = view();

		$v->upload = true;
		$v->file = [
			(object) ['name' => 'document.xlsx'],
			(object) ['name' => 'документ.docx']
		];

		$v->render();*/

		view('file/')->render();
	});



	/*
		Request
	*/

	Request('file@upload')
	->get(function($data) {

		echo $data->this;
	});

	Request('time')
	->get(function() {

		echo time();
	});

	// test

	Request('test')
	->get(fn() => 'ok');

?>
