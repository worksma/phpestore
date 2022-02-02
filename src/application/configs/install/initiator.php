<?PHP
	if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/application/configs/database.php')):
		header("Location: /");
		exit;
	endif;
	
	if(isset($_POST['check_mysql'])):
		try {
			$pdo = new PDO("mysql:host={$_POST['hostname']};dbname={$_POST['dataname']}", $_POST['username'], $_POST['password']);
			$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$pdo->exec("set names utf8");
			
			exit(json_encode([
				'alert' => 'success',
				'message' => 'Успешное подключение!'
			]));
		}
		catch(PDOException $e) {
			exit(json_encode([
				'alert' => 'error',
				'message' => $e->getMessage()
			]));
		}
	endif;
	
	if(isset($_POST['install'])):
		try {
			$pdo = new PDO("mysql:host={$_POST['hostname']};dbname={$_POST['dataname']}", $_POST['username'], $_POST['password']);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$pdo->exec("set names utf8");
			$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);
			
			if($pdo
			->prepare(trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/application/configs/install/dump.sql')))
			->execute([
				':title'		=> $_POST['project'],
				':description'	=> $_POST['description'],
				':keywords'		=> $_POST['keywords'],
				':template'		=> $_POST['template']
			])):
				if(file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/application/configs/database.php", "<?PHP
	return [
		'hostname' => '{$_POST['hostname']}',
		'dataname' => '{$_POST['dataname']}',
		'username' => '{$_POST['username']}',
		'password' => '{$_POST['password']}'
	];")):
					exit(json_encode([
						'alert' => 'success',
						'message' => 'Установка прошла успешно!'
					]));
				else:
					exit(json_encode([
						'alert' => 'error',
						'message' => 'Ошибка при создании файла application/configs/database.php'
					]));
				endif;
			else:
				exit(json_encode([
					'alert' => 'error',
					'message' => 'Ошибка при импорте базы данных.'
				]));
			endif;
		}
		catch(PDOException $e) {
			exit(json_encode([
				'alert' => 'error',
				'message' => $e->getMessage()
			]));
		}
	endif;