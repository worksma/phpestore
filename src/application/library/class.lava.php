<?PHP
	class Lava {
		const PING = "https://api.lava.ru/test/ping";
		const INVOICE_CREATE = "https://api.lava.ru/invoice/create";
		const INVOICE_INFO = "https://api.lava.ru/invoice/info";
		
		public static function conf() {
			$row = pdo()->query("SELECT * FROM `configs__kassa` WHERE `code_name`='lava' LIMIT 1")->fetch(PDO::FETCH_OBJ);
			
			return (object)[
				'enable' => $row->enable,
				'token' => $row->password1,
				'wallet' => $row->password2,
				'domain' => "https://" . $_SERVER['SERVER_NAME'] . "/"
			];
		}
		
		public static function is_token($token = null) {
			if(empty($token)):
				$token = self::conf()->token;
			endif;
		
			$result = self::curl(self::PING, [
				"Authorization: $token"
			]);
			
			if($result->status == '1'):
				return true;
			endif;
			
			return $result->message;
		}
		
		public static function is_valid($id) {
			if(empty($id)):
				return false;
			endif;
			
			$result = self::curl(self::INVOICE_INFO, ['Authorization: ' . self::conf()->token], ['id' => $id]);
			
			if($result->status == 'success'):
				return true;
			endif;
			
			return false;
		}
		
		public static function g2p($count = 10.00) {
			if(!self::conf()->enable):
				result([
					'alert' => 'error',
					'message' => lang()->get('errors', 'wallet')
				]);
			endif;
		
			$result = self::curl(self::INVOICE_CREATE, [
				"Authorization: " . self::conf()->token
			], [
				'wallet_to'		=> self::conf()->wallet,
				'sum'			=> $count,
				'order_id'		=> time() * 1000,
				'hook_url'		=> self::conf()->domain . "purse/lava/info",
				'success_url'	=> self::conf()->domain . "purse/success",
				'fail_url'		=> self::conf()->domain . "purse/error",
				'expire'		=> 300,
				'subtract'		=> 1,
				'custom_fields' => $_SESSION['id'],
				'comment'		=> lang()->get('purse', 'sending', ['_LOGIN_' => usr()->get($_SESSION['id'])->login]),
				'merchant_name' => conf()->title
			]);
			
			if($result->status == 'success'):
				return $result->url;
			endif;
			
			result([
				'alert' => 'error',
				'message' => $result->message
			]);
		}
		
		public static function curl($uri, $headers, $data = null) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $uri);
			
			if(isset($data)):
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			endif;
			
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$result = curl_exec($ch);
			curl_close($ch);
			
			return json_decode($result);
		}
	}