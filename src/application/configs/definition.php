<?PHP
	define("sysconf", [
		'root'				=> $_SERVER['DOCUMENT_ROOT'],
		'site_name'			=> 'https://' . $_SERVER['SERVER_NAME'] . '/',
		'application'		=> $_SERVER['DOCUMENT_ROOT'] . "/application/",
		'extensions'		=> $_SERVER['DOCUMENT_ROOT'] . "/application/extensions/",
		'avatars'			=> "/public/uploads/images/avatars/"
	]);