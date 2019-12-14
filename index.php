<?php

	set_include_path($_SERVER['DOCUMENT_ROOT'].PATH_SEPARATOR);
	include_once 'common.php';



	/*
	DB('user')
	->where('id', 1)
	->update('name', 'Admin')
	->where('id', 2)->and('id', 3)
	->update('name', 'User');
	*/



	// $user = DB('user', 'name', 'Admin');
	// $user = DB('user', 'id', 1);
	$user = DB('user', 1);
	// $user = DB('user')->where('id', 1)->get();
	echo "<br>". $user->name;



	DB('user')->each(function ($user) {
		echo "<br>". $user->login. ", ". $user->name;
	});
?>
