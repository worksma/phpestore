<div class="row">
  <div class="col-md-6 col-xl-3">
    <div class="card stat-widget">
    <div class="card-body">
      <h5 class="card-title">Продажи</h5>
      <h3 class="text-center">{sells}</h3>
    </div>
    </div>
  </div>

  <div class="col-md-6 col-xl-3">
    <div class="card stat-widget">
    <div class="card-body">
      <h5 class="card-title">Прибыль</h5>
      <h3 class="text-center">{income} &#8381;</h3>
    </div>
    </div>
  </div>

  <div class="col-md-6 col-xl-3">
    <div class="card stat-widget">
    <div class="card-body">
      <h5 class="card-title">Товары</h5>
      <h3 class="text-center">{products} ед.</h3>
    </div>
    </div>
  </div>

  <div class="col-md-6 col-xl-3">
    <div class="card stat-widget">
    <div class="card-body">
      <h5 class="card-title">Пользователи</h5>
      <h3 class="text-center">{users}</h3>
    </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="row">
        <div class="col-lg-6">
          <div class="card-body">
            <h5 class="card-title">Основные настройки</h5>

            <label for="title" class="form-label">Название магазина</label>
            <div class="input-group mb-3">
              <button class="btn btn-outline-secondary" type="button" onclick="save('title', $('#title').val());">Изменить</button>
              <input id="title" type="text" class="form-control" placeholder="Придумайте название..." value="{pre_title}">
            </div>

            <label for="description" class="form-label">Описание магазина</label>
            <div class="input-group mb-3">
              <button class="btn btn-outline-secondary" type="button" onclick="save('description', $('#description').val());">Изменить</button>
              <input id="description" type="text" class="form-control" placeholder="Расскажите о своём магазине..." value="{pre_description}">
            </div>

            <label for="keywords" class="form-label">Теги магазина</label>
            <div class="input-group mb-3">
              <button class="btn btn-outline-secondary" type="button" onclick="save('keywords', $('#keywords').val());">Изменить</button>
              <input id="keywords" type="text" class="form-control" placeholder="Теги магазина..." value="{pre_keywords}">
            </div>

            <label for="template" class="form-label">Стиль сайта</label>
            <div class="input-group mb-3">
                <button class="btn btn-outline-secondary" type="button" onclick="save('template', $('#template option:selected').text());">
                  Изменить
                </button>
              <select class="form-select" id="template">
                <?=Admin::templates();?>
              </select>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card-body">
            <h5 class="card-title">Приложение Вконтакте</h5>
            <label for="apps_vk_id" class="form-label">ID приложения</label>
            <div class="input-group mb-3">
              <button class="btn btn-outline-secondary" type="button" onclick="save('apps_vk_id', $('#apps_vk_id').val());">
                Изменить
              </button>
              <input id="apps_vk_id" type="text" class="form-control" placeholder="ID приложения" value="{apps_vk_id}">
            </div>

            <label for="apps_vk_secret" class="form-label">Защищённый ключ</label>
            <div class="input-group mb-3">
              <button class="btn btn-outline-secondary" type="button" onclick="save('apps_vk_secret', $('#apps_vk_secret').val());">
                Изменить
              </button>
              <input id="apps_vk_secret" type="text" class="form-control" placeholder="Защищённый ключ" value="{apps_vk_secret}">
            </div>

            <label for="apps_vk_service" class="form-label">Сервисный ключ доступа</label>
            <div class="input-group mb-3">
              <button class="btn btn-outline-secondary" type="button" onclick="save('apps_vk_service', $('#apps_vk_service').val());">
                Изменить
              </button>
              <input id="apps_vk_service" type="text" class="form-control" placeholder="Сервисный ключ доступа" value="{apps_vk_service}">
            </div>

            <button type="submit" class="btn btn-info w-100 mb-2" onclick="truncate_reviews();">Очистить отзывы</button>
            <button type="submit" class="btn btn-info w-100 mb-2" onclick="truncate_pays();">Очистить логи пополнений</button>
          </div>
        </div>
      </div>
    </div> 
  </div>
</div>
