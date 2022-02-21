  <div class="col-lg-3">
    <div class="card">
      <img src="{avatar}" class="card-img-top" alt="{name}">
      <div class="card-body">
        <h5 class="card-title text-center">{name}</h5>

        <?$groups = Admin::groups();?>

        <label for="group{id}" class="form-label mb-0">~{other:access}</label>
        <select class="form-select" id="group{id}" onchange="save_user('group', '{id}', $('#group{id}').val());">
          <?while($row = $groups->fetch(PDO::FETCH_OBJ)):?>
          <option value="<?=$row->id;?>" <?=(($row->id == '{id_group}') ? 'selected' : '');?>><?=$row->name;?></option>
          <?endwhile;?>
        </select>

        <label for="balance{id}" class="form-label mb-0 mt-2">~{other:balance}</label>
        <div class="input-group mb-3">
          <button class="btn btn-outline-secondary" type="button" onclick="save_user('balance', '{id}', $('#balance{id}').val());"><i class="far fa-save"></i></button>
          <input id="balance{id}" type="text" class="form-control" value="{balance}">
        </div>
      </div>
    </div>
  </div>