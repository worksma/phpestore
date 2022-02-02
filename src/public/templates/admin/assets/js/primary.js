function collapse(id) {
    if($("#" + id).hasClass("collapse")) {
        $("#" + id).removeClass("collapse");
    }
    else {
        $("#" + id).addClass("collapse");
    }
}