<div class="tab-content">
	<div role="tabpanel" class="tab-pane fade in active show">
		<div class="container">
			<div class="row d-flex justify-content-center">
				{products}
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" id="full_open">
	<div class="modal-dialog">
		<form class="modal-content" id="form_buy">
			<div class="modal-header">
				<h5 class="modal-title">Покупка товара</h5>
				<button type="button" class="close" data-dismiss="modal" id="close_add" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<div class="thumbnail">
					<div id="screenshots" class="carousel slide" data-ride="carousel">
						<div class="carousel-inner" id="f_screenshot"></div>

						<a class="carousel-control-prev" href="#screenshots" role="button" data-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>

						<a class="carousel-control-next" href="#screenshots" role="button" data-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
					</div>

					<div class="caption">
						<input type="hidden" name="id" id="f_id">
						<p class="game-name" id="f_name">none</p>
						<p class="game-type"><img src="{assets}img/icon.png" class="game-activate-icon">
							<span id="f_description">none</span>
						</p>
						<p><span class="game-name" id="f_price">none</span></p>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
				<button class="btn btn-primary">Купить</button>
			</div>
		</form>
	</div>
</div>