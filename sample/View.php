<?php

	/*
		create view
	*/

	// view/file.v
	$v = view('file');

	// view/folder/index.v
	$v = view('folder/');

	// view/folder/file.v
	$v = view('folder/file');



	/*
		variables
	*/

	// { object->variable }
	$v->object->variable = 'object var';

	// { array->key }
	$v->array = ['key' => 'array var'];

	// { variable }
	$v->variable = 'var';

	// render
	$v->render();

?>
