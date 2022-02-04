<?PHP
    if(!file_exists(__DIR__ . '/configs/database.php')):
        require(__DIR__ . "/configs/install/view.php");
        exit;
    endif;
	
    require_once(__DIR__ . "/start.php");
	$_SESSION['token'] = hash("sha256", sysconf['root'] . date("Ymd"));
	
	/*
		Компрессор JS
	*/
	$folders = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/performers/source/'));
    foreach($folders as $file):
        if(!$file->isDir()):
			$a = extFile($file->getPathname());
			
			$temp = __DIR__ . "/performers/compressed/{$a['name']}.min.{$a['ext']}";
			$src = JsCompress::construct(file_get_contents($file->getPathname()));
			
			if(file_exists($temp)):
				if(md5(file_get_contents($temp)) != md5($src)):
					file_put_contents($temp, $src);
				endif;
			else:
				file_put_contents($temp, $src);
			endif;
        endif;
    endforeach;
	
	/*
		Роутинг
	*/
	$folders = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/routing/'));
    foreach($folders as $file):
        if(!$file->isDir()):
            require_once($file->getPathname());
        endif;
    endforeach;

    Routing::execute($_SERVER['REQUEST_URI']);