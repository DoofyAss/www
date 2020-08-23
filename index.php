<?php

	cookie('token', 'qeqqe'); // temp auth



	// temp Request

	if (isset($_POST['sakmadik'])) {

		http_response_code(200);
		echo 'sakmadik';

		// http_response_code(400);

		exit();
	}



	// Main

	Route()->get(function() {

		view()->render();
	});

?>
