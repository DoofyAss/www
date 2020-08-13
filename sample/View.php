<?php

	// create view
	$v = view('template');



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



	/*
		each
		html example
	*/

	{ each: object {
		<div>{ object->name }</div>
	}}



	/*
		include view
		html example
	*/

	{ include: view }

?>
