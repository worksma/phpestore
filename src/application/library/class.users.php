<?PHP
	class Users {
		public function exists($uid) {
			return pdo()->query("SELECT * FROM `users` WHERE `id`='$uid' LIMIT 1")->rowCount();
		}

		public function get($uid) {
			if(!$this->exists($uid)):
				result([
					'alert'			=> 'error',
					'message'		=> 'Запрашиваемый пользователь не найден!'
				]);
			endif;

			return pdo()->query("SELECT * FROM `users` WHERE `id`='$uid' LIMIT 1")->fetch(PDO::FETCH_OBJ);
		}

		public function formate_name($uid, $link = false) {
			$u = $this->get($uid);

			$name = $u->name;
			$name .= ' ' . $u->surname;

			if($link):
				$name .= "<a href=\"/profile/uid{$u->id}\">$name</a>";
			endif;

			return $name;
		}

		public function login($login, $password) {
			$password = md5($password);
			$sth = pdo()->query("SELECT * FROM `users` WHERE `login`='$login' and `password`='$password' LIMIT 1");

			if(!$sth->rowCount()):
				result([
					'alert'			=> 'error',
					'message'		=> 'Неверный логин или пароль!'
				]);
			endif;

			$row 	= $sth->fetch(PDO::FETCH_OBJ);
			$hash 	= md5(rand_string(12));

			$_SESSION['id']			= $row->id;
			$_SESSION['hash']		= $hash;

			pdo()->exec("UPDATE `users` SET `hash`='$hash' WHERE `id`='{$row->id}' LIMIT 1");

			result([
				'alert'			=> 'success',
				'message'		=> 'Успешная авторизация!'
			]);
		}

		public function register($login, $password, $name, $surname) {
			$sth = pdo()->query("SELECT * FROM `users` WHERE `login`='$login' LIMIT 1");

			if($sth->rowCount()):
				result([
					'alert'			=> 'error',
					'message'		=> 'Данный логин уже занят!'
				]);
			endif;

			$row 			= $sth->fetch(PDO::FETCH_OBJ);
			$hash 			= md5(rand_string(12));
			$password 		= md5($password);

			pdo()
			->prepare("INSERT INTO `users`(`login`, `password`, `name`, `id_group`, `surname`, `ava`, `balance`, `hash`) VALUES (:login, :password, :name, :id_group, :surname, :ava, :balance, :hash)")
			->execute([
				':login'		=> $login,
				':password'		=> $password,
				':name'			=> $name,
				':id_group'		=> ((pdo()->query("SELECT * FROM `users` WHERE 1 LIMIT 1")->rowCount()) ? '1' : '2'),
				':surname'		=> $surname,
				':ava'			=> '/public/uploads/images/avatars/no_avatar.jpg',
				':balance'		=> '0',
				':hash'			=> 'none'
			]);
			
			result([
				'alert'			=> 'success',
				'message'		=> 'Успешная регистрация!'
			]);
		}

		public function logout() {
			$_SESSION['id']			= "";
			$_SESSION['cache']		= "";

			if(isset($_SESSION['id'])):
				unset($_SESSION['id']);
			endif;
			
			if(isset($_SESSION['cache'])):
				unset($_SESSION['cache']);
			endif;

			redirect();
		}

		public function get_balance($uid) {
			return $this->get($uid)->balance;
		}

		public function set_balance($uid, $price) {
			return pdo()
			->prepare("UPDATE `users` SET `balance`=:balance WHERE `id`=:uid LIMIT 1")
			->execute([
				':balance'		=> $price,
				':uid'			=> $uid
			]);
		}

		public function purse($uid = null, $price = null, $message = null, $system = "system") {
			$uid = clean($uid, "int");
			$price = clean($price, "int");

			return pdo()
			->prepare("INSERT INTO `users__purse`(`id_user`, `price`, `message`, `system`, `date`) VALUES (:id_user, :price, :message, :system, :date)")
			->execute([
				':id_user' => $uid,
				':price' => $price,
				':message' => $message,
				':system' => $system,
				':date' => date("Y-m-d H:i:s")
			]);
		}

		public function access($uid, $level = "z") {
			if(empty($uid)):
				return false;
			endif;

			$group = $this->get($uid)->id_group;
			$access = pdo()->query("SELECT * FROM `users__groups` WHERE `id`='$group' LIMIT 1")->fetch(PDO::FETCH_OBJ)->access;

			if(strrpos($access, $level) === false):
				return false;
			endif;

			return true;
		}
		
		public function expenses($uid = null) {
			if(empty($uid)):
				$uid = $_SESSION['id'];
			endif;
		
			$sth = pdo()->query("SELECT * FROM `product__purchases` WHERE `id_user`='$uid' and `price`!=0");
			
			$amount = 0;
			if(!$sth->rowCount()):
				return $amount;
			endif;
			
			while($row = $sth->fetch(PDO::FETCH_OBJ)):
				$amount += $row->price;
			endwhile;
			
			return $amount;
		}
	}