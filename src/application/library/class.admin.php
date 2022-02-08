<?PHP
	class Admin {
		static function sells() {
			return pdo()->query("SELECT * FROM `product__purchases` WHERE `price`!='0'")->rowCount();
		}

		static function income() {
			$sth = pdo()->query("SELECT * FROM `product__purchases` WHERE `price`!='0'");

			$amount = 0;
			if(!$sth->rowCount()):
				return $amount;
			endif;

			while($row = $sth->fetch(PDO::FETCH_OBJ)):
				$amount += $row->price;
			endwhile;

			return $amount;
		}

		static function products() {
			return pdo()->query("SELECT * FROM `product` WHERE 1")->rowCount();
		}

		static function users() {
			return pdo()->query("SELECT * FROM `users` WHERE 1")->rowCount();
		}

		static function templates() {
			$folders = scandir($_SERVER['DOCUMENT_ROOT'] . "/public/templates");

			$temp = "";
			for($i = 0; $i < sizeof($folders); $i++):
				if($folders[$i] == '.' || $folders[$i] == '..' || $folders[$i] == 'admin'):
					continue;
				endif;

				if(!file_exists($_SERVER['DOCUMENT_ROOT'] . '/public/templates/' . $folders[$i] . '/template/sample.tpl')):
				continue;
				endif;

				$temp .= "<option ".(($folders[$i] != conf()->template) ?: 'selected')." value=\"{$folders[$i]}\">{$folders[$i]}</option>";
			endfor;

			return $temp;
		}

		static function payconf($code) {
			return (new Pay)->conf($code);
		}

		static function groups() {
			return pdo()->query("SELECT * FROM `users__groups` WHERE 1");
		}

		public function get_product() {
			$sth = pdo()->query("SELECT * FROM `product` WHERE 1");

			if(!$sth->rowCount()):
				return "<center>Товаров нет.</center>";
			endif;

			tpl()->e_clear();
			while($row = $sth->fetch(PDO::FETCH_OBJ)):
				tpl()
				->e_add("cards/product")
				->e_set("{id}", $row->id)
				->e_set("{name}", $row->name)
				->e_set("{description}", $row->description)
				->e_set("{price}", $row->price)
				->e_set("{options}", Product::get_select_groups($row->category))
				->e_set("{image}", $row->image);
			endwhile;

			return tpl()->e_end(true);
		}

		public function get_users() {
			$sth = pdo()->query("SELECT * FROM `users` WHERE 1");

			if(!$sth->rowCount()):
				return "<center>Пользователей нет.</center>";
			endif;

			tpl()->e_clear();
			while($row = $sth->fetch(PDO::FETCH_OBJ)):
				tpl()
				->e_add("cards/user")
				->e_set("{avatar}", $row->ava)
				->e_set("{id_group}", $row->id_group)
				->e_set("{id}", $row->id)
				->e_set("{balance}", $row->balance)
				->e_set("{name}", $row->name . ' ' . $row->surname);
			endwhile;

			return tpl()->e_end(true);
		}
	}