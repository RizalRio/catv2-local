<?= $this->extend('IM\CI\Views\vA') ?>

<?= $this->section('content') ?>
<div class="card card-custom">
  <div class="card-body">

    Nama: <?= $tes['fullname']; ?>
    <?php foreach ($dimension as $method => $value) : ?>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th colspan="<?= count($value); ?>">Scoring <?= $method; ?></th>
          </tr>
          <tr>
            <?php $body = ''; ?>
            <?php foreach ($value as $id => $name) : ?>
              <th><?= $name; ?></th>
              <?php $body .= '<td>' . $scoring[$id] . '</td>'; ?>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <tr><?= $body; ?></tr>
        </tbody>
      </table>
    <?php endforeach; ?>
  </div>
</div>
<?= $this->endSection(); ?>