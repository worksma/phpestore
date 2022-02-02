function url(patch = "application/performers/actions/main.php") {
	return "https://" + location.host + "/" + patch;
}

function send_post(site, form, callback, method = "POST") {
	form.append("php_action", "1");
	form.append("token", $("#token").val());

	$.ajax({
		type: method,
		url: site,
		processData: false,
		contentType: false,
		data: form,
		dataType: "json",
		success: function(result) {
			callback(result);
		}
	});
}

function href(url) {
	location.href = url;
}

function push(message, type = "info") {
	var toast = new Toasty({
		classname: "toast",
		transition: "slideLeftRightFade",
		insertBefore: false,
		progressBar: true,
		enableSounds: true
	});

	switch(type) {
		case "success":
			toast.success(message);
		break;

		case "error":
			toast.error(message);
		break;

		case "danger":
			toast.error(message);
		break;

		case "warning":
			toast.warning(message);
		break;

		default:
			toast.info(message);
		break;
	}
}