<?php


	/*
		SELECT
	*/

	// SELECT * FROM user WHERE id = 1
	$user = DB('user', 1)->get();			// stdClass (*)

	$user = DB('user', 1)->get('id', 'name');	// stdClass (id, name)
	echo $user->id;
	echo $user->name;

	echo DB('user', 1)->get('name');		// string

	// SELECT * FROM user WHERE id = 1
	$user = DB('user')
	->where('id', 1)
	->get();

	// SELECT * FROM user WHERE name = 'Admin'
	$user = DB('user', 'name', 'Admin')->get();










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

	// SELECT * FROM user WHERE name LIKE '%Us%'
	DB('user')
	->like('name', 'Us')
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
	DB('user')
	->where('id', 1)->or('login', 'admin')
	->update('name', 'Admin');

	// UPDATE user SET name = 'User' WHERE id = 2 AND id = 3
	DB('user')
	->where('id', 2)->and('id', 3)
	->update('name', 'User');










	/*
		INSERT
	*/

	// INSERT INTO user (login, password) VALUES ('user', 'PaSSwoRD')
	$data = [
		// column => value,
		'login' => 'user',
		'password' => 'PaSSwoRD'
	];

	DB('user')->insert($data);










	/*
		DELETE
	*/

	// DELETE FROM user WHERE id = 1
	DB('user', 1)->delete();

	// DELETE FROM user WHERE login LIKE '%user%'
	DB('user')
	->like('login', 'user')
	->delete();
?>
