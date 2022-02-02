<div class="tab-content">
	<div role="tabpanel" class="tab-pane fade in active show">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12">
					<?if(isset($_SESSION['id'])):?>
					<div class="form-group">
						<textarea class="form-control" rows="3" placeholder="Напишите, что Вы думаете..." id="message"></textarea>
						<small class="text-muted">Сообщение не поддерживает HTML тегов.</small>

						<div class="d-flex justify-content-end">
							<button class="btn btn-primary mt-2" onclick="send_reviews();">Оставить отзыв</button>
						</div>
					</div>
					<?else:?>
					<center>
						Для того, чтобы оставить отзыв сначала <a href="/login"> Авторизуйтесь</a>
					</center>
					<?endif;?>
				</div>

				<div class="col-lg-12 col-sm-12" id="reviews"><script>get_reviews();</script></div>
			</div>
		</div>
	</div>
</div>