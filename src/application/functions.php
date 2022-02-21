<?PHP
	function create_pdo($database = null) {
		if(empty($database)):
			return null;
		endif;

		try {
			$pdo = new PDO("mysql:host=$database->hostname;dbname=$database->dataname", $database->username, $database->password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$pdo->exec("set names utf8");

			return $pdo;
		}
		catch(PDOException $e) {
			exit('Error: ' . $e->getMessage());
			}
	}

	function pdo() {
		global $pdo;

		if(empty($pdo)):
			return create_pdo((object)include($_SERVER['DOCUMENT_ROOT'] . "/application/configs/database.php"));
		endif;

		return $pdo;
	}

	function tpl() {
		global $tpl;

		if(empty($tpl)):
			return (new Template);
		endif;

		return $tpl;
	}

	function usr() {
		global $usr;

		if(empty($usr)):
			return (new Users);
		endif;

		return $usr;
	}

	function conf() {
		global $conf;

		if(empty($conf)):
			return pdo()->query("SELECT * FROM `configs` LIMIT 1")->fetch(PDO::FETCH_OBJ);
		endif;

		return $conf;
	}

	function result($data) {
		exit(json_encode($data));
	}

	function redirect($url = "/", $time = 1) {
		exit("<script>setTimeout(\"location.href = '$url';\", $time);</script>");
	}

	function rand_string($length = 8) {
		return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, $length);
	}

	function clean($text = null, $params = null) {
		if(empty($text)):
			return $text;
		endif;

		$text = htmlspecialchars($text, ENT_QUOTES);
		$text = trim($text);

		switch($params):
			case "int":
				$text = preg_replace("/[^0-9]+/", "", $text);
			break;
			case "float":
				$text = str_replace(",", ".", $text);
				$text = preg_replace("/[^0-9.]/", "", $text);
				$text = (float)$text;
				$text = round($text, 2);
			break;
		endswitch;

		return $text;
	}

	function curl($site, $postfiels) {
		$ch = curl_init($site);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfiels);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}

	function gen_hash_link($id) {
		$hash = rand_string(12);

		pdo()
		->prepare("INSERT INTO `product__links`(`id_user`, `id_product`, `hash`, `date`) VALUES (:id_user, :id_product, :hash, :date)")
		->execute([
			':id_user'		=> $_SESSION['id'],
			':id_product'	=> $id,
			':hash'			=> $hash,
			':date'			=> date("Y-m-d H:i:s")
		]);
		
		return $hash;
	}

	function download($hash) {
		$hash = clean($hash);
		$sth = pdo()->query("SELECT * FROM `product__links` WHERE `hash`='$hash' LIMIT 1");

		if(!$sth->rowCount()):
			return false;
		endif;

		$row = $sth->fetch(PDO::FETCH_OBJ);
		$p = new Product;
		$product = $p->get2($row->id_product);
		$temp = $_SERVER['DOCUMENT_ROOT'] . $product->file;
		$filename = rand_string(8) . '.' . pathinfo($temp, PATHINFO_EXTENSION);

		if(file_exists($temp)):
			header("Content-Disposition: attachment; filename=$filename;");

			if($file = file_get_contents($temp)):
				echo $file;
				pdo()->exec("DELETE FROM `product__links` WHERE `hash`='$hash'");
				return true;
			endif;
		endif;

		return false;
	}
	
	function extFile($file) {
		$name = pathinfo($file, PATHINFO_FILENAME);
		$ext = pathinfo($file, PATHINFO_EXTENSION);
		
		return [
			'name' => $name,
			'ext' => $ext
		];
	}
	
	function lang() {
		global $lang;
		
		if(isset($lang)) {
			return $lang;
		}
		
		return new Languages($conf->language);
	}