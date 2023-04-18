<?= $this->extend('IM\CI\Views\vP') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-3">
    <?= $this->include('App\Views\client\info-card'); ?>
  </div>
  <div class="col-lg-9">
    <div class="row">
      <?php foreach ($tests as $test) : ?>
        <div class="col-lg-12 mb-3">
          <div class="card card-custom card-stretch">
            <div class="card-header border-0">
              <h3 class="card-title font-weight-bolder text-dark"><?= $test['name']; ?></h3>
              <div class="card-toolbar">
                <?php if ($test['status'] == null || $test['status'] == 'Active') : ?>
                  <a href="<?= site_url('test'); ?>" class="btn btn-success font-weight-bolder font-size-sm">
                    Kerjakan
                  </a>
                <?php elseif ($test['status'] == 'Done') : ?>
                  <span class="label label-lg label-light-primary label-inline font-weight-bold p-6">Done</span>
                <?php endif; ?>
              </div>
            </div>
            <div class="card-body pt-0">
              <div class="d-flex align-items-center flex-grow-1">
                <div class="d-flex flex-wrap align-items-center justify-content-between w-100">
                  <div class="d-flex flex-column align-items-cente py-2 w-75">
                    <span class="text-dark-75 font-weight-bold font-size-lg mb-1"><?= $test['description']; ?></span>
                    <span class="text-dark-75 font-weight-bold"><?= ($test['tanggal'] == '-') ? $test['time'] . ' detik' : $test['tanggal'] . ' (' . $test['time'] . ' menit)'; ?></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>