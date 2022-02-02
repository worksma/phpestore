<div class="tab-content">
	<div role="tabpanel" class="tab-pane fade in active show">
		<div class="container">
			<div class="row d-flex justify-content-center">
				<form class="col-lg-6 col-sm-12" id="form_login">
					<div class="row d-flex align-items-center" style="margin-top:10%;">
						<div class="col">
							<label for="login" class="mb-0">Логин:</label>
							<div class="input-group mb-3">
								<input type="text" class="form-control" placeholder="Логин" id="login" autocomplete="off" name="login">
							</div>
						</div>

						<div class="col">
							<label for="password" class="mb-0">Пароль:</label>
							<div class="input-group mb-3">
								<input type="password" class="form-control" placeholder="Пароль" id="password" autocomplete="off" name="password">
							</div>
						</div>
					</div>

					<div class="d-flex justify-content-end">
						<div class="mr-2 register">
							<a href="/register">Еще нет аккаунта?</a>
						</div>

						<?if(Apps::get_vk('1')->app_id):?>
						<button type="button" class="btn btn-primary mr-2" onclick="apps_login_vk();">
							Войти через <i class="fa fa-vk"></i>
						</button>
						<?endif;?>

						<button class="btn btn-primary">
							Войти
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>