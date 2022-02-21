<li>
	<div class="input-group mb-2">
		<button class="btn btn-outline-secondary text-primary" onclick="category_save({id}, $('#cname_{id}').val(), $('#cpos_{id}').val(), $('#cselect_{id}').val());"><i class="far fa-save"></i></button>
		<button class="btn btn-outline-secondary text-danger" onclick="category_delete({id});"><i class="fas fa-trash-alt"></i></button>
		<select id="cselect_{id}" class="form-control">{select}</select>
		<input id="cname_{id}" type="text" class="form-control" placeholder="~{other:names}" value="{name}">
		<input id="cpos_{id}" type="number" min="1" class="form-control" placeholder="~{other:position}" value="{position}">
	</div>
</li>