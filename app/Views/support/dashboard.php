<?= $this->extend('IM\CI\Views\vA') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-8">
    <div class="row">
    <?php foreach($widgets as $key => $value): ?>
      <div class="col-md-4 gutter-b">
        <a href="<?= $key; ?>" class="card card-custom">
          <div class="card-body d-flex align-items-center p-lg-8">
            <div class="d-flex flex-column flex-grow-1">
              <span class="card-title font-weight-bolder text-dark-75 font-size-h5 mb-2 text-hover-primary"><?= $value; ?></span>
              <span class="font-weight-bold text-muted font-size-lg">Available <?= $key; ?></span>
            </div>
          </div>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card card-custom card-stretch gutter-b">
      <div class="card-header align-items-center border-0 mt-4">
        <h3 class="card-title align-items-start flex-column">
          <span class="font-weight-bolder text-dark">Login Activity Today</span>
        </h3>
      </div>
      <div class="card-body pt-4">
        <div class="scroll scroll-pull" data-scroll="true" data-wheel-propagation="true" style="height: 300px">
          <div class="timeline timeline-6 mt-3">
            <?php foreach ($logins as $login) : ?>
              <div class="timeline-item align-items-start">
                <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg"><?= $login['time']; ?></div>
                <div class="timeline-badge">
                  <i class="fa fa-genderless text-<?= $login['color']; ?> icon-xl"></i>
                </div>
                <div class="timeline-content font-weight-bolder font-size-lg text-dark-75 pl-3"><?= $login['type']; ?>:
                  <a href="#" class="text-primary"><?= $login['username']; ?></a>.
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>