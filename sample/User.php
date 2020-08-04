<?php

	/*
		USER
	*/

	// role
	User()->addRole(1); // by id or name
	User()->removeRole('Admin'); // by id or name

	// user id 1 get roles
	User(1)->Role(); // array ids

	// user id 1 set roles id 1 and 2
	User(1)->Role([1, 2]);










	/*
		ROLE
	*/

	// get all roles
	Role();

	// create
	Role('Admin')
		->permission(0x00000001)
	->create();

	// update
	Role('Admin')
		->name('User') // rename Admin to User
		->permission(0x00000002)
		->description('User')
	->update();

	// delete
	Role(1)->delete(); // by id
	Role('Admin')->delete(); // by name

?>
