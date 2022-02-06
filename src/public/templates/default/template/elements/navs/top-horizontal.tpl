<header class="container">
	<nav>
		<div class="row h-100">
			<div class="col">
				<div class="brand"><?=conf()->title;?></div>
			</div>
			<div class="col-auto profile" data-bs-toggle="offcanvas" data-bs-target="#panelTop" aria-controls="panelTop">
				<?if(isset($_SESSION['id'])): $user = usr()->get($_SESSION['id']);?>
				<span><?=($user->name . " " . $user->surname);?></span>
				<img src="<?=$user->ava;?>">
				<?else:?>
					<i class="fas fa-bars"></i>
				<?endif;?>
			</div>
		</div>
	</nav>
</header>
<div class="offcanvas offcanvas-top" tabindex="-1" id="panelTop">
	<div class="offcanvas-body">
		<ul>
			<li><a href="/">Главная</a></li>
			<?if(isset($_SESSION['id'])):?>
			<li><a href="/wallet">Кошелёк</a></li>
			<li><a href="/purchases">Покупки</a></li>
			<?if(usr()->access($_SESSION['id'], "a")):?>
			<li><a href="/admin">Админ панель</a></li>
			<?endif;?>
			<li><a href="/logout">Выйти</a></li>
			<?else:?>
			<li><a href="/login">Войти на сайт</a></li>
			<?endif;?>
		</ul>
	</div>
</div>