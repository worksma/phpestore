<?PHP
	require($_SERVER['DOCUMENT_ROOT'] . "/application/start.php");

	if(empty($_POST['php_action'])):
		result([
			'alert'			=> 'error',
			'message'		=> 'Прямой вызов скрипта'
		]);
	endif;

	if($_SESSION['token'] != $_POST['token']):
		result([
			'alert'			=> 'error',
			'message'		=> 'Неверный токен'
		]);
	endif;

	if(!usr()->access($_SESSION['id'], "a")):
		result([
			'alert'			=> 'error',
			'message'		=> 'Недостаточно прав'
		]);
	endif;

	if(isset($_POST['truncate_reviews'])):
		pdo()->exec("TRUNCATE `reviews`;");

		result([
			'alert'			=> 'success'
		]);
	endif;

	if(isset($_POST['truncate_pays'])):
		pdo()->exec("TRUNCATE `logs__pays`;");

		result([
			'alert'			=> 'success'
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
			'alert'			=> 'success'
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
			'alert'			=> 'success'
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
		->prepare("INSERT INTO `product`(`name`, `description`, `price`, `image`, `file`, `date`) VALUES (:name, :description, :price, :image, :file, :date)")
		->execute([
			':name'				=> $_POST['title'],
			':description'		=> $_POST['description'],
			':price'			=> $_POST['price'],
			':image'			=> $image,
			':file'				=> $file,
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
			'alert'			=> 'success'
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
			'alert'		=> 'success'
		]);
	endif;