<?php

	function view($path = '') {

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










		function logic($s, $recursion = false) {



			$regEx = ! $recursion ?
			[ '/({(?:[^{}]|(?1))*})/' ] :
			[
				'condition' => '/^\s*{\s*(\w+)\s*\?\s*(.*?)(?:\s*:\s*([{"\'][^{}"\']*[}"\']|\S+))?\s*}\s*$/us',
				'each' => '/{\s*(\w+)\s*:\s*(.*)}/us',
				'include' => '/{\s*include\s+([\/\w]+)\s*}/us',

				'variable' => '/{\s*(\w+)\s*}/us',
				'object' => '/{\s*(\w*)(?:[^\-\>]|->(\w*))?\s*}/us',
				'array' => '/{\s*(\w*)(?:\[[^\[\]]*|\[(.*)\])\s*}/us'
			];



			foreach (array_values($regEx) as $index => $r) {

				if ($count = preg_match_all($r, $s, $m)) {

					for ($i=0; $i<$count; $i++) {

						if ($recursion) {

							$handler = array_keys($regEx)[$index];

							$s = str_replace($m[0][$i],
							$this->{$handler}($m, $i), $s);

							$s = $this->logic($s, true);

						} else {

							$s = str_replace($m[0][$i],
							$this->logic($m[1][$i], true), $s);
						}

					}
				}
			}

			return $s;
		}










		function condition($m, $i) {

			return $this->{$m[1][$i]} ?
			$m[2][$i] : $m[3][$i] ?? null;
		}










		function include($m, $i) {

			return $this->logic( $this->load($m[1][$i]) );
		}










		function each($m, $i) {

			$content = '';

			if (is_array($array = $this->{$m[1][$i]}))
			foreach (array_keys($array) as $index) {

				$this->index = $index;
				$content .= $this->logic($m[2][$i]);
			}

			return $content;
		}










		function object($m, $i) {

			return
			$this->{$m[1][$i]}->{$m[2][$i]} ?? // object
			$this->{$m[1][$i]}[$this->index]->{$m[2][$i]} ?? // array object
			"({$m[1][$i]}->{$m[2][$i]} : undefined);";
		}

		function array($m, $i) {

			return $this->{$m[1][$i]}[$this->index][$m[2][$i]] ??
			"({$m[1][$i]}[{$m[2][$i]}] : undefined);";
		}

		function variable($m, $i) {

			return $this->{$m[1][$i]} ??
			"({$m[1][$i]} : undefined);";
		}










		function render() {

			echo $this->view =
			$this->logic($this->view);
		}
	}

?>
