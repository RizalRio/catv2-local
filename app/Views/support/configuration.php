<?= $this->extend('IM\CI\Views\vA') ?>

<?= $this->section('content') ?>
<div class="card">
  <div class="card-body">
    <ul class="nav nav-tabs">
      <li class="nav-item mb-2">
        <a class="nav-link active" id="test-tab" data-toggle="tab" href="#application" aria-controls="application">
          <span class="nav-text">Application</span>
        </a>
      </li>
      <li class="nav-item mb-2">
        <a class="nav-link" id="test-tab" data-toggle="tab" href="#test" aria-controls="test">
          <span class="nav-text">Test</span>
        </a>
      </li>
      <li class="nav-item mb-2">
        <a class="nav-link" id="report-tab" data-toggle="tab" href="#report" aria-controls="report">
          <span class="nav-text">Report</span>
        </a>
      </li>
    </ul>
    <div class="tab-content mt-5" id="myTabContent">
      <div class="tab-pane fade active show" id="application" role="tabpanel" aria-labelledby="application-tab">
        <?= form_open('#', ['class' => 'form repeater', 'id' => 'form-application']); ?>
        <?= form_hidden('form', 'application'); ?>
        <div class="form-group">
          <h3>Petunjuk penggunaan</h3>
          <?= form_textarea(['class' => 'form-control summernote', 'name' => 'penggunaan', 'value' => getConfig('petunjukPenggunaan')]); ?>
        </div>
        <br>
        <div class="form-group">
          <h3>Syarat dan ketentuan penggunaan</h3>
          <?= form_textarea(['class' => 'form-control summernote', 'name' => 'syarat', 'value' => getConfig('syaratKetentuanPenggunaan')]); ?>
        </div>
        <br>
        <div class="form-group">
          <h3>Ucapan selamat datang</h3>
          <?= form_textarea(['class' => 'form-control summernote', 'name' => 'ucapan', 'value' => getConfig('ucapanSelamatDatang')]); ?>
        </div>
        <div class="form-group">
          <?= form_button(['type' => 'submit', 'class' => 'btn btn-primary font-weight-bolder btn-submit', 'content' => 'Simpan']); ?>
        </div>
        <?= form_close(); ?>
      </div>
      <div class="tab-pane fade" id="test" role="tabpanel" aria-labelledby="test-tab">
        <?= form_open('#', ['class' => 'form repeater', 'id' => 'form-fakultas']); ?>
        <?= form_hidden('form', 'test'); ?>
        <div class="form-group">
          <h3>Terms and conditions</h3>
          <?= form_textarea(['class' => 'form-control summernote', 'name' => 'terms', 'value' => getConfig('termsConditions')]); ?>
        </div>
        <br>
        <div class="form-group">
          <h3>Intruksi umum</h3>
          <?= form_textarea(['class' => 'form-control summernote', 'name' => 'instruction', 'value' => getConfig('generalInstruction')]); ?>
        </div>
        <div class="form-group">
          <?= form_button(['type' => 'submit', 'class' => 'btn btn-primary font-weight-bolder btn-submit', 'content' => 'Simpan']); ?>
        </div>
        <?= form_close(); ?>
      </div>
      <div class="tab-pane fade" id="report" role="tabpanel" aria-labelledby="report-tab">
        <?= form_open('#', ['class' => 'form', 'id' => 'form-aboout']); ?>
        <?= form_hidden('form', 'report'); ?>
        <div class="form-group">
          <h3>Bagaimana Titian Karir dapat membantu Anda</h3>
          <?= form_textarea(['class' => 'form-control summernote', 'name' => 'how', 'value' => getConfig('bagaimana')]); ?>
        </div>
        <br>
        <div class="form-group">
          <h3>Deskripsi hasil test</h3>
          <?= form_textarea(['class' => 'form-control summernote', 'name' => 'desc', 'value' => getConfig('deskripsiLaporan')]); ?>
        </div>
        <div class="form-group">
          <?= form_button(['type' => 'submit', 'class' => 'btn btn-primary font-weight-bolder btn-submit', 'content' => 'Simpan']); ?>
        </div>
        <?= form_close(); ?>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>