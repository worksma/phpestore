<?PHP
	class JsCompress {
		public static function construct($buffer) {
			$buffer = preg_replace("/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\'|\")\/\/.*))/", "", $buffer);
			$buffer = str_replace(array("\r\n", "\r", "\n", "\t", "  ", "    ", "    "), "", $buffer);
			
			return $buffer;
		}
	}