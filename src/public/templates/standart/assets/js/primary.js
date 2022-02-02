$(window).on("load", function() {
	$preloader = $(".preloader");
	$preloader.fadeIn(200).delay(250).fadeOut(700);
});

$(function() {
	const fimage = document.getElementsByClassName("fimage");
	Array.from(fimage).map((item) => {
		const img = new Image();
		img.src = item.dataset.src;

		img.onload = () => {
			return item.nodeName === "IMG" ?
				item.src = item.dataset.src :
				item.style.backgroundImage = `url('${item.dataset.src}')`;
		}
	});

	$("[data-toggle='tooltip']").tooltip();
});