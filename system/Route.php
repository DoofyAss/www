<?php

	set_include_path($_SERVER['DOCUMENT_ROOT'].PATH_SEPARATOR);
	include_once 'system/index.php';

	http_response_code(404);



	function ROUTE($url) {

		return new ROUTE($url);
	}

	class ROUTE {

		private $uri;
		private $url;

		function __construct($url) {

			$this->uri = explode('/', rtrim($_SERVER['REQUEST_URI'], '/'));
			$this->url = explode('/', $url);
		}










		function GET($function) {

			if (count($this->url) != count($this->uri)) return;

			$args = [];

			foreach ($this->url as $index => $url) {

				$uri = $this->uri[$index];

				if (SELF::inBraces($url, $uri)) {

					array_push($args, $uri);

				} else {

					if ($url != $uri) return;

				}
			}

			http_response_code(200);
			call_user_func_array($function, $args);
		}










		static private function inBraces($url, $uri) {

			foreach ([

				'/\{(.*)\}/',
				'/\[(.*)\]/'

			] as $index => $reg) {

				if (preg_match($reg, $url, $m)) {

					return $index ?
					(is_numeric($uri) ? true : false) :
					(!is_numeric($uri) ? true : false);
				}
			}
		}



		/*static private function removeBraces($uri) {

			return preg_split('/\{|\}|\[|\](.*)?/', $uri, -1, PREG_SPLIT_NO_EMPTY)[0];
		}*/
	}










	include_once 'Route.php';

	if (http_response_code() == 404) NotFound();

	function NotFound() {

		exit (include '404.php');
	}

?>
