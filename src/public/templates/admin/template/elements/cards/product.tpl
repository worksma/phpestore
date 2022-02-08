  <div class="col-lg-4">
    <div class="card">
      <img src="{image}" class="card-img-top" alt="{name}">
      <div class="card-body">

        <div class="row">
          <div class="col-lg-6 mb-2">
            <button class="btn btn-danger w-100" onclick="product_delete('{id}');"><i class="far fa-trash-alt"></i></button>
          </div>

          <div class="col-lg-6">
            <button class="btn btn-primary w-100" onclick="collapse('collapse_{id}');"><i class="far fa-edit"></i></button>
          </div>
        </div>

        <div class="collapse" id="collapse_{id}">
          <label for="name{id}" class="form-label mb-0">Название</label>
          <div class="input-group mb-3">
            <button class="btn btn-outline-secondary" type="button" onclick="save_product('name', '{id}', $('#name{id}').val());">
              <i class="far fa-save"></i>
            </button>

            <input id="name{id}" type="text" class="form-control" value="{name}">
          </div>

          <label for="description{id}" class="form-label mb-0">Описание</label>
          <div class="input-group mb-3">
            <button class="btn btn-outline-secondary" type="button" onclick="save_product('description', '{id}', $('#description{id}').val());">
              <i class="far fa-save"></i>
            </button>
            
            <textarea id="description{id}" class="form-control">{description}</textarea>
          </div>
		  
		  <label for="category{id}" class="form-label mb-0">Категория</label>
		  <div class="input-group mb-3">
            <button class="btn btn-outline-secondary" type="button" onclick="save_product('category', '{id}', $('#category{id}').val());">
              <i class="far fa-save"></i>
            </button>
			
			<select class="form-select" id="category{id}">{options}</select>
		  </div>
		  

          <label for="price{id}" class="form-label mb-0">Цена</label>
          <div class="input-group mb-3">
            <button class="btn btn-outline-secondary" type="button" onclick="save_product('price', '{id}', $('#price{id}').val());">
              <i class="far fa-save"></i>
            </button>

            <input id="price{id}" type="text" class="form-control" value="{price}">
          </div>

          <label for="file{id}" class="form-label mb-0">Документ</label>
          <form class="input-group mb-3" id="form_replace_file">
            <button class="btn btn-outline-secondary">
              <i class="far fa-save"></i>
            </button>

            <input type="hidden" name="id" value="{id}">
            <input id="file{id}" type="file" name="file" class="form-control">
          </form>
        </div>
      </div>
    </div>
  </div>