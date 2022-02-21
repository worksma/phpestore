<?PHP
	class Pay {
		public function create($code = null, $price = null) {
			if(empty($code) || empty($price)):
				return false;
			endif;

			$kassa = $this->conf($code);

			switch($code):
				case "freekassa":
					$hash = $kassa->password1 . ":" . $price . ":" . $kassa->password2 . ":RUB:" . $_SESSION['id'];
					$hash = md5($hash);

					$url = "https://pay.freekassa.ru";
					$url .= "?m=" . $kassa->password1;
					$url .= "&oa=" . $price;
					$url .= "&o=" . $_SESSION['id'];
					$url .= "&currency=RUB";
					$url .= "&s=" . $hash;
				break;

				case "qiwi":
					$q = new Qiwi($kassa->password1);
					$udata = usr()->get($_SESSION['id']);

					$result = $q->createBill(
						$q->generateId(), [
							'amount' => $price * 1.00,
							'currency' => 'RUB',
							'comment' => lang()->get('purse', 'sending', ['_LOGIN_' => $udata->login]),
							'expirationDateTime' => $q->getLifetimeByDay(1),
							'email' => 'webmaster@' . $_SERVER['SERVER_NAME'],
							'account' => $_SESSION['id'],
							'successUrl' => $_SERVER['SERVER_NAME'] . '/purse/success'
						]
					);

					$url = $result['payUrl'];
				break;
				
				case "lava":
					$url = Lava::g2p($price);
				break;
				
				default:
					return false;
				break;
			endswitch;

			return $url;
		}

		public function conf($code = null) {
			if(empty($code)):
				return null;
			endif;

			$sth = pdo()->query("SELECT * FROM `configs__kassa` WHERE `code_name`='$code' LIMIT 1");

			if(!$sth->rowCount()):
				return null;
			endif;

			return $sth->fetch(PDO::FETCH_OBJ);
		}

		public function is_enable($code = null) {
			if(empty($code)):
				return false;
			endif;

			if($this->conf($code)->enable == '1'):
				return true;
			endif;

			return false;
		}

		public function logs($message) {
			$message = clean($message);

			return pdo()
			->prepare("INSERT INTO `logs__pays`(`message`, `date`) VALUES (:message, :date)")
			->execute([
				':message' => $message,
				':date' => date("Y-m-d H:i:s")
			]);
		}

		static function purse($uid) {
			$sth = pdo()->query("SELECT * FROM `users__purse` WHERE `id_user`='$uid' ORDER BY `id` DESC");

			if(!$sth->rowCount()):
				return "<tr><td colspan=\"5\" class=\"text-center\">" . lang()->get('noty', 'no_operation') . "</td></tr>";
			endif;

			tpl()->e_clear();
			while($row = $sth->fetch(PDO::FETCH_OBJ)):
				tpl()
				->e_add("tabs/purse")
				->e_set("{id}", $row->id)
				->e_set("{message}", $row->message)
				->e_set("{system}", $row->system)
				->e_set("{price}", $row->price)
				->e_set("{date}", date("H:i d.m.Y", strtotime($row->date)));
			endwhile;

			return tpl()->e_end();
		}
	}