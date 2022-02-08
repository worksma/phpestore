<div class="row mb-4">
  <div class="col-lg-12 d-flex justify-content-end">
    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#add_product">Добавить</button>
  </div>
</div>

<div class="row" id="products">
  <?=(new Admin)->get_product();?>
</div>

<div class="modal fade" id="add_product" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Добавление товара</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="form_add_product" enctype="multipart/form-data">
        <div class="modal-body">
          <label for="a_title" class="form-label mb-0">Наименование</label>
          <div class="input-group mb-3">
            <input name="title" type="text" id="a_title" class="form-control" placeholder="Например: Скрипт магазина." required>
          </div>

          <label for="a_description" class="form-label mb-0">Описание</label>
          <div class="input-group mb-3">
            <textarea name="description" id="a_description" class="form-control" placeholder="Опишите свой товар и его возможности" required></textarea>
          </div>
			
          <label for="a_description" class="form-label mb-0">Категория</label>
          <div class="input-group mb-3">
            <select class="form-select" name="category">
				{category}
			</select>
          </div>
		  
          <div class="row">
            <div class="col-lg-6 mb-2">
              <label for="a_price" class="form-label mb-0">Цена</label>
              <div class="input-group mb-3">
                <input name="price" type="number" id="a_price" class="form-control" placeholder="0 - бесплатно" required>
              </div>
            </div>

            <div class="col-lg-6 mb-2">
              <label for="a_file" class="form-label mb-0">Файл</label>
              <div class="input-group mb-3">
                <input name="file" type="file" id="a_file" class="form-control" required>
              </div>
            </div>

            <div class="col-lg-6">
              <label for="a_image" class="form-label mb-0">Главная картинка</label>
              <div class="input-group mb-3">
                <input name="image" type="file" id="a_image" class="form-control" required accept="image/*">
              </div>
            </div>

            <div class="col-lg-6">
              <label for="a_images" class="form-label mb-0">Скриншоты</label>
              <div class="input-group mb-3">
                <input name="images[]" type="file" id="a_images" class="form-control" multiple required accept="image/*">
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
          <button class="btn btn-primary">Добавить</button>
        </div>
      </form>
    </div>
  </div>
</div>