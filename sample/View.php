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
		condition
	*/

	$v->bool = true;

	// v
	{ bool ? true : false }



	/*
		each array
	*/

	$v->array = ['key' => 'array var'];

	// v
	{ array: <div>{ array[key] }</div> }



	/*
		each object
	*/

	$v->object = [
		(object) ['key' => 'object var 0'],
		(object) ['key' => 'object var 1']
	];

	// v
	{ object: <div>{ object->key }</div> }



	/*
		variable
	*/

	$v->variable = 'var';

	// v
	{ variable }



	// render
	$v->render();

?>
