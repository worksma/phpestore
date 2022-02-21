<div class="row">
	{products}
</div>

<div class="modal fade" tabindex="-1" id="full_open">
	<div class="modal-dialog">
		<form class="modal-content" id="form_buy">
			<input type="hidden" name="id" id="f_id">
			<div class="modal-header">
				<h5 id="f_name" class="modal-title"></h5>
				<button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
			</div>
			
			<div class="modal-body">
				<div id="carouselControl" class="carousel slide" data-bs-ride="carousel">
					<div class="carousel-inner" id="f_screenshot"></div>
					<button class="carousel-control-prev" type="button" data-bs-target="#carouselControl" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#carouselControl" data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Next</span>
					</button>
				</div>
				
				<p class="mt-4" id="f_description">none</p>
				<p class="mini-info">
					~{other:category}: <span id="f_category">None</span>
					~{other:price}: <span id="f_price">NaN</span>
				</p>
			</div>
			
			<div class="modal-footer">
				<?if(isset($_SESSION['id'])):?>
				<input type="submit" class="btn btn-primary" value="Купить">
				<?else:?>
				~{other:primarily_auth}
				<?endif;?>
			</div>
		</form>
	</div>
</div>