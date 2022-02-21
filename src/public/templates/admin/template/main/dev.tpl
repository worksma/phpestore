<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <?
              $v = System::is_version();
              
              if($v->alert == 'success'):
            ?>
            <button class="btn btn-outline-primary" disabled>~{other:update}</button>
            <?else:?>
            <button class="btn btn-outline-primary" onclick="download_update('<?=$v->new_version;?>');">~{other:update}</button>
            <?endif;?>
          </div>
          <div class="col-6">
            <div class="d-flex justify-content-end">
              <span class="text-muted">
                ~{other:version}: <?=System::version()->version;?>
                <br>
                <small style="float:right;">~{other:from}: <?=date("d.m.Y (H:i)", strtotime(System::version()->date));?></small>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-12 mt-2">
    <?=System::news();?>
  </div>
</div>