<div class="row groups">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-lg-6 col-sm-12">
						<h5 class="card-title">Группы</h5>
						
						<div class="input-group mb-4">
							<input type="text" class="form-control" placeholder="Наименование" id="group_name">
							<button type="button" class="btn btn-info" onclick="group_add();">Добавить</button>
						</div>
						
						<ul id="groups">{groups}</ul>
					</div>
					
					<div class="col-lg-6 col-sm-12">
						<h5 class="card-title">Категории</h5>
						
						<div class="input-group mb-4">
							<input type="text" class="form-control" placeholder="Наименование" id="category_name">
							<select class="form-select" id="selects">{options}</select>
							<button type="button" class="btn btn-info" onclick="category_add();">Добавить</button>
						</div>
						
						<ul id="category">{category}</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>