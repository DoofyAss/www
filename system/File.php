<?php

	define('DIR', __ROOT__.'/UserData/');

	const file = 'file';

	// FILE::init();










	if ( isset($_SERVER["CONTENT_LENGTH"]) ) {

		if ( $_SERVER["CONTENT_LENGTH"] >
		((int) ini_get('post_max_size') * 1024 * 1024)) {

			die ( http_response_code(413) );
		}
	}












	if ($_FILES) {



		User()->Authorized();



		$file = (object) $_FILES['file'];
		$modified = (double) $_POST['modified'];

		$max = 1024 * 1024 * min(

			(int) ini_get('post_max_size'),
			(int) ini_get('upload_max_filesize')
		);



		if ($file->size >= $max) NotAcceptable();

		try {

			$tmp = DIR.(User()->id).'/tmp/';

			@mkdir($tmp, 0777, true);

			if (!move_uploaded_file($file->tmp_name, $tmp.$modified))
			throw new Exception;

		} catch (Exception $e) { NotAcceptable(); }

		exit;
	}










	function F($id) {

		echo $id;
	}










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










	function NotAcceptable() {

		http_response_code(406);
		die ( 'Not Acceptable' );
	}

?>
