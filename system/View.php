<?php

	function view($path) {

		return new VIEW($path);
	}



	class VIEW {

		public $view;

		function __construct($path) {

			$this->view = $this->load($path);
		}



		function load($path) {

			$file = __ROOT__. '/view/'. $path.
			((@end(explode('/', $path))) ? null : 'index'). '.v';

			return is_file($file) ?
			file_get_contents($file) : null;
		}






		function match($s, $recursion = false) {



			$reg = ! $recursion ?
			[ '/({(?:[^{}]|(?1))*})/' ] :
			[
				'log0' => '/{ \w (.+) }/s',
				'log1' => '/{ \w: (.+) }/s',
			];



			foreach (array_values($reg) as $key => $regex) {

				if ($int = preg_match_all($regex, $s, $m)) {

					for ($i=0; $i<$int; $i++) {

						if ($recursion) {

							$handler = array_keys($reg)[$key];

							$s = str_replace($m[0][$i],
							$this->{$handler}($m[1][$i]), $s);

							$s = $this->match($s, true);

						} else {

							$s = str_replace($m[0][$i],
							$this->match($m[1][$i], true), $s);
						}

					}
				}
			}

			return $s;
		}




		function log0($str) {

			echo 'log 0: '. $str. '<br>';

			return $str;
		}

		function log1($str) {

			echo 'log 1: '. $str. '<br>';

			return $str;
		}






		function render() {

			echo $this->view =
			$this->match($this->view);
		}
	}

?>
