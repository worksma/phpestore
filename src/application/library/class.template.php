<?PHP
	class Template {
		var $assets;
		var $templates;
		var $temp;
		var $template;
		var $elements;
		var $page_name;

		/*
			Легкий шаблонизатор, написанный на скорую руку.
		*/
		public function __construct($template = null) {
			if(empty($template)):
				$template = conf()->template;
			endif;

			$this->assets 		= $_SERVER['DOCUMENT_ROOT'] . "/public/templates/$template/assets/";
			$this->templates	= $_SERVER['DOCUMENT_ROOT'] . "/public/templates/$template/template/";
			$this->temp 		= "";
			$this->template 	= $template;
		}

		public function set_template($template = null) {
			if(empty($template)):
				$template = conf()->template;
			endif;

			$this->assets 		= $_SERVER['DOCUMENT_ROOT'] . "/public/templates/$template/assets/";
			$this->templates	= $_SERVER['DOCUMENT_ROOT'] . "/public/templates/$template/template/";
			$this->temp 		= "";
			$this->template = $template;
			
			return $this;
		}

		public function run() {
			if(!file_exists($this->templates . "sample.tpl")):
				exit("[Шаблонизатор: не найден файл: {$this->templates}sample.tpl]");
			else:
				$this->temp = file_get_contents($this->templates . "sample.tpl");
			endif;

			return $this;
		}

		public function title($name) {
			$this->page_name = $name;
			return $this;
		}

		public function get($file) {
			if(!file_exists($this->templates . $file . ".tpl")):
				return "[Шаблонизатор: не найден файл: {$this->templates}{$file}.tpl]";
			endif;

			return file_get_contents($this->templates . $file . ".tpl");
		}

		public function set($search, $replace, $subject = null) {
			if(isset($subject)):
				return str_replace($search, $replace, $subject);
			endif;

			$this->temp = str_replace($search, $replace, $this->temp);
			return $this;
		}

		public function autocorrect($message) {
			$message = $this->set("{assets}", "/public/templates/" . $this->template . "/assets/", $message);
			$message = $this->set("{sitehost}", "https://" . $_SERVER['SERVER_NAME'] . "/", $message);
			$message = $this->set("{cache}", conf()->cache, $message);
			$message = $this->set("{token}", $_SESSION['token'], $message);
			$message = $this->set("{title}", $this->page_name . " | " . conf()->title, $message);

			return $message;
		}

		public function end() {
			$file = tmpFile();
			fwrite($file, $this->autocorrect($this->temp));
			fseek($file, 0);
			require_once(stream_get_meta_data($file)['uri']);
			fclose($file);
		}

		/*
			Загрузка навигации
		*/
		public function nav($name, $active = "no_valid_tag") {
			$this
			->e_clear()
			->e_add("navs/$name")
			->e_set("{" . $active . ":active}", "active");

			return $this->e_end();
		}

		/*
			Работа с элементами
		*/
		public function e_clear() {
			$this->elements = "";
			return $this;
		}

		public function e_add($file) {
			if(!file_exists($this->templates . "elements/$file.tpl")):
				$this->elements .= "[Шаблонизатор: не найден файл: {$this->templates}elements/$file.tpl]";
			else:
				$this->elements .= file_get_contents($this->templates . "elements/$file.tpl");
			endif;
			
			return $this;
		}

		public function e_set($search, $replace) {
			$this->elements = str_replace($search, $replace, $this->elements);

			return $this;
		}

		public function e_end($eval = null) {
			if(isset($eval)):
				eval("?>" . $this->autocorrect($this->elements) . "<?");
				return;
			endif;

			return $this->autocorrect($this->elements);
		}
	}