<li>
	<div class="input-group mb-2">
		<button class="btn btn-outline-secondary text-primary" onclick="group_save({id}, $('#gname_{id}').val(), $('#gpos_{id}').val());"><i class="far fa-save"></i></button>
		<button class="btn btn-outline-secondary text-danger" onclick="group_delete({id});"><i class="fas fa-trash-alt"></i></button>
		<input id="gname_{id}" type="text" class="form-control" placeholder="Наименование" value="{name}">
		<input id="gpos_{id}" type="number" min="1" class="form-control" placeholder="Позиция" value="{position}">
	</div>
</li>