<?php



	function Route($url = '/') {

		return new ROUTE($url);
	}



	class ROUTE {

		private $uri;
		private $url;

		function __construct($url) {

			$this->uri = explode('/', $_SERVER['REQUEST_URI']);
			$this->url = explode('/', $url);
		}










		function get($function) {

			if (!empty($_POST)) return;

			if (
				count($this->url) !=
				count($this->uri)
			) return;



			$arg = [];

			foreach ($this->url as $index => $url) {

				$uri = $this->uri[$index];

				if ($this->type($url, $uri)) {

					array_push($arg, $uri);

				} else {

					if ($url != $uri) return;
				}
			}



			http_response_code(200);
			exit (call_user_func_array($function, $arg));
		}










		function type($url, $uri) {

			$type = [
				'/\{(.*)\}/' => '/(\w+)/', // any
				'/\((.*)\)/' => '/(\d+)/', // int
				'/\[(.*)\]/' => '/(\D\w+)/'// str
			];

			foreach ($type as $l => $i) {

				if (preg_match($l, $url))
				if (preg_match($i, $uri))
				return true;
			}

			return false;
		}
	}










	include_once __ROOT__.'/index.php';

	NotFound();










	function NotFound() {

		http_response_code(404);

		if (!empty($_POST)) exit;
		exit ( view('404')->render() );
	}

?>
