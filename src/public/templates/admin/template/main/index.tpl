<div class="row">
  <div class="col-md-6 col-xl-3">
    <div class="card stat-widget">
    <div class="card-body">
      <h5 class="card-title">~{other:sales}</h5>
      <h3 class="text-center">{sells}</h3>
    </div>
    </div>
  </div>

  <div class="col-md-6 col-xl-3">
    <div class="card stat-widget">
    <div class="card-body">
      <h5 class="card-title">~{other:income}</h5>
      <h3 class="text-center">{income} &#8381;</h3>
    </div>
    </div>
  </div>

  <div class="col-md-6 col-xl-3">
    <div class="card stat-widget">
    <div class="card-body">
      <h5 class="card-title">~{other:products}</h5>
      <h3 class="text-center">{products}</h3>
    </div>
    </div>
  </div>

  <div class="col-md-6 col-xl-3">
    <div class="card stat-widget">
    <div class="card-body">
      <h5 class="card-title">~{other:users}</h5>
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
            <h5 class="card-title">~{admin:main_options_title}</h5>

            <label for="title" class="form-label">~{admin:main_options_name}</label>
            <div class="input-group mb-3">
              <button class="btn btn-outline-secondary" type="button" onclick="save('title', $('#title').val());">~{other:edit}</button>
              <input id="title" type="text" class="form-control" placeholder="Придумайте название..." value="{pre_title}">
            </div>

            <label for="description" class="form-label">~{admin:main_options_description}</label>
            <div class="input-group mb-3">
              <button class="btn btn-outline-secondary" type="button" onclick="save('description', $('#description').val());">~{other:edit}</button>
              <input id="description" type="text" class="form-control" placeholder="Расскажите о своём магазине..." value="{pre_description}">
            </div>

            <label for="keywords" class="form-label">~{admin:main_options_tags}</label>
            <div class="input-group mb-3">
              <button class="btn btn-outline-secondary" type="button" onclick="save('keywords', $('#keywords').val());">~{other:edit}</button>
              <input id="keywords" type="text" class="form-control" placeholder="Теги магазина..." value="{pre_keywords}">
            </div>

            <label for="template" class="form-label">~{admin:main_options_template}</label>
            <div class="input-group mb-3">
                <button class="btn btn-outline-secondary" type="button" onclick="save('template', $('#template option:selected').text());">
                  ~{other:edit}
                </button>
              <select class="form-select" id="template">
                <?=Admin::templates();?>
              </select>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card-body">
            <h5 class="card-title">~{admin:main_options_vk_title}</h5>
            <label for="apps_vk_id" class="form-label">~{admin:main_options_vk_id}</label>
            <div class="input-group mb-3">
              <button class="btn btn-outline-secondary" type="button" onclick="save('apps_vk_id', $('#apps_vk_id').val());">
                ~{other:edit}
              </button>
              <input id="apps_vk_id" type="text" class="form-control" placeholder="~{admin:main_options_vk_id}" value="{apps_vk_id}">
            </div>

            <label for="apps_vk_secret" class="form-label">~{admin:main_options_vk_key}</label>
            <div class="input-group mb-3">
              <button class="btn btn-outline-secondary" type="button" onclick="save('apps_vk_secret', $('#apps_vk_secret').val());">
                ~{other:edit}
              </button>
              <input id="apps_vk_secret" type="text" class="form-control" placeholder="~{admin:main_options_vk_key}" value="{apps_vk_secret}">
            </div>

            <label for="apps_vk_service" class="form-label">~{admin:main_options_vk_service}</label>
            <div class="input-group mb-3">
              <button class="btn btn-outline-secondary" type="button" onclick="save('apps_vk_service', $('#apps_vk_service').val());">
                ~{other:edit}
              </button>
              <input id="apps_vk_service" type="text" class="form-control" placeholder="~{admin:main_options_vk_service}" value="{apps_vk_service}">
            </div>

			<button type="submit" class="btn btn-info w-100 mb-2" onclick="update_cache();">~{admin:main_options_cache}</button>
            <button type="submit" class="btn btn-info w-100 mb-2" onclick="truncate_reviews();">~{admin:main_options_reviews}</button>
            <button type="submit" class="btn btn-info w-100 mb-2" onclick="truncate_pays();">~{admin:main_options_pays}</button>
          </div>
        </div>
      </div>
    </div> 
  </div>
</div>
