<?
	require(__DIR__ . "/configs.php");
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<title>Установка | PHP eStore</title>
		
		<link rel="shortcut icon" href="<?=SERVER_NAME;?>favicon.ico">
		<link href="<?=SERVER_NAME;?>public/addons/toasty/toasty.css" rel="stylesheet" type="text/css">
		<link href="<?=ASSETS;?>css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="<?=ASSETS;?>css/custom.css" rel="stylesheet" type="text/css">

		<script src="<?=ASSETS;?>js/jquery-3.6.0.min.js"></script>
		<script src="<?=ASSETS;?>js/popper.min.js"></script>

		<script src="<?=SERVER_NAME;?>application/performers/compressed/engine.min.js"></script>
	</head>
	
	<body>
		<header class="sticky-top">
			<nav class="navbar navbar-expand-lg">
				<div class="container-fluid container">
					<a href="https://worksma.ru" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Перейти на сайт разработчиков" class="navbar-brand mb-0 h1" style="cursor:pointer;">
						PHP eStore - интернет магазин
					</a>
				</div>
			</nav>
		</header>
	
		<main>
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-sm-12 mb-4">
						<div class="card padding">
							<div class="card-header text-center">
								Проверка подключения
							</div>
							<form class="card-body" id="form_mysql">
								<input type="text" autocomplete="off" class="form-control mb-2" placeholder="Адрес хостинга" name="hostname" id="hostname" required>
								<input type="text" autocomplete="off" class="form-control mb-2" placeholder="Имя базы данных" name="dataname" id="dataname" required>
								<input type="text" autocomplete="off" class="form-control mb-2" placeholder="Пользователь" name="username" id="username" required>
								<input type="text" autocomplete="off" class="form-control mb-2" placeholder="Пароль" name="password" id="password" required>
								
								<input type="submit" class="btn bg-default w-100" value="Проверить подключение">
							</form>
						</div>
					</div>
					
					<div class="col-lg-8 col-sm-12">
						<div class="card padding">
							<div class="card-header text-center">
								Конфигурации сайта
							</div>
							<form class="card-body" id="form_install">
								<div class="row">
									<div class="col-lg-6">
										<input name="project" type="text" class="form-control mb-2" placeholder="Наименование сайта" value="PHP eStore" required>
									</div>
									<div class="col-lg-6">
										<input name="description" type="text" class="form-control mb-2" placeholder="Описание сайта" value="Здесь вы можете купить готовый сайт для заработка или других целей. Магазин скриптов PHP eStore предоставляет огромный выбор качественных сайтов." required>
									</div>
									<div class="col-lg-6">
										<input name="keywords" type="text" class="form-control mb-2" placeholder="Теги сайта" value="создание сайта, создать сайт самому, скрипт, скачать скрипты бесплатно, скачать скрипты, скрипты для сайта, скрипты сайтов, движки сайтов, Интернет-магазин, skript, opcash, денежные кейсы, кейсы с деньгами, скрипты буксов, буксы, Хайпы, экономический игры, азартные игры, скрипт интернет магазина, магазин аккаунтов, скрипты рулеток, cosmocard, jetcash, spinmoney, bangcash, armycash, luxacesh, cash, рулетки cs:go, скрипт cs:go рулетки, заработок в сети, заработок в интернете, софт для веб-мастера, взлом рулетки с денежными кейсы, взлом opcash, создание сайта под заказ, создать сайт, заказать сайт, купить сайт, купить opcash, как установить сайт, установка скрипты, как установить скрипт, Купить рулетку, скрипт кейсов, купить web скрипт, купить сайт, рулетка варфейс, рулетка warface, заказать рулетку, купить недорого web скрипт, купить nvuti, скрипт nvuti,купить веб скрипт,магазин скриптов, купить скрипт рулетки,магазин скриптов рулеток,купить рулетку сайт, nvuti" required>
									</div>
									<div class="col-lg-6">
										<select class="form-control mb-2" name="template">
											<option value="default">Стандартный шаблон</option>
										</select>
									</div>
								</div>
								
								<input id="b_install" type="submit" class="btn bg-default w-100" value="Установить" disabled>
							</form>
						</div>
					</div>
				</div>
			</div>
		</main>

		<script src="<?=SERVER_NAME;?>public/addons/toasty/toasty.js"></script>
		<script src="<?=ASSETS;?>js/bootstrap.min.js"></script>
		<script src="<?=ASSETS;?>js/custom.js"></script>
	</body>
</html>