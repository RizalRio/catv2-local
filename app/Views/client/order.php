<?= $this->extend('IM\CI\Views\vP') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-3">
    <?= $this->include('App\Views\client\info-card'); ?>
  </div>
  <div class="col-lg-9">

    <div class="card">
      <div class="position-absolute w-100 h-50 rounded-card-top"></div>
      <div class="card-body position-relative">
        <?= $message; ?>
        <div class="d-flex justify-content-center">
          <ul class="nav nav-pills nav-primary bg-primary-o-50 rounded" id="pills-tab" role="tablist">
            <li class="nav-item p-0 m-0">
              <a class="nav-link font-weight-bolder rounded-right-0 px-8 py-5 active" id="pills-tab-1" data-toggle="pill" href="#kt-pricing_content1" aria-expanded="true" aria-controls="kt-pricing_content1">Info</a>
            </li>
            <li class="nav-item p-0 m-0">
              <a class="nav-link font-weight-bolder rounded-right-0 rounded-left-0 px-8 py-5" id="pills-tab-2" data-toggle="pill" href="#kt-pricing_content2" aria-expanded="true" aria-controls="kt-pricing_content2">Riwayat</a>
            </li>
            <li class="nav-item p-0 m-0">
              <a class="nav-link font-weight-bolder rounded-right-0 rounded-left-0 px-8 py-5" id="pills-tab-3" data-toggle="pill" href="#kt-pricing_content3" aria-expanded="true" aria-controls="kt-pricing_content3">Order</a>
            </li>
            <li class="nav-item p-0 m-0">
              <a class="nav-link font-weight-bolder rounded-left-0 px-8 py-5" id="pills-tab-4" data-toggle="pill" href="#kt-pricing_content4" aria-expanded="true" aria-controls="kt-pricing_content4">Konfirmasi</a>
            </li>
          </ul>
        </div>
        <div class="tab-content">
          <div class="tab-pane show row active" id="kt-pricing_content1" role="tabpanel" aria-labelledby="pills-tab-1">
            <div class="card-body bg-white col-11 col-lg-12 col-xxl-10 mx-auto">
              <div class="row justify-content-between">
                <div class="col-md-12">
                  <div class="px-5 pb-5">
                    <div class="text-center">
                      <h4 class="font-size-h3 mb-10">Pemilihan Tes</h4>
                    </div>
                    <p class="text-start">
                      Pemilihan tujuan tes anda akan mempengaruhi tipe soal yang akan dipakai.
                      <br>
                      Pada TIKAR tipe soal dibagi menjadi <?= count($types) ?>, yaitu :
                    <ul>
                      <?php foreach($types AS $data) : ?>
                      <li>
                        <label><?= $data['name'] ?></label>
                        <p><?= $data['description'] ?></p>
                      </li>
                      <?php endforeach;?>
                    </ul>
                    </p>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="px-5">
                    <h4 class="font-size-h3 mb-10 text-center">Cara Order</h4>
                    <div class="d-flex flex-column line-height-xl pb-5">
                      <ul>
                        <li>Isikan data pada tab order</li>
                        <li>Menunggu konfirmasi admin</li>
                        <li>Mendapatkan invoice berisi jumlah pembayaran</li>
                        <li>Melakukan pembayaran</li>
                        <li>Konfirmasi dengan meng-upload bukti pembayaran pada tab konfirmasi</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="px-5">
                    <h4 class="font-size-h3 mb-10 text-center">Pembayaran</h4>
                    <div class="d-flex flex-column line-height-xl pb-5">
                      <span>Transfer ke rekening berikut:</span>
                      <div class="accordion accordion-light accordion-toggle-arrow" id="accordionExample2">
                        <div class="card">
                          <div class="card-header" id="headingOne2">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseOne2">
                              Bank 1
                            </div>
                          </div>
                          <div id="collapseOne2" class="collapse" data-parent="#accordionExample2">
                            <div class="card-body">
                              ...
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" id="headingTwo2">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseTwo2">
                              Bank 2
                            </div>
                          </div>
                          <div id="collapseTwo2" class="collapse" data-parent="#accordionExample2">
                            <div class="card-body">
                              ...
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" id="headingThree2">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseThree2">
                              Bank 3
                            </div>
                          </div>
                          <div id="collapseThree2" class="collapse" data-parent="#accordionExample2">
                            <div class="card-body">
                              ...
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane row" id="kt-pricing_content2" role="tabpanel" aria-labelledby="pills-tab-2">
            <div class="card-body bg-white col-11 col-lg-12 col-xxl-10 mx-auto">
              <div class="row">
                <div class="col">
                  <div class="px-5">
                    <h4 class="font-size-h3 mb-10 text-center">Riwayat Order</h4>
                    <div class="d-flex flex-column line-height-xl mb-10">
                      <div class="accordion accordion-light  accordion-toggle-arrow" id="order-list">
                        <?php foreach ($orders as $key => $order) : ?>
                          <div class="card">
                            <div class="card-header" id="headingOne5">
                              <div class="card-title d-flex justify-content-between collapsed" data-toggle="collapse" data-target="#card-INV-<?= $key; ?>">
                                <div class="d-flex flex-column">
                                  <span class="font-weight-bolder text-dark"><?= $order['invoice']; ?></span>
                                  <span class="text-muted mt-3 font-weight-bold font-size-sm"><?= $order['order_date']; ?></span>
                                </div>
                                <span class="mr-4 label label-lg label-light-<?= $order['color']; ?> label-inline font-weight-bold py-4"><?= $order['status']; ?></span>
                              </div>
                            </div>
                            <div id="card-INV-<?= $key; ?>" class="collapse" data-parent="#order-list">
                              <div class="card-body">
                                <div class="d-flex justify-content-between flex-column flex-md-row font-size-lg">
                                  <div class="d-flex flex-column mb-10 mb-md-0">
                                    <div class="d-flex justify-content-between mb-3">
                                      <span class="mr-15 font-weight-bold">No. Invoice:</span>
                                      <div>
                                        <span class="text-right" id="INV-<?= $key; ?>"><?= $order['invoice']; ?></span>
                                        <a href="#" class="text-hover-primary" data-clipboard="true" data-clipboard-target="#INV-<?= $key; ?>"><i class="la la-copy"></i></a>
                                      </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                      <span class="mr-15 font-weight-bold">Tujuan:</span>
                                      <span class="text-right"><?= $order['concentration']; ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                      <span class="mr-15 font-weight-bold">Detail:</span>
                                      <span class="text-right"><?= $order['purpose']; ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                      <span class="mr-15 font-weight-bold">Biaya:</span>
                                      <div>
                                        <span class="text-right" id="BILL-<?= $key; ?>"><?= $order['bill']; ?></span>
                                        <a href="#" class="text-hover-primary" data-clipboard="true" data-clipboard-target="#BILL-<?= $key; ?>"><i class="la la-copy"></i></a>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="d-flex flex-column text-md-right">
                                    <div class="d-flex justify-content-between">
                                      <span class="mr-15 font-weight-bold">Order:</span>
                                      <span class="text-right"><?= $order['order_date']; ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                      <span class="mr-15 font-weight-bold">Bayar:</span>
                                      <span class="text-right"><?= $order['payment_date']; ?></span>
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
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane row text-center" id="kt-pricing_content3" role="tabpanel" aria-labelledby="pills-tab-3">
            <div class="card-body bg-white col-11 col-lg-12 col-xxl-10 mx-auto">
              <div class="row justify-content-center">
                <div class="col">
                  <div class="px-5 text-center">
                    <h4 class="font-size-h3 mb-10">Order Tes</h4>
                    <div class="d-flex flex-column line-height-xl mb-10">
                      <?= form_open('', $form_order); ?>
                      <?= $formOrder; ?>
                      <?= form_button($btnSubmitOrder); ?>
                      <?= form_button($btnResetOrder); ?>
                      <?= form_close(); ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane row text-center" id="kt-pricing_content4" role="tabpanel" aria-labelledby="pills-tab-4">
            <div class="card-body bg-white col-11 col-lg-12 col-xxl-10 mx-auto">
              <div class="row justify-content-center">
                <div class="col">
                  <div class="px-5 text-center">
                    <h4 class="font-size-h3 mb-10">Konfirmasi Pembayaran</h4>
                    <div class="d-flex flex-column line-height-xl mb-10">
                      <?= form_open_multipart('', $form_confirm); ?>
                      <div class="form-group row">
                        <div class="col-3">
                          <label for="inv">Nomor Invoice</label>
                          <span class="text-danger">*</span>
                        </div>
                        <div class="col-9">
                          <div class="typeahead">
                            <input type="text" class="form-control" id="inv" name="inv" dir="ltr">
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-3">
                          <label for="inv">Bukti Pembayaran</label>
                          <span class="text-danger">*</span>
                        </div>
                        <div class="col-9">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="payment" name="payment" accept=".jpg, .jpeg, .png">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                      </div>
                      <div class="mt-7">
                        <button type="submit" class="btn btn-primary text-uppercase font-weight-bolder px-15 py-3">Konfirmasi</button>
                      </div>
                      <?= form_close(); ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<?= $this->endSection(); ?>