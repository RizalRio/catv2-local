<?= $this->extend('IM\CI\Views\vP') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-3">
    <?= $this->include('App\Views\client\info-card'); ?>
  </div>
  <div class="col-lg-9">
    <?= $message; ?>
    <div class="row">
      <?php foreach ($tests as $test) : ?>
        <div class="col-lg-12 mb-3">
          <div class="card card-custom card-stretch">
            <div class="card-header border-0">
              <h3 class="card-title font-weight-bolder text-dark"><?= $test['name']; ?></h3>
              <div class="card-toolbar">
                <?php if ((date('Y-m-d') < $test['open'])) : ?>
                  <label class="btn btn-light-warning font-weight-bolder font-size-sm">
                    Akan Datang
                  </label>
                <?php
                elseif ((date('Y-m-d') >= $test['open']) && (date('Y-m-d') <= $test['close'])) :
                ?>
                  <?php if ($test['status'] == 'Active' || $test['status'] == 'Ready') : ?>
                    <a href="<?= site_url('test/instruction/' . ($test['id'])); ?>" class="btn btn-success font-weight-bolder font-size-sm">
                      Kerjakan
                    </a>
                  <?php elseif ($test['status'] == 'Ongoing' || $test['status'] == 'Pause') : ?>
                    <a href="<?= site_url('test/instruction/' . ($test['id'])); ?>" class="btn btn-warning font-weight-bolder font-size-sm">
                      Lanjutkan
                    </a>
                  <?php elseif ($test['status'] == 'Done') : ?>
                    <a href="<?= site_url('result/' . ($test['id'])); ?>" target="_blank" class="btn btn-light-primary font-weight-bolder font-size-sm">
                      Hasil
                    </a>
                  <?php endif; ?>
                <?php elseif ((date('Y-m-d') > $test['close']) && !empty($test['status'])) : ?>
                  <a href="<?= site_url('result/' . ($test['id'])); ?>" target="_blank" class="btn btn-light-primary font-weight-bolder font-size-sm">
                    Hasil
                  </a>
                <?php endif; ?>
              </div>
            </div>
            <div class="card-body pt-0">
              <div class="d-flex align-items-center flex-grow-1">
                <div class="d-flex flex-wrap align-items-center justify-content-between w-100">
                  <div class="d-flex flex-column align-items-cente py-2 w-75">
                    <span class="text-dark-75 font-weight-bold font-size-lg mb-1"><?= $test['description']; ?></span>
                    <span class="text-dark-75 font-weight-bold"><?= tanggal($test['open'], 'dd MMMM yyyy') . ' s.d. ' . tanggal($test['close'], 'dd MMMM yyyy'); ?></span>
                    <span class="text-dark-75 font-weight-bold"><?= $test['time'] . ' detik'; ?></span>
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