<div class="row d-flex justify-content-center">
	<form class="col-lg-6" id="form_register">
		<h4 class="text-center">~{register:title}</h4>
		
		<div class="row">
			<div class="col-lg-6 col-sm-12 mb-2">
				<input type="text" name="name" class="form-control" placeholder="~{register:first_name}" autocomplete="off">
			</div>
			<div class="col-lg-6 col-sm-12 mb-2">
				<input type="text" name="surname" class="form-control" placeholder="~{register:last_name}" autocomplete="off">
			</div>
			
			<div class="col-lg-6 col-sm-12 mb-2">
				<input type="text" name="login" class="form-control" placeholder="~{register:username}" autocomplete="off">
			</div>
			
			<div class="col-lg-6 col-sm-12 mb-2">
				<input type="password" name="password" class="form-control" placeholder="~{register:password}" autocomplete="off">
			</div>
		</div>
		
		<div class="d-flex justify-content-end align-items-center">
			<a href="/login" class="me-2">~{register:login}</a>
			<input type="submit" class="btn btn-success" value="~{register:sumbit}">
		</div>
	</form>
</div>