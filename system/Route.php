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










	function Request($key) {

		return new REQUEST($key);
	}



	class REQUEST {

		private $request;

		function __construct($key) {

			$this->request = $key == key($_POST);

			$this->data = new stdClass();
			$this->data->this = $_POST[$key] ?? null;
		}



		function use(...$data) {

			if ($this->request) {

				foreach ($data as $key) {

					$this->data->{$key} = $_POST[$key] ?? BadRequest();
				}
			}

			return $this;
		}



		function get($function) {

			if ($this->request)
			exit (call_user_func($function, $this->data));
		}
	}










	include_once __ROOT__.'/index.php';



	NotFound();



	function NotFound() {

		if (!empty($_POST)) BadRequest();

		http_response_code(404);
		exit ( view('404')->render() );
	}



	function BadRequest() {

		http_response_code(400);
		exit ('Bad Request');
	}

?>
