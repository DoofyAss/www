<?php

	function view($path) {

		return new VIEW($path);
	}



	class VIEW {

		const incl = '/{[\s]*include:[\s]*([\w\/]+)[\s]*}/s';
		const each = '/{[\s]*each:[\s]*(\w+)[\s]*{[\s]*(.*?)[\s]*}}/s';
		const vars = '/{[\s]*([\w\->]+)[\s]*}/s';



		public $view;

		function __construct($path) {

			$this->view = $this->load($path);
		}










		function load($path) {

			$file = __DIR__. '/../view/'. $path.
			((@end(explode('/', $path))) ? null : 'index'). '.v';

			return is_file($file) ?
			file_get_contents($file) : null;
		}










		function incl($subject) {

			if ($int = preg_match_all(self::incl, $subject, $m)) {

				for ($i=0; $i<$int; $i++) {

					$subject = str_replace($m[0][$i],
					$this->load($m[1][$i]), $subject);
				}
			}

			return $subject;
		}










		function each($subject) {

			if ($int = preg_match_all(self::each, $subject, $m)) {

				for ($i=0; $i<$int; $i++) {

					$content = '';

					if ($array = $this->{$m[1][$i]})
					foreach (array_keys($array) as $key) {

						$this->key = $key;
						$content .= $this->variables($m[2][$i]);
					}

					$subject = str_replace($m[0][$i], $content, $subject);
				}
			}

			return $subject;
		}










		function variables($subject) {

			if ($int = preg_match_all(self::vars, $subject, $m)) {

				for ($i=0; $i<$int; $i++) {

					$subject = str_replace($m[0][$i],
					$this->variable($m[1][$i]), $subject);
				}
			}

			return $subject;
		}










		function variable($var) {

			list($variable, $object) =

			count($var = explode('->', $var)) == 2 ?
			[$var[1], $var[0]] : [$var[0], null];

			return

			// each object
			$this->{$object}[$this->key]->{$variable} ??

			// each array
			$this->{$object}[$this->key][$variable] ??

			// object
			$this->{$object}->{$variable} ??

			// array
			$this->{$object}  [$variable] ??

			// variable
			$this->{$variable} ??

			($object ?
				"[ undefined: $object->$variable ]" :
				"[ undefined: $variable ]"
			);
		}










		function render() {

			$this->view = $this->incl($this->view);

			// conditions

			$this->view = $this->each($this->view);
			$this->view = $this->variables($this->view);

			echo $this->view;
		}
	}

?>
