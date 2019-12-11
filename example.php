<?php

	$data = DB('table')
	->where('column', 'row')
	->and('column', 'row')
	->or('column', 'row')
	->get();



	$user = DB('user')
	->where('id', 1)
	->get();

	echo $user->name;



	DB('nodes')
	->limit(10)
	->order('id', true)
	->each(function($node) {
		echo $node->content;
	});
?>
