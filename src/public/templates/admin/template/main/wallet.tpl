<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Платёжные системы</h5>

        <div class="row">
          <div class="col-lg-6">
            <?
              $payconf = Admin::payconf('qiwi');
            ?>
            <h5><?=$payconf->name;?></h5>

            <div class="input-group mb-3">
              <select class="form-select" id="qiwi_enable" onchange="save('qiwi_enable', $('#qiwi_enable').val());">
                <option value="1" <?=(($payconf->enable == '1') ? 'selected' : '');?>>Включена</option>
                <option value="0" <?=(($payconf->enable == '0') ? 'selected' : '');?>>Выключена</option>
              </select>
            </div>

            <label for="qiwi_key" class="form-label mb-0">Секретный ключ</label>
            <div class="input-group">
              <button class="btn btn-outline-secondary" type="button" onclick="save('qiwi_key', $('#qiwi_key').val());">Изменить</button>
              <input id="qiwi_key" type="text" class="form-control" placeholder="Введите секретный ключ..." value="<?=$payconf->password1;?>">
            </div>
            <small class="text-muted mb-3">Последнее обновление API: <?=date("d.m.Y в H:i", strtotime($payconf->date));?></small>
          </div>

          <div class="col-lg-6">
            <?
              $payconf = Admin::payconf('freekassa');
            ?>
            <h5><?=$payconf->name;?></h5>

            <div class="input-group mb-3">
              <select class="form-select" id="fk_enable" onchange="save('fk_enable', $('#fk_enable').val());">
                <option value="1" <?=(($payconf->enable == '1') ? 'selected' : '');?>>Включена</option>
                <option value="0" <?=(($payconf->enable == '0') ? 'selected' : '');?>>Выключена</option>
              </select>
            </div>

            <label for="fk_id" class="form-label mb-0">ID магазина</label>
            <div class="input-group">
              <button class="btn btn-outline-secondary" type="button" onclick="save('fk_id', $('#fk_id').val());">Изменить</button>
              <input id="fk_id" type="text" class="form-control" placeholder="Введите ID магазина..." value="<?=$payconf->password1;?>">
            </div>

            <label for="fk_secret1" class="form-label mt-3 mb-0">Секретный ключ 1</label>
            <div class="input-group">
              <button class="btn btn-outline-secondary" type="button" onclick="save('fk_secret1', $('#fk_secret1').val());">Изменить</button>
              <input id="fk_secret1" type="text" class="form-control" placeholder="Введите секретный ключ..." value="<?=$payconf->password2;?>">
            </div>

            <label for="fk_secret2" class="form-label mt-3 mb-0">Секретный ключ 2</label>
            <div class="input-group">
              <button class="btn btn-outline-secondary" type="button" onclick="save('fk_secret2', $('#fk_secret2').val());">Изменить</button>
              <input id="fk_secret2" type="text" class="form-control" placeholder="Введите секретный ключ..." value="<?=$payconf->password3;?>">
            </div>
            <small class="text-muted mb-3">Последнее обновление API: <?=date("d.m.Y в H:i", strtotime($payconf->date));?></small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>