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

	if(!usr()->access($_SESSION['id'], "a")):
		result([
			'alert'			=> 'error',
			'message'		=> lang()->get('errors', 'access')
		]);
	endif;
	
	if(isset($_POST['update_cache'])):
		$id = conf()->cache + 1;
		
		pdo()->exec("UPDATE `configs` SET `cache`='$id' WHERE 1");
		
		result([
			'alert'			=> 'success',
			'message'		=> lang()->get('noty', 'update_cache')
		]);
	endif;
	
	if(isset($_POST['truncate_reviews'])):
		pdo()->exec("TRUNCATE `reviews`;");

		result([
			'alert'			=> 'success',
			'message'		=> lang()->get('noty', 'clear_reviews')
		]);
	endif;

	if(isset($_POST['truncate_pays'])):
		pdo()->exec("TRUNCATE `logs__pays`;");

		result([
			'alert'			=> 'success',
			'message'		=> lang()->get('noty', 'clear_pays')
		]);
	endif;

	if(isset($_POST['save'])):
		$value = $_POST['value'];

		switch($_POST['type']):
			case "title":
				pdo()->exec("UPDATE `configs` SET `title`='$value' WHERE 1 LIMIT 1");
			break;

			case "description":
				pdo()->exec("UPDATE `configs` SET `description`='$value' WHERE 1 LIMIT 1");
			break;

			case "keywords":
				pdo()->exec("UPDATE `configs` SET `keywords`='$value' WHERE 1 LIMIT 1");
			break;

			case "template":
				pdo()->exec("UPDATE `configs` SET `template`='$value' WHERE 1 LIMIT 1");
			break;

			case "qiwi_enable":
				pdo()->exec("UPDATE `configs__kassa` SET `enable`='$value' WHERE `code_name`='qiwi' LIMIT 1");
			break;
			
			case "qiwi_key":
				pdo()->exec("UPDATE `configs__kassa` SET `password1`='$value' WHERE `code_name`='qiwi' LIMIT 1");
			break;

			case "lava_enable":
				pdo()->exec("UPDATE `configs__kassa` SET `enable`='$value' WHERE `code_name`='lava' LIMIT 1");
			break;

			case "lava_id":
				pdo()->exec("UPDATE `configs__kassa` SET `password2`='$value' WHERE `code_name`='lava' LIMIT 1");
			break;

			case "lava_secret":
				pdo()->exec("UPDATE `configs__kassa` SET `password1`='$value' WHERE `code_name`='lava' LIMIT 1");
			break;

			case "fk_enable":
				pdo()->exec("UPDATE `configs__kassa` SET `enable`='$value' WHERE `code_name`='free-kassa' LIMIT 1");
			break;

			case "fk_id":
				pdo()->exec("UPDATE `configs__kassa` SET `password1`='$value' WHERE `code_name`='free-kassa' LIMIT 1");
			break;

			case "fk_secret1":
				pdo()->exec("UPDATE `configs__kassa` SET `password2`='$value' WHERE `code_name`='free-kassa' LIMIT 1");
			break;

			case "fk_secret2":
				pdo()->exec("UPDATE `configs__kassa` SET `password3`='$value' WHERE `code_name`='free-kassa' LIMIT 1");
			break;

			case "apps_vk_id":
				pdo()->exec("UPDATE `apps__vk` SET `app_id`='$value' WHERE `id`='1'");
			break;

			case "apps_vk_secret":
				pdo()->exec("UPDATE `apps__vk` SET `app_secret`='$value' WHERE `id`='1'");
			break;

			case "apps_vk_service":
				pdo()->exec("UPDATE `apps__vk` SET `app_service`='$value' WHERE `id`='1'");
			break;
		endswitch;

		result([
			'alert'			=> 'success',
			'message'		=> lang()->get('noty', 'save_data')
		]);
	endif;

	if(isset($_POST['save_user'])):
		$value		= $_POST['value'];
		$uid		= $_POST['uid'];

		switch($_POST['type']):
			case "group":
				pdo()->exec("UPDATE `users` SET `id_group`='$value' WHERE `id`='$uid' LIMIT 1");
			break;

			case "balance":
				usr()->set_balance($uid, $value);
			break;
		endswitch;

		result([
			'alert'			=> 'success',
			'message'		=> lang()->get('noty', 'save_data')
		]);
	endif;

	if(isset($_POST['product_delete'])):
		(new Product)->delete($_POST['id']);
		result((new Admin)->get_product());
	endif;

	if(isset($_POST['add_product'])):
		$p = new Product;
		$file = $p->upload('file', 'files');
		$image = $p->upload('image', 'images');

		pdo()
		->prepare("INSERT INTO `product`(`name`, `description`, `price`, `image`, `file`, `category`, `date`) VALUES (:name, :description, :price, :image, :file, :category, :date)")
		->execute([
			':name'				=> $_POST['title'],
			':description'		=> $_POST['description'],
			':price'			=> $_POST['price'],
			':image'			=> $image,
			':file'				=> $file,
			':category'			=> $_POST['category'],
			':date'				=> date("Y-m-d H:i:s")
		]);

		$id = pdo()->lastInsertId();

		for($i = 0; $i < count($_FILES['images']['name']); $i++):
			if(0 < $_FILES['images']['error'][$i]):
				continue;
			endif;

			$tmp = "/public/uploads/images/" . rand_string(12) . '.' . pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);

			if(!move_uploaded_file($_FILES['images']['tmp_name'][$i], $_SERVER['DOCUMENT_ROOT'] . $tmp)):
				continue;
			endif;

			pdo()
			->prepare("INSERT INTO `product__images`(`id_product`, `file`, `date`) VALUES (:id_product, :file, :date)")
			->execute([
				':id_product'		=> $id,
				':file'				=> $tmp,
				':date'				=> date("Y-m-d H:i:s")
			]);
		endfor;

		result([
			'alert' => 'success'
		]);
	endif;

	if(isset($_POST['download_update'])):
		ignore_user_abort(1);
		set_time_limit(0);

		$new_version	= $_POST['version'];

		$sys		= new System;
		$file		= $sys->get_update_file($new_version);

		if($sys->update_download($file, $new_version)):
			$sys->set_update($new_version);
		endif;

		result(['alert' => 'success']);
	endif;

	if(isset($_POST['save_product'])):
		$value		= $_POST['value'];
		$id			= $_POST['id'];

		switch($_POST['type']):
			default:
				pdo()->exec("UPDATE `product` SET `{$_POST['type']}`='$value' WHERE `id`='$id' LIMIT 1");
			break;
		endswitch;

		result([
			'alert'			=> 'success',
			'message'		=> lang()->get('noty', 'save_data')
		]);
	endif;

	if(isset($_POST['replace_file'])):
		$id 		= $_POST['id'];

		$p 			= new Product;
		$product 	= $p->get2($id);
		$temp 		= $_SERVER['DOCUMENT_ROOT'] . $product->file;
		unlink($temp);

		if(0 < $_FILES['file']['error']):
			result([
				'alert'		=> 'error',
				'message'	=> $_FILES['file']['error']
			]);
		endif;

		$filename	= "/public/uploads/files/" . rand_string(12) . '.' . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		$temp 		= $_SERVER['DOCUMENT_ROOT'] . $filename;

		if(move_uploaded_file($_FILES['file']['tmp_name'], $temp)):
			pdo()->exec("UPDATE `product` SET `file`='$filename' WHERE `id`='$id' LIMIT 1");
		endif;

		result([
			'alert'		=> 'success',
			'message'	=> lang()->get('noty', 'save_data')
		]);
	endif;
	
	if(isset($_POST['group_save'])):
		$id = clean($_POST['id'], "int");
		$pos = clean($_POST['position'], "int");
		$name = clean($_POST['name']);
		
		try{
			pdo()
			->prepare("UPDATE `product__optgroup` SET `name`=:name,`position`=:pos WHERE `id`=:id LIMIT 1")
			->execute([':id' => $id, ':name' => $name, ':pos' => $pos]);
			
			result([
				'alert' => 'success',
				'message' => lang()->get('noty', 'save_data'),
				'content' => Product::get_groups()
			]);
		}
		catch(Exception $e) {
			result([
				'alert' => 'warning',
				'message' => $e->getMessage()
			]);
		}
		catch(ParseError $e) {
			result([
				'alert' => 'error',
				'message' => $e->getMessage()
			]);
		}
	endif;
	
	if(isset($_POST['group_delete'])):
		$id = clean($_POST['id'], "int");
		$sth = pdo()->query("SELECT * FROM `product__category` WHERE `oid`='$id'");
		
		if($sth->rowCount()):
			while($row = $sth->fetch(PDO::FETCH_OBJ)):
				$ath = pdo()->query("SELECT * FROM `product` WHERE `category`='" . $row->id . "'");
				
				if($ath->rowCount()):
					while($aow = $ath->fetch(PDO::FETCH_OBJ)):
						(new Product)->delete($aow->id);
					endwhile;
				endif;
				
				pdo()->exec("DELETE FROM `product__category` WHERE `id`='" . $row->id . "' LIMIT 1");
			endwhile;
		endif;
		
		pdo()->exec("DELETE FROM `product__optgroup` WHERE `id`='$id' LIMIT 1");
		result([
			'alert' => 'success',
			'message' => lang()->get('noty', 'success_operation'),
			
			'content_groups' => Product::get_groups(),
			'content_category' => Product::get_category(),
			'content_selects' => Product::get_select_groups()
		]);
	endif;
	
	if(isset($_POST['group_add'])):
		$name = clean($_POST['name']);
		$sth = pdo()->query("SELECT * FROM `product__optgroup` WHERE 1 ORDER BY `position` DESC LIMIT 1");
		$pos = $sth->rowCount() ? $sth->fetch(PDO::FETCH_OBJ)->position + 1 : 1;
		
		pdo()->prepare("INSERT INTO `product__optgroup`(`name`, `position`) VALUES (:name, :pos)")->execute([
			':name' => $name,
			':pos' => $pos
		]);
		
		result([
			'alert' => 'success',
			'message' => lang()->get('noty', 'add_content'),
			
			'content_groups' => Product::get_groups(),
			'content_category' => Product::get_category(),
			'content_selects' => Product::get_select_groups()
		]);
	endif;
	
	if(isset($_POST['category_save'])):
		$id = clean($_POST['id'], "int");
		$pos = clean($_POST['position'], "int");
		$name = clean($_POST['name']);
		$gip = clean($_POST['gip'], "int");
		
		try{
			pdo()
			->prepare("UPDATE `product__category` SET `oid`=:gip,`name`=:name,`position`=:pos WHERE `id`=:id LIMIT 1")
			->execute([':id' => $id, ':name' => $name, ':pos' => $pos, ':gip' => $gip]);
			
			result([
				'alert' => 'success',
				'message' => lang()->get('noty', 'save_data'),
				'content' => Product::get_category()
			]);
		}
		catch(Exception $e) {
			result([
				'alert' => 'warning',
				'message' => $e->getMessage()
			]);
		}
		catch(ParseError $e) {
			result([
				'alert' => 'error',
				'message' => $e->getMessage()
			]);
		}
	endif;
	
	if(isset($_POST['category_add'])):
		$name = clean($_POST['name']);
		$oid = clean($_POST['oid'], "int");
		$sth = pdo()->query("SELECT * FROM `product__category` WHERE 1 ORDER BY `position` DESC LIMIT 1");
		$pos = $sth->rowCount() ? $sth->fetch(PDO::FETCH_OBJ)->position + 1 : 1;
		
		pdo()->prepare("INSERT INTO `product__category`(`name`, `position`, `oid`) VALUES (:name, :pos, :oid)")->execute([
			':name' => $name,
			':pos' => $pos,
			':oid' => $oid
		]);
		
		result([
			'alert' => 'success',
			'message' => lang()->get('noty', 'add_content'),
			'content' => Product::get_category()
		]);
	endif;
	
	if(isset($_POST['category_delete'])):
		$id = clean($_POST['id'], "int");
		
		$sth = pdo()->query("SELECT * FROM `product` WHERE `category`='$id'");
		if($sth->rowCount()):
			while($row = $sth->fetch(PDO::FETCH_OBJ)):
				(new Product)->delete($row->id);
			endwhile;
		endif;
		
		pdo()->exec("DELETE FROM `product__category` WHERE `id`='$id' LIMIT 1");
		
		result([
			'alert' => 'success',
			'message' => lang()->get('noty', 'success_operation'),
			'content' => Product::get_category()
		]);
	endif;