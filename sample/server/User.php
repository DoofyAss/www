<?php

	/*
		USER
	*/

	// return id or exit 401
	User()->Authorized();

	// add role
	User()->addRole(1); // by id

	// remove role
	User()->removeRole(1); // by id

	// condition user has permission
	User()->has(PERMISSION::ROOT); // true / false

	// get roles
	User()->Role(); // array id's

	// update role id to 1 and 2
	User()->Role([1, 2]);










	/*
		ROLE
	*/

	// get all roles
	Role(); // array

	// create
	Role('Admin')->create();

	// delete
	Role(1)->delete(); // by id
	Role('Admin')->delete(); // by name

	// update
	Role('Admin')
		->name('User') // rename Admin to User
		->permission(0x00000002)
		->description('User')
	->update();

?>
