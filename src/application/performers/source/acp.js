function truncate_reviews() {
	if(confirm("Вы действительно хотите очистить отзывы?")) {
		send_post(url("acp"), serializeform(new FormData, {
			truncate_reviews: 1
		}), (result) => push(result.message, result.alert));
	}
}

function truncate_pays() {
	if(confirm("Вы действительно хотите очистить отзывы?")) {
		send_post(url("acp"), serializeform(new FormData, {
			truncate_pays: 1
		}), (result) => push(result.message, result.alert));
	}
}

function update_cache() {
	send_post(url("acp"), serializeform(new FormData, {
		update_cache: 1
	}), (result) => push(result.message, result.alert));
}

function save(type, value) {
	send_post(url("acp"), serializeform(new FormData, {
		save: 1, type: type, value: value
	}), (result) => push(result.message, result.alert));
}

function save_product(type, id, value) {
	send_post(url("acp"), serializeform(new FormData, {
		save_product: 1, type: type, id: id, value: value
	}), (result) => push(result.message, result.alert));
}

function save_user(type, uid, value) {
	send_post(url("acp"), serializeform(new FormData, {
		save_user: 1, type: type, uid: uid, value: value
	}), (result) => push(result.message, result.alert));
}

function product_delete(id) {
	alert("После удаления товара последует удаление покупок данного товара, это может сказаться на количестве отображемой прибыли.");
	
	if(confirm("Вы действительно хотите удалить товар?")) {
		send_post(url("acp"), serializeform(new FormData, {
			product_delete: 1,
			id: id
		}), (result) => $("#products").html(result));
	}
}

function download_update(version) {
	send_post(url("acp"), serializeform(new FormData, {
		download_update: 1,
		version: version
	}), () => location.reload());
}


$(function() {
	$("#form_add_product").submit(function(e) {
		e.preventDefault();
		
		send_post(url("acp"), serializeform(new FormData(this), {
			add_product: 1
		}), (result) => {
			if(result.alert != 'error') {
				$('#form_add_product').trigger("reset");
				location.reload();
			}
		});
	});

	$("#form_replace_file").submit(function(e) {
		e.preventDefault();
		
		send_post(url("acp"), serializeform(new FormData(this), {
			replace_file: 1
		}), (result) => push(result.message, result.alert));
	});
});