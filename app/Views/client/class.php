<?= $this->extend('IM\CI\Views\vP') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-3">
    <?= $this->include('App\Views\client\info-card'); ?>
  </div>
  <div class="col-lg-9">
    <div class="row">
      <?php foreach ($classes as $class) : ?>
        <div class="col-lg-12 mb-3">
          <div class="card card-custom card-stretch">
            <div class="card-header border-0">
              <h3 class="card-title font-weight-bolder text-dark"><?= $class['name']; ?></h3>
              <div class="card-toolbar">
                <a href="<?= site_url('class/' . $class['class_id']); ?>" class="btn btn-success font-weight-bolder font-size-sm">
                  Lihat
                </a>
              </div>
            </div>
            <div class="card-body pt-0">
              <div class="d-flex align-items-center flex-grow-1">
                <div class="d-flex flex-wrap align-items-center justify-content-between w-100">
                  <div class="d-flex flex-column align-items-cente py-2 w-75">
                    <span class="text-dark-75 font-weight-bold font-size-lg mb-1"><?= $class['description']; ?></span>
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