function get_product(pid) {
	send_post(url("main"), serializeform(new FormData, {get_product: 1, id: pid}), (result) => {
		if(result.alert == 'success') {
			$("#f_id").val(pid);
			$("#f_name").html(result.name);
			$("#f_price").html(result.price);
			$("#f_description").html(result.description);
			$("#f_screenshot").html(result.images);
			$("#f_category").html(result.category);
			
			preImage();
			$("#full_open").modal("show");
		}
		else {
			push(result.message, result.alert);
		}
	});
}

function delete_purchases(id) {
	if(confirm("Вы действительно хотите удалить покупку?")) {
		send_post(url("main"), serializeform(new FormData, {
			delete_purchases: 1,
			id: id
		}), (result) => {
			$("#purchases").html(result);
		});
		}
}

function apps_login_vk() {
	send_post(url("main"), serializeform(new FormData, {
		user_login_vk: 1
	}), (result) => href(result));
}

function get_reviews() {
	send_post(url("main"), serializeform(new FormData, {
		reviews: 1
	}), (result) => $("#reviews").html(result));
}

function send_reviews() {
	send_post(url("main"), serializeform(new FormData, {
		send_reviews: 1,
		message: $("#message").val()
	}), (result) => {
		if(result.alert == 'success') {
			$("#message").val();
			get_reviews();
		}
		
		push(result.message, result.alert);
	});
}

function kassa_create(code, price) {
	send_post(url("main"), serializeform(new FormData, {
		kassa_create: 1,
		code_name: code,
		price: price
	}), (result) => {
		if(result.alert == 'success') {
			href(result.url);
		}
	});
}

function download(id) {
	send_post(url("main"), serializeform(new FormData, {
		download: 1,
		id: id
	}), (result) => {
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
		
		send_post(url("main"), serializeform(new FormData(this), {
			user_login: 1
		}), (result) => {
			if(result.alert == 'success') {
				setTimeout(href("/"), 300);
			}
			
			push(result.message, result.alert);
		});
	});

	$("#form_register").submit(function(e) {
		e.preventDefault();
		
		send_post(url("main"), serializeform(new FormData(this), {
			user_register: 1
		}), (result) => {
			if(result.alert == 'success') {
				setTimeout(href("/"), 300);
			}
			
			push(result.message, result.alert);
		});
	});
	
	$("#form_buy").submit(function(e) {
		e.preventDefault();

		send_post(url("main"), serializeform(new FormData(this), {
			buy_product: 1
		}), (result) => {
			if(result.alert == 'success') {
				$('#full_open').modal('hide');
			}
			
			push(result.message, result.alert);
		});
	});
});