<html lang="ru">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<meta name="title" content="<?=conf()->title;?>">
		<meta name="description" content="<?=conf()->description;?>">
		<meta name="keywords" content="<?=conf()->keywords;?>">
		<meta name="author" content="Ruslan Dautov">
		<meta name="robots" content="all">
		<meta property="og:url" content="<?=sysconf['site_name'];?>">
		<meta property="og:type" content="website">
		<meta property="og:title" content="<?=conf()->title;?>">
		<meta property="og:description" content="<?=conf()->description;?>">
		<meta property="og:image" content="{assets}img/meta.jpg">
		<meta property="og:locale" content="alternate">
		
		<title>{title}</title>
		<link rel="icon" href="{assets}img/favicon.png" type="image/x-icon">
		<link rel="shortcut icon" href="{assets}img/favicon.png" type="image/x-icon">
		
		<!--[ Подгрузка стилей ]--> 
		<link rel="stylesheet" href="{assets}css/primary.css?v={cache}">
		
		<!--[ Подгрузка JS ]-->
		<script src="{assets}js/jquery.js?v={cache}"></script>
		<script src="{assets}js/popper.js?v={cache}"></script>
	</head>
	
	<body>
		<input type="hidden" id="token" value="{token}">
		{nav}
		
		<main>
			<div class="container">
				<div class="row">
					<div class="col-lg-1 d-none d-lg-block">
						<div class="card left-menu">
							<ul class="ui-mini-panel">
								<a href="/" data-bs-toggle="tooltip" data-bs-placement="right" title="Главная страница"><i class="fas fa-home"></i></a>
								<?if(isset($_SESSION['id'])):?>
								<a href="/wallet" data-bs-toggle="tooltip" data-bs-placement="right" title="Кошелёк"><i class="fas fa-wallet"></i></a>
								<a href="/purchases" data-bs-toggle="tooltip" data-bs-placement="right" title="Покупки"><i class="fas fa-shopping-cart"></i></a>
								<?else:?>
								<a href="/login" data-bs-toggle="tooltip" data-bs-placement="right" title="Войти на сайт"><i class="fas fa-user-lock"></i></a>
								<?endif;?>
								<a target="_blank" href="https://vk.com/worksmaru" data-bs-toggle="tooltip" data-bs-placement="right" title="Мы вконтакте"><i class="fab fa-vk"></i></a>
								<a target="_blank" href="https://worksma.ru" data-bs-toggle="tooltip" data-bs-placement="right" title="Торговая площадка"><i class="fab fa-connectdevelop"></i></a>
								<?if(isset($_SESSION['id'])):?>
								<a class="text-warning" href="/logout" data-bs-toggle="tooltip" data-bs-placement="right" title="Выйти"><i class="fas fa-sign-out-alt"></i></a>
								<?endif;?>
							</ul>
						</div>
					</div>
					<div class="col-lg-11 col-sm-12">
						{content}
					</div>
				</div>
			</div>
		</main>
		
		<footer class="mt-4 p-4">
			Копирайт &copy; 2022. Все права сохранены.
			Шаблон OSIRIS by <a class="dautov" href="https://vk.com/ieatbread" target="_blank">by Ruslan Dautov</a>.
		</footer>
		
		<!--[ Конечная подгрузка JS ]-->
		<script src="{assets}js/bootstrap.js?v={cache}"></script>
		<script src="{assets}js/primary.js?v={cache}"></script>
		<script src="https://kit.fontawesome.com/4e87f26727.js" crossorigin="anonymous"></script>
		
		<script src="{sitehost}application/performers/compressed/engine.min.js?v={cache}"></script>
		<script src="{sitehost}application/performers/compressed/main.min.js?v={cache}"></script>
	</body>
</html>