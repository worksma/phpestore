<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>{title}</title>

		<meta property="og:image" content="{assets}img/logoog.png">
		<meta name="description" content="{description}">
		<meta name="keywords" content="{keywords}">

		<link href="{assets}img/code.svg" rel="icon" type="image/png">
		<link rel="stylesheet" href="{assets}css/primary.css?v={cache}">
		<link rel="stylesheet" href="{sitehost}public/addons/toasty/toasty.css?v={cache}">

		<script src="{assets}js/jquery-3.2.1.slim.min.js?v={cache}"></script>
		<script src="{assets}js/jquery-latest.min.js?v={cache}"></script>
		<script src="{assets}js/popper.min.js?v={cache}"></script>
		<script src="{assets}js/primary.js?v={cache}"></script>
		<script src="{assets}js/bootstrap.min.js?v={cache}"></script>

		<script src="{sitehost}application/performers/compressed/engine.min.js?v={cache}"></script>
		<script src="{sitehost}application/performers/compressed/main.min.js?v={cache}"></script>
	</head>

	<body>
		<input type="hidden" id="token" value="{token}">
		
		<div class="preloader">
			<div class="spinner-border float-right" style="width:60px; height:60px" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>

		<div style="background:#fff;" class="sticky-top ">
			{nav}
		</div>

		<div class="container wrapper" style="min-height:376px;">
			{content}
		</div>

		<div class="container-fluid footer-bg" style="margin-top:82px;">
			<div class="container">
				<footer>
					<div class="row col-sm-12">
						<div class="col-sm-5 foo-left-box">
							<a class="navbar-brand" href="#">
								PHP eStore
							</a>

							<div class="nav-logo">
								<span class="footer-ava-text">&copy; 2021, Торговая площадка WORKSMA.</span> Все права защищены.<br>
							</div>
						</div>
					</div>
				</footer>
			</div>
		</div>

		<script src="https://kit.fontawesome.com/4e87f26727.js" crossorigin="anonymous"></script>
		<script src="{assets}js/script.js?v={cache}"></script>
	</body>
</html>