<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">~{admin:wallet_title}</h5>

        <div class="row">
          <div class="col-lg-6 mb-4">
            <?
              $payconf = Admin::payconf('lava');
            ?>
            <h5><?=$payconf->name;?></h5>

            <div class="input-group mb-3">
              <select class="form-select" id="lava_enable" onchange="save('lava_enable', $('#lava_enable').val());">
                <option value="1" <?=(($payconf->enable == '1') ? 'selected' : '');?>>~{other:enabled}</option>
                <option value="0" <?=(($payconf->enable == '0') ? 'selected' : '');?>>~{other:disabled}</option>
              </select>
            </div>

            <label for="lava_id" class="form-label mb-0">~{admin:wallet_lava_id}</label>
            <div class="input-group">
              <button class="btn btn-outline-secondary" type="button" onclick="save('lava_id', $('#lava_id').val());">~{other:edit}</button>
              <input id="lava_id" type="text" class="form-control" placeholder="~{placeholder:secret}" value="<?=$payconf->password2;?>">
            </div>
			
            <label for="lava_secret" class="form-label mb-0">~{admin:wallet_lava_secret}</label>
            <div class="input-group">
              <button class="btn btn-outline-secondary" type="button" onclick="save('lava_secret', $('#lava_secret').val());">~{other:edit}</button>
              <input id="lava_secret" type="text" class="form-control" placeholder="~{placeholder:secret}" value="<?=$payconf->password1;?>">
            </div>
			
            <small class="text-muted mb-3">~{admin:last_update} API: <?=date("d.m.Y H:i", strtotime($payconf->date));?></small>
          </div>
		
          <div class="col-lg-6 mb-4">
            <?
              $payconf = Admin::payconf('qiwi');
            ?>
            <h5><?=$payconf->name;?></h5>

            <div class="input-group mb-3">
              <select class="form-select" id="qiwi_enable" onchange="save('qiwi_enable', $('#qiwi_enable').val());">
                <option value="1" <?=(($payconf->enable == '1') ? 'selected' : '');?>>~{other:enabled}</option>
                <option value="0" <?=(($payconf->enable == '0') ? 'selected' : '');?>>~{other:disabled}</option>
              </select>
            </div>

            <label for="qiwi_key" class="form-label mb-0">~{admin:wallet_qiwi_secret}</label>
            <div class="input-group">
              <button class="btn btn-outline-secondary" type="button" onclick="save('qiwi_key', $('#qiwi_key').val());">~{other:edit}</button>
              <input id="qiwi_key" type="text" class="form-control" placeholder="~{placeholder:secret}" value="<?=$payconf->password1;?>">
            </div>
            <small class="text-muted mb-3">~{admin:last_update} API: <?=date("d.m.Y H:i", strtotime($payconf->date));?></small>
          </div>
		
          <div class="col-lg-6 mb-4">
            <?
              $payconf = Admin::payconf('freekassa');
            ?>
            <h5><?=$payconf->name;?></h5>

            <div class="input-group mb-3">
              <select class="form-select" id="fk_enable" onchange="save('fk_enable', $('#fk_enable').val());">
                <option value="1" <?=(($payconf->enable == '1') ? 'selected' : '');?>>~{other:enabled}</option>
                <option value="0" <?=(($payconf->enable == '0') ? 'selected' : '');?>>~{other:disabled}</option>
              </select>
            </div>

            <label for="fk_id" class="form-label mb-0">~{admin:wallet_fk_id}</label>
            <div class="input-group">
              <button class="btn btn-outline-secondary" type="button" onclick="save('fk_id', $('#fk_id').val());">~{other:edit}</button>
              <input id="fk_id" type="text" class="form-control" placeholder="~{placeholder:shopid}" value="<?=$payconf->password1;?>">
            </div>

            <label for="fk_secret1" class="form-label mt-3 mb-0">~{admin:wallet_fk_secret}</label>
            <div class="input-group">
              <button class="btn btn-outline-secondary" type="button" onclick="save('fk_secret1', $('#fk_secret1').val());">~{other:edit}</button>
              <input id="fk_secret1" type="text" class="form-control" placeholder="~{placeholder:secret}" value="<?=$payconf->password2;?>">
            </div>

            <label for="fk_secret2" class="form-label mt-3 mb-0">~{admin:wallet_fk_secret2}</label>
            <div class="input-group">
              <button class="btn btn-outline-secondary" type="button" onclick="save('fk_secret2', $('#fk_secret2').val());">~{other:edit}</button>
              <input id="fk_secret2" type="text" class="form-control" placeholder="~{placeholder:secret}" value="<?=$payconf->password3;?>">
            </div>
            <small class="text-muted mb-3">~{admin:last_update} API: <?=date("d.m.Y H:i", strtotime($payconf->date));?></small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>