<?PHP
	class Languages extends System {
		var $lang;
		
		public function __construct($lang = "ru_RU") {
			$this->lang = $lang;
			$this->is_valid($lang);
		}
		
		public function set($lang) {
			$this->lang = $lang;
			return $this;
		}
		
		public function is_valid($lang) {
			if(file_exists(sysconf['root'] . "/application/languages/$lang.inc")):
				return true;
			endif;
			
			exit("[Языковая система: запрашиваемый язык не найден]");
		}
		
		public function load($lang) {
			return include(sysconf['root'] . "/application/languages/$lang.inc");
		}
		
		public function get($akey, $who, $arr = null) {
			$get = $this->load($this->lang)[0];
			
			foreach($get as $ikey => $a):
				if(empty($a[$who]) || $ikey != $akey):
					continue;
				endif;
			
				if(isset($arr)):
					foreach($arr as $key => $value):
						$a[$who] = str_replace($key, $value, $a[$who]);
					endforeach;
				endif;
				
				return $a[$who];
			endforeach;
		}
	}