<?php


	/*
		SELECT
	*/

	// SELECT * FROM user WHERE id = 1
	$user = DB('user', 1);

	// SELECT * FROM user WHERE id = 1
	$user = DB('user')
	->where('id', 1)
	->get();

	// SELECT * FROM user WHERE name = 'Admin'
	$user = DB('user', 'name', 'Admin');










	/*
		EACH
	*/

	// SELECT * FROM user
	DB('user')->each(function ($user) {
		echo '<br>'. $user->name;
	});

	// SELECT * FROM user ORDER BY id DESC LIMIT 10
	DB('user')
	->limit(10) // (0, 10)
	->order('id', true)
	->each(function ($user) { ... });










	/*
		UPDATE
	*/

	// UPDATE user SET login = 'admin', name = 'Admin' WHERE id = 1
	DB('user')
	->where('id', 1)
	->update([
		'login' => 'admin',
		'name' => 'Admin'
	]);

	// UPDATE user SET name = 'Admin' WHERE id = 1 OR login = 'admin'
	// UPDATE user SET name = 'User' WHERE id = 2 AND id = 3
	DB('user')
	->where('id', 1)->or('login', 'admin')
	->update('name', 'Admin')
	->where('id', 2)->and('id', 3)
	->update('name', 'User');
?>
