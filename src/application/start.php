<?PHP
	@session_start();
	$database = (object)include(__DIR__ . '/configs/database.php');
	
	require_once(__DIR__ . "/configs/definition.php");
	require_once(__DIR__ . '/functions.php');
	
	spl_autoload_register(function() {
		$folders = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/library/'));

		foreach($folders as $file):
			if(!$file->isDir()):
				require_once($file->getPathname());
			endif;
		endforeach;
	});

	$pdo = create_pdo($database);
	$usr = new Users;
	$tpl = new Template;
	$conf = pdo()->query("SELECT * FROM `configs` LIMIT 1")->fetch(PDO::FETCH_OBJ);