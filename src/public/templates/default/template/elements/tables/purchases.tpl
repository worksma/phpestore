<div class="ui mb-4">
	<ul>
		<li class="col-1 d-flex justify-content-start">#{id}</li>
		<li class="col-4 d-flex justify-content-start">{name}</li>
		<li class="col-1">{price} &#8381;</li>
		<li class="col-3">{date}</li>
		<li class="col-3 d-flex justify-content-end">
			<button class="btn btn-info btn-sm me-2" onclick="download({id});">~{purchases:download}</button>
			<button class="btn btn-danger btn-sm" onclick="delete_purchases({id});">~{purchases:delete}</button>
		<li>
	</ul>
</div>