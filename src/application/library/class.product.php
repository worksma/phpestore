<?PHP
	class Product {
		public function getAll() {
			$sth = pdo()->query("SELECT * FROM `product` WHERE 1 ORDER BY `id` DESC");

			if(!$sth->rowCount()):
				return "<center>". lang()->get('noty', 'no_product') ."</center>";
			endif;

			tpl()->e_clear();
			while($row = $sth->fetch(PDO::FETCH_OBJ)):
				tpl()
				->e_add("cards/product")
				->e_set("{id}", $row->id)
				->e_set("{price}", (($row->price <= 0) ? lang()->get('other', 'free') : ($row->price . " &#8381;")))
				->e_set("{name}", $row->name)
				->e_set("{image}", $row->image)
				->e_set("{description}", $row->description);
			endwhile;

			return tpl()->e_end();
		}
		
		public function getCategory($id) {
			$sth = pdo()->query("SELECT * FROM `product__category` WHERE `id`='$id' LIMIT 1");
			
			if(!$sth->rowCount()):
				return null;
			endif;
			
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		
		public function getGroupCategory($id) {
			$sth = pdo()->query("SELECT * FROM `product__optgroup` WHERE `id`='$id' LIMIT 1");
			
			if(!$sth->rowCount()):
				return null;
			endif;
			
			return $sth->fetch(PDO::FETCH_OBJ);
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

				$category[0] = $this->getCategory($row->category);
				if(isset($category[0])):
					$category[1] = $this->getGroupCategory($category[0]->oid);
					$category = $category[1]->name . " - " . $category[0]->name;
				else:
					$category = "None";
				endif;

				result([
					'alert' 		=> 'success',
					'name'			=> $row->name,
					'description'	=> $row->description,
					'price'			=> (($row->price <= 0) ? lang()->get('other', 'free') : ($row->price . " &#8381;")),
					'images'		=> tpl()->e_end(),
					'category'		=> $category
				]);
			endif;

			result([
				'alert' 		=> 'warning',
				'message'		=> lang()->get('errors', 'search_product'),
				'name'			=> 'none',
				'description'	=> 'none',
				'price'			=> 'NaN',
				'image'			=> 'none',
				'category'		=> 'none'
			]);
		}

		public function get2($id) {
			$sth = pdo()->query("SELECT * FROM `product` WHERE `id`='$id' LIMIT 1");

			if(!$sth->rowCount()):
				result([
					'alert'		=> 'error',
					'message'	=> lang()->get('errors', 'search_product')
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
					'message'	=> lang()->get('errors', 'money')
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
				'message'	=> lang()->get('noty', 'thank_you')
			]);
		}

		public function purchases($uid) {
			$sth = pdo()->query("SELECT * FROM `product__purchases` WHERE `id_user`='$uid' ORDER BY `id` DESC");

			if(!$sth->rowCount()):
				return "<tr><td colspan=\"5\" class=\"text-center\">" . lang()->get('noty', 'no_purchases') . "</td></tr>";
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
		
		public static function get_groups() {
			$sth = pdo()->query("SELECT * FROM `product__optgroup` WHERE 1 ORDER BY `position` ASC");
			
			if(!$sth->rowCount()):
				return "<center>" . lang()->get('errors', 'groups') . "</center>";
			endif;
			
			$t = new Template;
			$t->set_template("admin")->e_clear();
			while($row = $sth->fetch(PDO::FETCH_OBJ)):
				$t->e_add("groups")->e_set("{name}", $row->name)->e_set("{position}", $row->position)->e_set("{id}", $row->id);
			endwhile;
			
			return $t->e_end();
		}
		
		public static function get_select_groups($id = null) {
			$sth = pdo()->query("SELECT * FROM `product__optgroup` WHERE 1 ORDER BY `position` ASC");
			if($sth->rowCount()):
				while($row = $sth->fetch(PDO::FETCH_OBJ)):
					$select .= "<option value='" . $row->id . "' " . (empty($id) ?: ($id != $row->id ?: "selected")) . ">" . $row->name . "</option>";
				endwhile;
			else:
				$select = "<option disabled selected value=\"0\">" . lang()->get('errors', 'groups') . "</option>";
			endif;
			
			return $select;
		}
		
		public static function get_category() {
			$sth = pdo()->query("SELECT * FROM `product__category` WHERE 1 ORDER BY `oid`, `position` ASC");
			
			if(!$sth->rowCount()):
				return "<center>" . lang()->get('errors', 'category') . "</center>";
			endif;
			
			$t = new Template;
			$t->set_template("admin")->e_clear();
			while($row = $sth->fetch(PDO::FETCH_OBJ)):
				$ath = pdo()->query("SELECT * FROM `product__optgroup` WHERE 1 ORDER BY `position` ASC");
				
				$select = self::get_select_groups($row->oid);
				
				$t->e_add("category")
				->e_set("{id}", $row->id)
				->e_set("{name}", $row->name)
				->e_set("{position}", $row->position)
				->e_set("{select}", $select);
			endwhile;
			
			return $t->e_end();
		}
	}