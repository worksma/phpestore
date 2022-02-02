$(function(){
	$("#form_mysql").submit(function(event) {
		event.preventDefault();
		var form_data = new FormData(this);
		form_data.append("check_mysql", "1");
		
		send_post(url("application/configs/install/initiator.php"), form_data, function(result) {
			if(result.alert == 'success') {
				$("#b_install").removeAttr("disabled");
			}
			
			push(result.message, result.alert);
		});
	});
	
	$("#form_install").submit(function(event) {
		event.preventDefault();
		var form_data = new FormData(this);
		form_data.append("install", "1");
		form_data.append("hostname", $("#hostname").val());
		form_data.append("dataname", $("#dataname").val());
		form_data.append("username", $("#username").val());
		form_data.append("password", $("#password").val());
		
		send_post(url("application/configs/install/initiator.php"), form_data, function(result) {
			if(result.alert == 'success') {
				location.reload();
			}
			
			push(result.message, result.alert);
		});
	});
	
	$('[data-bs-toggle="tooltip"]').tooltip();
});

