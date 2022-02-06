<div class="row wallet">
	<div class="col-lg-12 mb-4">
		<div class="card">
			<div class="row">
				<div class="col p-4 text-center expenses" data-bs-toggle="tooltip" data-bs-placement="top" title="В разработке">
					<h5>Потрачено</h5>
					<span>NaN &#8381;</span>
				</div>
				<div class="col p-4 text-center balance">
					<h5>Текущий баланс</h5>
					<span><?=usr()->get($_SESSION['id'])->balance;?> &#8381;</span>
				</div>
			</div>
		</div>
	</div>
	
	<?$pay = new Pay;
		if($pay->is_enable('qiwi')):?>
	<div class="col-lg-4 col-sm-12 mb-4">
		<div class="card">
			<div class="card-footer">
				<img class="w-100 mb-4" src="{assets}img/wallet/qiwi.png">
				<div class="input-group">
					<button class="btn btn-primary" type="button" onclick="kassa_create('qiwi', $('#qiwi').val());"><i class="fas fa-heart"></i></button>
					<input class="form-control" placeholder="Сумма" id="qiwi" autocomplete="off">
				</div>
			</div>
		</div>
	</div>
	<?endif;?>

	<?if($pay->is_enable('freekassa')):?>
	<div class="col-lg-4 col-sm-12 mb-4">
		<div class="card">
			<div class="card-footer">
				<img class="w-100 mb-4" src="{assets}img/wallet/fk_light.png">
				<div class="input-group">
					<button class="btn btn-primary" type="button" onclick="kassa_create('freekassa', $('#freekassa').val());"><i class="fas fa-heart"></i></button>
					<input class="form-control" placeholder="Сумма" id="freekassa" autocomplete="off">
				</div>
			</div>
		</div>
	</div>
	<?endif;?>
</div>