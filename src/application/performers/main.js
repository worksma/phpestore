function get_product(id) {
	var form = new FormData;
	form.append("get_product", "1");
	form.append("id", id);

	send_post(url(), form, function(result) {
		if(result.alert == 'success') {
			$("#f_id").val(id);
			$("#f_name").html(result.name);
			$("#f_price").html(result.price);
			$("#f_description").html(result.description);
			$("#f_screenshot").html(result.images);

			$('#full_open').modal('show');
		}
		else {
			push(result.message, result.alert);
		}
	});
}

function delete_purchases(id) {
	if(confirm("Вы действительно хотите удалить покупку?")) {
		var form = new FormData;
		form.append("delete_purchases", "1");
		form.append("id", id);

		send_post(url(), form, function(result) {
			$("#purchases").html(result);
		});
	}
}

function apps_login_vk() {
	var form = new FormData;
	form.append("user_login_vk", "1");

	send_post(url(), form, function(result) {
		location.href = result;
	});
}

function get_reviews() {
	var form = new FormData;
	form.append("reviews", "1");

	send_post(url(), form, function(result) {
		
	});
}

function get_reviews() {
	var form = new FormData;
	form.append("reviews", "1");

	send_post(url(), form, function(result) {
		$("#reviews").html(result);
	});
}

function send_reviews() {
	var form = new FormData;
	form.append("send_reviews", "1");
	form.append("message", $("#message").val());

	send_post(url(), form, function(result) {
		if(result.alert == 'success') {
			$("#message").val("");
			get_reviews();
		}

		push(result.message, result.alert);
	});
}

function kassa_create(code, price) {
	var form = new FormData;
	form.append("kassa_create", "1");
	form.append("code_name", code);
	form.append("price", price);

	send_post(url(), form, function(result) {
		if(result.alert == 'success') {
			href(result.url);
		}
	});
}

function download(id) {
	var form = new FormData;
	form.append("download", "1");
	form.append("id", id);

	send_post(url(), form, function(result) {
		if(result.alert == 'success') {
			var link = document.createElement('a');
			link.setAttribute('href', result.file);
			link.setAttribute('download', result.filename);
			link.click();
		}

		push(result.message, result.alert);
	});
}

$(function() {
	$("#form_login").submit(function(e) {
		e.preventDefault();

		var form = new FormData(this);
		form.append("user_login", "1");

		send_post(url(), form, function(result) {
			if(result.alert == 'success') {
				setTimeout('location.href = "/"', 300);
			}

			push(result.message, result.alert);
		});
	});

	$("#form_register").submit(function(e) {
		e.preventDefault();

		var form = new FormData(this);
		form.append("user_register", "1");

		send_post(url(), form, function(result) {
			if(result.alert == 'success') {
				setTimeout('location.href = "/login"', 300);
			}

			push(result.message, result.alert);
		});
	});

	$("#form_buy").submit(function(e) {
		e.preventDefault();

		var form = new FormData(this);
		form.append("buy_product", "1");

		send_post(url(), form, function(result) {
			if(result.alert == 'success') {
				$('#full_open').modal('hide');
			}
			
			push(result.message, result.alert);
		});
	});
});