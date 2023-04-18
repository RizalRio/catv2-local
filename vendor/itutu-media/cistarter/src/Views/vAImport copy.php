  <?= form_open(site_url('support/export/template/' . $module)); ?>
  <div class="form-group">
    <?= form_label('Masukkan jumlah data untuk diimport', 'total'); ?>
    <div class="input-group">
      <?= form_input(['name' => 'total', 'class' => 'form-control', 'id' => 'total', 'type' => 'number', 'min' => '0']); ?>
      <div class="input-group-append">
        <button type="submit" class="btn btn-info">Download Template</button>
      </div>
    </div>
  </div>
  <?= form_close(); ?>
  <?= form_open_multipart(site_url('support/import/' . $module)); ?>
  <div class="form-group">
    <?= form_label('Masukkan file untuk diimport', 'total'); ?>
    <div class="input-group">
      <?= form_input(['name' => 'file', 'class' => 'form-control', 'id' => 'file', 'type' => 'file', 'accept' => '.xls, .xlsx']); ?>
      <div class="input-group-append">
        <button type="submit" class="btn btn-warning">Import Data</button>
      </div>
    </div>
  </div>
  <?= form_close(); ?>