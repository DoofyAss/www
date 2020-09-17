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

		$v = view('file/upload');
		$v->file = [];

		foreach ($data as $file) {

			array_push($v->file, (object) [
				'id' => $file->id,
				'name' => pathinfo($file->name, PATHINFO_FILENAME),
				'ext' => pathinfo($file->name, PATHINFO_EXTENSION),
				'size' => $file->size
			]);
		}

		$v->render();

	});










	/*
		Content
	*/

	Request('content')->use('text', 'file')
	->get(function($data) {



		//



		// echo $id = $data->this ? 'update' : 'insert';

		// DB('content')->insert(['text' => $data->text]);

		// global $db;
		// echo $db->lastInsertId();
	});



	function initContent() {

		DB('content')
			->id()
			->var('text')
		->create();
	}






	// test

	Request('test')
	->get(fn() => 'ok');

?>
