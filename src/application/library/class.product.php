<?PHP
	class Product {
		public function getAll() {
			$sth = pdo()->query("SELECT * FROM `product` WHERE 1 ORDER BY `id` DESC");

			if(!$sth->rowCount()):
				return "<center>Товаров нет.</center>";
			endif;

			tpl()->e_clear();
			while($row = $sth->fetch(PDO::FETCH_OBJ)):
				tpl()
				->e_add("cards/product")
				->e_set("{id}", $row->id)
				->e_set("{price}", (($row->price <= 0) ? "Бесплатно" : ($row->price . " &#8381;")))
				->e_set("{name}", $row->name)
				->e_set("{image}", $row->image)
				->e_set("{description}", $row->description);
			endwhile;

			return tpl()->e_end();
		}

		public function get($id) {
			$sth = pdo()->query("SELECT * FROM `product` WHERE `id`='$id' LIMIT 1");

			if($sth->rowCount()):
				$row = $sth->fetch(PDO::FETCH_OBJ);

				tpl()
				->e_clear()
				->e_add("product-carousel")
				->e_set("{image}", $row->image)
				->e_set("{date}", $row->name)
				->e_set("{active}", "active");

				$ath = pdo()->query("SELECT * FROM `product__images` WHERE `id_product`='{$row->id}'");
				if($ath->rowCount()):
					while($arow = $ath->fetch(PDO::FETCH_OBJ)):
						tpl()
						->e_add("product-carousel")
						->e_set("{image}", $arow->file)
						->e_set("{date}", $arow->date)
						->e_set("{active}", "");
					endwhile;
				endif;

				result([
					'alert' 		=> 'success',
					'name'			=> $row->name,
					'description'	=> $row->description,
					'price'			=> (($row->price <= 0) ? "Бесплатно" : ($row->price . " &#8381;")),
					'images'		=> tpl()->e_end()
				]);
			endif;

			result([
				'alert' 		=> 'warning',
				'message'		=> 'Запрашиваемый товар не найден!',
				'name'			=> 'none',
				'description'	=> 'none',
				'price'			=> 'none',
				'image'			=> 'none'
			]);
		}

		public function get2($id) {
			$sth = pdo()->query("SELECT * FROM `product` WHERE `id`='$id' LIMIT 1");

			if(!$sth->rowCount()):
				result([
					'alert'		=> 'error',
					'message'	=> 'Товар не найден!'
				]);
			endif;

			return $sth->fetch(PDO::FETCH_OBJ);
		}

		public function buy($uid, $id) {
			$balance	= usr()->get_balance($uid);
			$price		= $this->get2($id)->price;

			if($balance < $price):
				result([
					'alert'		=> 'error',
					'message'	=> 'Недостаточно средств!'
				]);
			endif;

			usr()->set_balance($uid, $balance - $price);

			pdo()
			->prepare("INSERT INTO `product__purchases`(`id_user`, `id_product`, `price`, `date`) VALUES (:id_user, :id_product, :price, :date)")
			->execute([
				':id_user'		=> $uid,
				':id_product'	=> $id,
				':price'		=> $price,
				':date'			=> date("Y-m-d H:i:s")
			]);

			result([
				'alert'		=> 'success',
				'message'	=> "Проверьте список своих товаров!<br>Спасибо за покупку!"
			]);
		}

		public function purchases($uid) {
			$sth = pdo()->query("SELECT * FROM `product__purchases` WHERE `id_user`='$uid' ORDER BY `id` DESC");

			if(!$sth->rowCount()):
				return "<tr><td colspan=\"5\" class=\"text-center\">Вы ничего не купили.</td></tr>";
			endif;

			tpl()->e_clear();
			while($row = $sth->fetch(PDO::FETCH_OBJ)):
				$product = $this->get2($row->id_product);

				tpl()
				->e_add("tables/purchases")
				->e_set("{id}", $row->id)
				->e_set("{name}", $product->name)
				->e_set("{date}", date("H:i d.m.Y", strtotime($row->date)))
				->e_set("{price}", $row->price);
			endwhile;

			return tpl()->e_end();
		}

		public function delete($id) {
			$p = $this->get2($id);

			if(file_exists($_SERVER['DOCUMENT_ROOT'] . $p->image)):
				unlink($_SERVER['DOCUMENT_ROOT'] . $p->image);
			endif;

			if(file_exists($_SERVER['DOCUMENT_ROOT'] . $p->file)):
				unlink($_SERVER['DOCUMENT_ROOT'] . $p->file);
			endif;

			$sth = pdo()->query("SELECT * FROM `product__images` WHERE `id_product`='$id'");
			if($sth->rowCount()):
				while($row = $sth->fetch(PDO::FETCH_OBJ)):
					if(file_exists($_SERVER['DOCUMENT_ROOT'] . $row->file)):
						unlink($_SERVER['DOCUMENT_ROOT'] . $row->file);
					endif;
				endwhile;
			endif;

			pdo()->exec("DELETE FROM `product` WHERE `id`='$id'");
			pdo()->exec("DELETE FROM `product__images` WHERE `id_product`='$id'");
			pdo()->exec("DELETE FROM `product__purchases` WHERE `id_product`='$id'");
		}

		public function files_errors($file) {
			if(0 < $_FILES[$file]['error']):
				result([
					'alert'			=> 'error',
					'message'		=> $_FILES[$file]['error']
				]);
			endif;
		}

		public function temp($file, $patch = 'files') {
			return "/public/uploads/$patch/" . rand_string(12) . '.' . pathinfo($_FILES[$file]['name'], PATHINFO_EXTENSION);
		}

		public function upload($file, $patch = 'files') {
			$this->files_errors($file);
			$tmp = $this->temp($file, $patch);

			if(move_uploaded_file($_FILES[$file]['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $tmp)):
				return $tmp;
			endif;

			result([
				'alert'			=> 'error',
				'message'		=> $_FILES[$file]['error']
			]);
		}
	}