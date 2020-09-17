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
		$id = (double) $_POST['id'];

		$max = 1024 * 1024 * min(

			(int) ini_get('post_max_size'),
			(int) ini_get('upload_max_filesize')
		);



		if ($file->size >= $max) NotAcceptable();

		try {

			$tmp = DIR.(User()->id).'/tmp/';

			@mkdir($tmp, 0777, true);

			if (!move_uploaded_file($file->tmp_name, $tmp.$id))
			throw new Exception;

		} catch (Exception $e) { NotAcceptable(); }

		sleep(2);

		exit;
	}










	function FS() {

		global $FS;
		return $FS = $FS ?? new FILE();
	}









	class FILE {



		public $tmp;



		function __construct() {

			$this->tmp = DIR. User()->Authorized(). '/tmp/';
		}



		function insert($data) {

			$data = [];

			if ($this->inTemporary($name)) {

				DB(file)->insert([

					'path' => $name,

				]);
			}
		}



		function inTemporary($name) {

			return file_exists($this->tmp.$name);
		}



		static function init() {

			DB(file)->drop();

			DB(file)
				->id()
				->var('path')
				->var('name')
				->var('extension')->null()
				->int('size')
				->int('downloads')->null()
			->create();
		}
	}










	function NotAcceptable() {

		http_response_code(406);
		die ( 'Not Acceptable' );
	}

?>
