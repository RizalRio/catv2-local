<?= $this->extend('IM\CI\Views\vA') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-7 mb-4">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title">Order Per Bulan</h4>
        <div id="chart"></div>
      </div>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="row">
      <div class="col-lg-12 mb-5">
        <div class="card shadow-lg rounded-4">
          <div class="card-header bg-primary text-white text-center rounded-top-4">
            <h5 class="mb-0">User Test Information</h5>
          </div>
          <div class="card-body py-4">
            <div id="donut-chart"></div>
          </div>
        </div>
      </div>
      <div class="col-lg-12 mb-4">
        <div class="card shadow-lg rounded-4">
          <div class="card-header bg-primary text-white text-center rounded-top-4">
            <h5 class="mb-0">Unconfirmed Order</h5>
          </div>
          <div class="card-body py-4">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Invoice</th>
                    <th scope="col">Pembayaran</th>
                  </tr>
                </thead>
                <tbody id="unconfirmedOrder">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>