<?php

	cookie('token', 'qeqqe'); // temp auth



	/*
		Route
	*/

	// Main

	Route()->get(function() {

		view('file/')->render();
	});



	/*
		Request
	*/

	Request('file-upload')
	->get(function($data) {

		$data = json_decode($data->this);

		foreach ($data as $file) {

			$v = view('file/upload');

			$v->data = (object) [
				'id' => $file->id,
				'name' => pathinfo($file->name, PATHINFO_FILENAME),
				'ext' => pathinfo($file->name, PATHINFO_EXTENSION),
				'size' => $file->size
			];

			$v->render();
		}

	});

	// test

	Request('test')
	->get(fn() => 'ok');

?>
