<?php

	define('DIR', __ROOT__.'/file/');
	define('TMP', __ROOT__.'/file/tmp/');

	const file = 'file';

	// FILE::init();



	function F($id) {

		echo $id;
	}



	/*

	if ($_FILES) {

		$uploadedFile = $_FILES['file']['name'];
		$tempFile = $_FILES['file']['tmp_name'];
	}

	*/



	class FILE {



		function __construct() {

			//
		}



		static function init() {

			DB(file)->drop();

			DB(file)
				->id()
				->var('name')
				->var('extension')
				->int('size')
			->create();
		}
	}

?>
