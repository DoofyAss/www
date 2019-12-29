<?php

	/*
		/user		- direct route
		/{name}		- string
		/[id]		- integer, float
	*/



	// domain/user/Admin ( string )
	ROUTE('/user/{name}')
	->GET(function($name) {
		echo $name; // Admin
	});



	// domain/user/1 ( numeric )
	ROUTE('/user/[id]')
	->GET(function($id) {
		echo $id; // 1
	});



	// domain/Admin/page/32
	ROUTE('/{name}/page/[num]')
	->GET(function($name, $num) {

		echo $name; // Admin
		echo $num; // 32
	});

?>
