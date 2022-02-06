<div class="row d-flex justify-content-center">
	<form class="col-lg-4" id="form_login">
		<h4 class="text-center">Вход на сайт</h4>
	
		<input type="text" name="login" class="form-control" placeholder="Логин" autocomplete="off">
		<input type="password" name="password" class="form-control mt-2" placeholder="Пароль" autocomplete="off">
		
		<input type="submit" class="btn btn-success w-100 mt-2" value="Войти">
		<?if(Apps::get_vk('1')->app_id):?>
		<button class="btn btn-primary w-100 mt-2" onclick="apps_login_vk();">Войти через <i class="fab fa-vk"></i></button>
		<?endif;?>
		
		<div class="d-flex justify-content-center">
			<a href="/register">Нет аккаунта?</a>
		</div>
	</form>
</div>