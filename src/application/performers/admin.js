function truncate_reviews() {
	if(confirm("Вы действительно хотите очистить отзывы?")) {
		var form = new FormData;
		form.append("truncate_reviews", "1");
		send_post(url("application/performers/actions/admin.php"), form, () => {});
	}
}

function truncate_pays() {
	if(confirm("Вы действительно хотите очистить логи пополнений?")) {
		var form = new FormData;
		form.append("truncate_pays", "1");
		send_post(url("application/performers/actions/admin.php"), form, () => {});
	}
}

function save(type, value) {
	var form = new FormData;
	form.append("save", "1");

	form.append("type", type);
	form.append("value", value);
	
	send_post(url("application/performers/actions/admin.php"), form, () => {});
}

function save_product(type, id, value) {
	var form = new FormData;
	form.append("save_product", "1");

	form.append("type", type);
	form.append("id", id);
	form.append("value", value);
	
	send_post(url("application/performers/actions/admin.php"), form, () => {});
}

function save_user(type, uid, value) {
	var form = new FormData;
	form.append("save_user", "1");

	form.append("type", type);
	form.append("uid", uid);
	form.append("value", value);
	
	send_post(url("application/performers/actions/admin.php"), form, () => {});
}

function product_delete(id) {
	alert("После удаления товара последует удаление покупок данного товара, это может сказаться на количестве отображемой прибыли.");

	if(confirm("Вы действительно хотите удалить товар?")) {
		var form = new FormData;
		form.append("product_delete", "1");
		form.append("id", id);

		send_post(url("application/performers/actions/admin.php"), form, function(result) {
			$("#products").html(result);
		});
	}
}

function download_update(version) {
	var form = new FormData;
	form.append("download_update", "1");
	form.append("version", version);

	send_post(url("application/performers/actions/admin.php"), form, function(result) {
		location.reload();
	});
}

$(function() {
	$("#form_add_product").submit(function(e) {
		e.preventDefault();

		var form = new FormData(this);
		form.append("add_product", "1");

		send_post(url("application/performers/actions/admin.php"), form, function(result) {
			if(result.alert != 'error') {
				$('#form_add_product').trigger("reset");
				location.reload();
			}
		});
	});

	$("#form_replace_file").submit(function(e) {
		e.preventDefault();
		var form = new FormData(this);
		form.append("replace_file", "1");
		send_post(url("application/performers/actions/admin.php"), form, () => {});
	});
});