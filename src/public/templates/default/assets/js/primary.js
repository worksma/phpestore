$(function() {
	$('[data-bs-toggle="tooltip"]').tooltip();
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

function get_product2(pid) {
	send_post(url("main"), serializeform(new FormData, {get_product: 1, id: pid}), (result) => {
		if(result.alert == 'success') {
			$("#f_id").val(pid);
			$("#f_name").html(result.name);
			$("#f_price").html(result.price);
			$("#f_description").html(result.description);
			$("#f_screenshot").html(result.images);
			
			preImage();
			$("#full_open").modal("show");
		}
		else {
			push(result.message, result.alert);
		}
	});
}