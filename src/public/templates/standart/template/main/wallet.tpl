<div class="tab-content">
	<div role="tabpanel" class="tab-pane fade in active show">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-sm-12 mb-2 table-responsive">
					<table class="table">
						<thead>
							<tr class="text-center">
								<th scope="col">#</th>
								<th scope="col">Операция</th>
								<th scope="col">Система</th>
								<th scope="col">Сумма</th>
								<th scope="col">Дата</th>
							</tr>
						</thead>

						<tbody>
							{purse}
						</tbody>
					</table>
				</div>

				<div class="col-lg-4 col-sm-12">
					<?
						$pay = new Pay;
						if($pay->is_enable('qiwi')):
					?>
					<div class="input-group wallet mb-2">
						<img src="{assets}img/wallet/qiwi.png" class="w-100 mb-2">
						<button class="btn btn-primary" type="button" onclick="kassa_create('qiwi', $('#qiwi').val());">Пополнить</button>
						<input class="form-control" placeholder="Сумма" id="qiwi">
					</div>
					<?endif;?>

					<?if($pay->is_enable('free-kassa')):?>
					<div class="input-group wallet mb-4">
						<img src="{assets}img/wallet/free-kassa.png" class="w-100 mb-2">
						<button class="btn btn-primary" type="button" onclick="kassa_create('free-kassa', $('#free-kassa').val());">Пополнить</button>
						<input class="form-control" placeholder="Сумма" id="free-kassa">
					</div>
					<?endif;?>
				</div>
			</div>
		</div>
	</div>
</div>