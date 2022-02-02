<?PHP
	class Routing {
		private static $routes = [];

		public static function get($pattern, $callback) {
			$pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';
			self::$routes[$pattern] = $callback;
		}

		/*
			(\w+)
			(\d+)
		*/
		public static function execute($url) {
			$i = 0;

			foreach(self::$routes as $pattern => $callback):
				if(preg_match($pattern, $url, $params)):
					$i++;
					array_shift($params);
					return call_user_func_array($callback, array_values($params));
				endif;
			endforeach;

			if(!$i):
				header("Location: /404");
			endif;
		}
	}