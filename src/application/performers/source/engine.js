$(function() {
	preImage();
});

function preImage() {
	const fimage = document.getElementsByClassName("preImage");
	Array.from(fimage).map((item) => {
		const img = new Image();
		img.src = item.dataset.src;
		
		img.onload = () => {
			return item.nodeName === "IMG" ?
				item.src = item.dataset.src :
				item.style.background = `url('${item.dataset.src}')`;
		}
	});	
}

function url(file = null) {
	if(file == null) {
		return "https://" + location.host + "/";
	}
	
	return "https://" + location.host + "/application/performers/" + file + ".php";
}

function include(url, type = "script") {
	switch(type) {
		case "style":
			$("head").append("<link rel='stylesheet' href='" + url + "'>");
		break;
		
		default:
			$("head").append("<script src='" + url + "'></script>");
		break;
	}
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
		case "success": toast.success(message); break;
		case "error": toast.error(message); break;
		case "danger": toast.error(message); break;
		case "warning": toast.warning(message); break;
		default: toast.info(message); break;
	}
}

function preview(binding, ending) {
	$(binding).bind("change", function() {
		if(this.files[0]) {
			fr(this.files[0], ending);
		}
	});
}

function serializeform(form, data) {
	for(var i in data) {
		form.append(i, data[i]);
	}
	
	return form;
}


function fr(file, ending) {
	var file_reader = new FileReader;

	$(file_reader).bind("load", function() {
		$(ending).css("background", "url('" + file_reader.result + "')");
	});

	file_reader.readAsDataURL(file);
}

include("/public/addons/toasty/toasty.css", "style");
include("/public/addons/toasty/toasty.js");