<?= $this->extend('IM\CI\Views\vA') ?>

<?= $this->section('content') ?><div class="card card-custom gutter-b">
  <div class="card-header flex-wrap border-0 pt-6 pb-0">
    <div class="card-title">
      <h3 class="card-label">Import Data Question</h3>
    </div>
  </div>
  <div class="card-body">
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
  </div>
</div>
<div class="card card-custom">
  <div class="card-header flex-wrap border-0 pt-6 pb-0">
    <div class="card-title">
      <h3 class="card-label">Preview data import
        <span class="d-block text-muted pt-2 font-size-sm">Data di tabel ini adalah data yang akan disimpan berdasarkan import file</span>
      </h3>
    </div>
    <div class="card-toolbar">
      <a href="<?= current_url() . '/save'; ?>" class="btn btn-light-success font-weight-bolder mr-2" data-toggle="tooltip" title="" data-original-title="Create New" data-theme="dark">
        Simpan semua data
      </a>
    </div>
  </div>
  <div class="card-body">
    <div class="datatable datatable-bordered datatable-head-custom im_datatable" id="table-questions"></div>
  </div>
</div>
<?= $this->endSection() ?>