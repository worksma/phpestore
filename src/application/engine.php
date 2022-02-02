<?PHP
    if(!file_exists(__DIR__ . '/configs/database.php')):
        require(__DIR__ . "/configs/install/view.php");
        exit;
    endif;

    require_once(__DIR__ . "/start.php");
    $_SESSION['token'] = md5($_SERVER['DOCUMENT_ROOT']);

    $folders = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/routing/'));
    foreach($folders as $file):
        if(!$file->isDir()):
            require_once($file->getPathname());
        endif;
    endforeach;

    Routing::execute($_SERVER['REQUEST_URI']);