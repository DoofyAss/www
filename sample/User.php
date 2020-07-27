<?php

	/*
		USER
	*/

	// get data authorized user
	USER()->name();

	// get data any user with id
	USER(1)->name();










	/*
		ROLE
	*/

	// create
	Role()
		->name('User')
		->permission(0x1 | 0x2)
		->description('qeqqe')
	->create();

	// update
	Role('Admin')
		->name('User')
		->permission(0x2)
		->description('qeqqe')
	->update();

	Role(1)->delete(); // by id
	Role('Admin')->delete(); // by name

?>
