<?= $this->extend('IM\CI\Views\vA') ?>

<?= $this->section('content') ?>
<?= form_open('', $form_open); ?>
<div class="card card-custom card-sticky" id="kt_page_sticky_card">
  <div class="card-header">
    <div class="card-title">
      <h3 class="card-label">
        <small class="text-danger">Pastikan semua data terisi dengan benar</small>
      </h3>
    </div>
    <div class="card-toolbar">
      <div class="btn-group mr-2">
        <?= form_button($btnSubmit); ?>
      </div>
      <div class="btn-group">
        <?= form_button($btnReset); ?>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-12">
        <div class="my-5">
          <?= $this->include('IM\CI\Views\vAFormBuilder'); ?>
          <div id="kt_repeater">
            <div class="form-group row">
              <div class="col-3">
                <label>Answers</label>
                <span class="text-danger">*</span>
              </div>
              <div data-repeater-list="opsijawab" class="col-9">
                <?php foreach ($opsijawabs as $opsijawab) : ?>
                  <div data-repeater-item class="form-group row">
                    <div class="col-lg-11">
                      <div class="row">
                        <div class="col-lg-4">
                          <?= form_hidden(['id' => $opsijawab['id']]); ?>
                          <?= form_dropdown([
                            'class'    => (isset($validation)) ? ($validation->hasError('opsijawab.0.dimension') ? 'form-control is-invalid dimension' : 'form-control is-valid dimension') : 'form-control dimension',
                            'name'     => 'dimension',
                            'id'       => 'dimension',
                            'options'  => $optDimensions,
                            'selected' => $opsijawab['dimension'],
                          ]); ?>
                        </div>
                        <div class="col-lg-6">
                          <?= form_input([
                            'class'       => (isset($validation)) ? ($validation->hasError('answer') ? 'form-control is-invalid' : 'form-control is-valid') : 'form-control',
                            'name'        => 'answer',
                            'id'          => 'answer',
                            'placeholder' => 'Answer',
                            'value'       => $opsijawab['answer'],
                            'maxlength'   => '100',
                          ]); ?>
                        </div>
                        <div class="col-lg-2">
                          <?= form_input([
                            'class'       => (isset($validation)) ? ($validation->hasError('point') ? 'form-control is-invalid' : 'form-control is-valid') : 'form-control',
                            'name'        => 'point',
                            'id'          => 'point',
                            'placeholder' => 'Point',
                            'value'       => $opsijawab['point'],
                            'maxlength'   => '100',
                          ]); ?>
                        </div>
                        <div class="col-lg-12 pt-3">
                          <?= form_textarea([
                            'class'       => (isset($validation)) ? ($validation->hasError('feedback') ? 'form-control is-invalid' : 'form-control is-valid') : 'form-control',
                            'name'        => 'feedback',
                            'id'          => 'feedback',
                            'placeholder' => 'Feedback',
                            'value'       => $opsijawab['feedback'],
                            'rows'        => '3'
                          ]); ?>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-1">
                      <div class="d-flex h-100">
                        <div class="row align-self-center">
                          <a href="javascript:;" data-repeater-delete="" class="btn font-weight-bold btn-danger btn-icon">
                            <i class="la la-remove"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-3"></div>
              <div class="col">
                <div data-repeater-create="" class="btn font-weight-bold btn-light-primary">
                  <i class="la la-plus"></i>
                  Add
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-2"></div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>