<?PHP
	Routing::get("/", function() {
		tpl()
		->run()
		->title("home")
		->set("{content}", tpl()->get("main/index"))
		->set("{nav}", tpl()->nav("top-horizontal", "home"))
		->set("{products}", (new Product)->getAll())
		->end();
	});

	Routing::get("/404", function() {
		tpl()
		->run()
		->title("404")
		->set("{content}", "<center>". lang()->get('errors', 'no_page') ."</center>")
		->set("{nav}", tpl()->nav("top-horizontal"))
		->end();
	});

	Routing::get("/login", function() {
		if(isset($_SESSION['id'])):
			redirect();
		endif;

		tpl()
		->run()
		->title("login")
		->set("{content}", tpl()->get("main/login"))
		->set("{nav}", tpl()->nav("top-horizontal", "login"))
		->end();
	});

	Routing::get("/login/vk?(\S+)", function($get) {
		if(isset($_GET['code'])):
			$apps = Apps::get_vk('1');

			$token = json_decode(curl("https://oauth.vk.com/access_token", [
				'client_id'			=> $apps->app_id,
				'client_secret'		=> $apps->app_secret,
				'code'				=> $_GET['code'],
				'redirect_uri'		=> "https://".$_SERVER['SERVER_NAME'] . '/login/vk'
			]));

			if(isset($token->access_token)):
				$user = json_decode(curl("https://api.vk.com/method/users.get", [
					'uids'			=> $token->user_id,
					'fields'		=> 'uid,first_name,last_name,screen_name,sex,bdate,photo_big',
					'access_token'	=> $token->access_token,
					'v'				=> '5.131'
				]));

				if(empty($user->response['0']->id)):
					redirect('/login');
				endif;

				$login = md5($user->response['0']->id . $user->response['0']->first_name . $user->response['0']->last_name);
				$sth = pdo()->query("SELECT * FROM `users` WHERE `login`='$login' LIMIT 1");
				$hash 	= md5(rand_string(12));

				if($sth->rowCount()):
					$row = $sth->fetch(PDO::FETCH_OBJ);

					$_SESSION['id']			= $row->id;
					$_SESSION['cache']		= $hash;

					pdo()->exec("UPDATE `users` SET `hash`='$hash' WHERE `id`='{$row->id}' LIMIT 1");
					redirect();
				else:
					if(pdo()
					->prepare("INSERT INTO `users`(`login`, `password`, `name`, `surname`, `id_group`, `ava`, `balance`, `hash`) VALUES (:login, :password, :name, :surname, :id_group, :ava, :balance, :hash)")
					->execute([
						':login'			=> $login,
						':password'			=> '',
						':name'				=> $user->response['0']->first_name,
						':surname'			=> $user->response['0']->last_name,
						':id_group'			=> ((pdo()->query("SELECT * FROM `users` WHERE 1 LIMIT 1")->rowCount()) ? '1' : '2'),
						':ava'				=> $user->response['0']->photo_big,
						':balance'			=> '0',
						':hash'				=> $hash
					])):
						$_SESSION['id']			= pdo()
												->query("SELECT * FROM `users` WHERE `login`='$login' LIMIT 1")
												->fetch(PDO::FETCH_OBJ)
												->id;
						$_SESSION['cache']		= $hash;
						redirect();
					endif;
				endif;
			endif;
		endif;
	});

	Routing::get("/register", function() {
		if(isset($_SESSION['id'])):
			redirect();
		endif;

		tpl()
		->run()
		->title("register")
		->set("{content}", tpl()->get("main/register"))
		->set("{nav}", tpl()->nav("top-horizontal", "register"))
		->end();
	});

	Routing::get("/logout", function() {
		if(empty($_SESSION['id'])):
			redirect();
		endif;

		usr()->logout();
	});

	Routing::get("/purchases", function() {
		if(empty($_SESSION['id'])):
			redirect('/login');
		endif;

		tpl()
		->run()
		->title("purchases")
		->set("{content}", tpl()->get("main/purchases"))
		->set("{nav}", tpl()->nav("top-horizontal", "purchases"))
		->set("{purchases}", (new Product)->purchases($_SESSION['id']))
		->end();
	});

	Routing::get("/contact", function() {
		tpl()
		->run()
		->title("contacts")
		->set("{content}", tpl()->get("main/contact"))
		->set("{nav}", tpl()->nav("top-horizontal", "contact"))
		->end();
	});

	Routing::get("/garant", function() {
		tpl()
		->run()
		->title("garants")
		->set("{content}", tpl()->get("main/garant"))
		->set("{nav}", tpl()->nav("top-horizontal", "garant"))
		->end();
	});

	Routing::get("/reviews", function() {
		tpl()
		->run()
		->title("reviews")
		->set("{content}", tpl()->get("main/reviews"))
		->set("{nav}", tpl()->nav("top-horizontal", "reviews"))
		->end();
	});

	Routing::get("/support", function() {
		redirect("https://vk.com/worksmaru");
	});

	Routing::get("/wallet", function() {
		if(empty($_SESSION['id'])):
			redirect('/login');
		endif;

		tpl()
		->run()
		->title("wallet")
		->set("{content}", tpl()->get("main/wallet"))
		->set("{nav}", tpl()->nav("top-horizontal", "wallet"))
		->set("{purse}", Pay::purse($_SESSION['id']))
		->set("{expenses}", usr()->expenses($_SESSION['id']))
		->end();
	});

	Routing::get("/purse/(\w+)", function($result) {
		exit($result);
	});

	Routing::get("/purse/(\S+)/info", function($system) {
		$system = clean($system);

		switch($system):
			case "freekassa":
				if(empty($_POST['MERCHANT_ID']) || empty($_POST['MERCHANT_ORDER_ID'])):
					exit("Error: [bad data]");
				endif;

				$pay = new Pay;
				$kassa = $pay->conf($system);

				$hash = $kassa->password1 . ':' . $_POST['AMOUNT'] . ':' . $kassa->password3 . ':' . $_POST['MERCHANT_ORDER_ID'];
				$hash = md5($hash);

				if($hash != $_POST['SIGN']):
					exit("Error: [bad signature]");
				endif;

				$uid 		= $_POST['MERCHANT_ORDER_ID'];
				$amount		= intval($_POST['AMOUNT']);
				
				$pay->logs(lang()->get('purse', 'noty', ['_UID_' => $uid, '_AMOUNT_' => $amount, '_SYSTEM_' => $system]));

				$balance = usr()->get_balance($uid);
				usr()->set_balance($uid, $balance + $amount);
				usr()->purse($uid, $amount, lang()->get('purse', 'history'), $system);

				exit("YES");
			break;

			case "qiwi":
				$data = json_decode(file_get_contents('php://input'), true);

				if(array_key_exists('HTTP_X_API_SIGNATURE_SHA256', $_SERVER)):
					$signature = $_SERVER['HTTP_X_API_SIGNATURE_SHA256'];
				else:
					$signature = null;
				endif;

				if(empty($data) || empty($signature)):
					http_response_code(204);
					exit('Error: [empty data]');
				endif;

				$pay_number = $data['bill']['billId'];
				$status     = $data['bill']['status']['value'];
				$amount     = $data['bill']['amount']['value'];
				$uid    	= $data['bill']['customer']['account'];

				$pay = new Pay;
				$kassa = $pay->conf($system);
				$Qiwi = new Qiwi($kassa->password1);

				if(!$Qiwi->checkNotificationSignature($signature, $data, $kassa->password1) && $status == 'PAID'):
					http_response_code(400);
					exit("Error: [bad signature]");
				else:
					if(!usr()->exists($uid)):
						http_response_code(404);
						exit('Error: [User does not exist]');
					endif;

					$amount = intval($amount);
					$pay->logs(lang()->get('purse', 'noty', ['_UID_' => $uid, '_AMOUNT_' => $amount, '_SYSTEM_' => $system]));

					$balance = usr()->get_balance($uid);
					usr()->set_balance($uid, $balance + $amount);
					usr()->purse($uid, $amount, lang()->get('purse', 'history'), $system);

					exit("OK");
				endif;
			break;
			
			case "lava":
				$result = json_decode(file_get_contents("php://input"));
				
				if(!Lava::is_valid($result->invoice_id)):
					http_response_code(400);
					exit("Error: [bad signature]");
				endif;
				
				$uid = $result->custom_fields;
					
				if(!usr()->exists($uid)):
					http_response_code(404);
					exit('Error: [User does not exist]');
				endif;
					
				$user = usr()->get($uid);
				$amount = intval($result->amount);
				
				$pay->logs(lang()->get('purse', 'noty', ['_UID_' => $uid, '_AMOUNT_' => $amount, '_SYSTEM_' => $system]));
				$balance = usr()->get_balance($uid);
				usr()->set_balance($uid, $balance + $amount);
				usr()->purse($uid, $amount, lang()->get('purse', 'history'), $system);
				
				exit("OK");
			break;
		endswitch;

		exit("Error: [bad kassa]");
	});

	Routing::get("/download/(\w+)", function($hash) {
		if(!download($hash)):
			redirect('/404');
		endif;
	});
	
	Routing::get("/id(\d+)", function($uid) {
		if(!usr()->exists($uid)) {
			return redirect("/404");
		}
		
		$user = usr()->get($uid);
		
		tpl()->run()->title("profile:['_LOGIN_' => '$user->name $user->surname']")
		->set("{content}", tpl()->get("main/profile"))
		->set("{nav}", tpl()->nav("top-horizontal", "profile"))
		->set("{login}", $user->login)
		->set("{avatar}", $user->ava)
		->set("{first_name}", $user->name)
		->set("{last_name}", $user->surname)
		->end();
	});