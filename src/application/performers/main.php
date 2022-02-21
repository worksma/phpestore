<?PHP
	require($_SERVER['DOCUMENT_ROOT'] . "/application/start.php");
	
	if(empty($_POST['php_action'])):
		result([
			'alert'			=> 'error',
			'message'		=> lang()->get('errors', 'exploit')
			]);
	endif;

	if($_SESSION['token'] != $_POST['token']):
		result([
			'alert'			=> 'error',
			'message'		=> lang()->get('errors', 'token')
		]);
	endif;

/*
		Функции для неавторизованных
	*/
	if(isset($_POST['user_login'])):
		$login		= clean($_POST['login']);
		$password	= clean($_POST['password']);

		if(empty($login) || empty($password)):
			result([
				'alert'		=> 'warning',
				'message'	=> lang()->get('errors', 'empty_data')
			]);
		endif;

		usr()->login($login, $password);
	endif;

	if(isset($_POST['user_register'])):
		$name		= clean($_POST['name']);
		$surname	= clean($_POST['surname']);
		$login		= clean($_POST['login']);
		$password	= clean($_POST['password']);

		if(empty($login) || empty($password) || empty($name) || empty($surname)):
			result([
				'alert'		=> 'warning',
				'message'	=> lang()->get('errors', 'empty_data')
			]);
		endif;

		usr()->register($login, $password, $name, $surname);
	endif;

	if(isset($_POST['get_product'])):
		$id = $_POST['id'];
		$id = clean($id, "int");

		(new Product)->get($id);
	endif;

	if(isset($_POST['user_login_vk'])):
		$c = Apps::get_vk('1');

		$url = "https://oauth.vk.com/authorize?client_id={$c->app_id}&redirect_uri=https://{$_SERVER['SERVER_NAME']}/login/vk&response_type=code";
		result($url);
	endif;

	if(isset($_POST['reviews'])):
		$sth = pdo()->query("SELECT * FROM `reviews` WHERE 1 ORDER BY `id` DESC");
		
		if(!$sth->rowCount()):
			result("<center>" . lang()->get('noty', 'no_reviews') . "</center>");
		endif;

		tpl()->e_clear();
		while($row = $sth->fetch(PDO::FETCH_OBJ)):
			$u = usr()->get($row->id_user);

			tpl()
			->e_add("reviews")
			->e_set("{message}", $row->message)
			->e_set("{date}", date("H:i d.m.Y", strtotime($row->date)))
			->e_set("{avatar}", sysconf['avatars'] . $u->image)
			->e_set("{name}", $u->name . ' ' . $u->surname);
		endwhile;

		result(tpl()->e_end());
	endif;

	/*
		Функции для авторизованных
	*/
	if(empty($_SESSION['id'])):
		result([
			'alert'			=> 'error',
			'message'		=> lang()->get('errors', 'not_auth')
		]);
	endif;

	if(isset($_POST['buy_product'])):
		$id = clean($_POST['id'], "int");
		(new Product)->buy($_SESSION['id'], $id);
	endif;

	if(isset($_POST['delete_purchases'])):
		$id = clean($_POST['id'], "int");
		pdo()->exec("UPDATE `product__purchases` SET `id_user`='-1' WHERE (`id`='$id' and `id_user`='" . $_SESSION['id'] . "') LIMIT 1");
		
		result((new Product)->purchases($_SESSION['id']));
	endif;

	if(isset($_POST['send_reviews'])):
		$message = clean($_POST['message']);

		if(empty($message)):
			result([
				'alert'		=> 'warning',
				'message'	=> lang()->get('errors', 'no_text')
			]);
		endif;

		pdo()
		->prepare("INSERT INTO `reviews`(`id_user`, `message`, `date`) VALUES (:id_user, :message, :date)")
		->execute([
			':id_user'			=> $_SESSION['id'],
			':message'			=> $message,
			':date'				=> date("Y-m-d H:i:s")
		]);

		result([
			'alert' => 'success',
			'message' => lang()->get('noty', 'end_reviews')
		]);
	endif;

	if(isset($_POST['kassa_create'])):
		$pay = new Pay;
		$url = $pay->create($_POST['code_name'], $_POST['price']);

		if($url):
			exit(json_encode([
				'alert' => 'success',
				'url' => $url
			]));
		endif;

		exit(json_encode(['alert' => 'error']));
	endif;

	if(isset($_POST['download'])):
		$id = clean($_POST['id'], "int");

		$sth = pdo()->query("SELECT * FROM `product__purchases` WHERE `id_user`='{$_SESSION['id']}' and `id`='$id' LIMIT 1");

		if(!$sth->rowCount()):
			result([
				'alert'			=> 'error',
				'message'		=> lang()->get('errors', 'no_product')
			]);
		endif;

		$row = $sth->fetch(PDO::FETCH_OBJ);
		$hash = gen_hash_link($row->id_product);

		$p = new Product;
		$product = $p->get2($row->id_product);

		$temp = $_SERVER['DOCUMENT_ROOT'] . $product->file;
		$filename = rand_string(8) . '.' . pathinfo($temp, PATHINFO_EXTENSION);

		result([
			'alert'			=> 'success',
			'message'		=> lang()->get('noty', 'success'),

			'file'			=> 'https://' . $_SERVER['SERVER_NAME'] . '/download/' . $hash,
			'name'			=> $filename
		]);
	endif;