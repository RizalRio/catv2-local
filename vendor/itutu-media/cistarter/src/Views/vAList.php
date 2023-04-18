<?= $this->extend('IM\CI\Views\vA') ?>

<?= $this->section('content') ?>
<div class="card card-custom">
  <div class="card-header flex-wrap border-0 pt-6 pb-0">
    <div class="card-title">
      <h3 class="card-label"><?= $title; ?>
        <span class="d-block text-muted pt-2 font-size-sm"><?= $subTitle; ?></span>
      </h3>
    </div>
    <div class="card-toolbar">
      <div class="input-icon mr-2">
        <input type="text" class="form-control" placeholder="Quick Search..." id="kt_datatable_search_query" />
        <span>
          <i class="flaticon2-search-1 text-muted"></i>
        </span>
      </div>
      <?php if (isset($button) && $button['filter'] === true) : ?>
        <div data-toggle="tooltip" title="" data-original-title="Custom Filter" data-theme="dark">
          <button type="button" id="filter-modal-trigger" class="btn btn-icon btn-light-info mr-2" data-toggle="modal" data-target="#filter-modal">
            <i class="fas fa-filter"></i>
          </button>
        </div>
      <?php endif; ?>
      <?php if (isset($button) && $button['export'] !== false) : ?>
        <div class="dropdown dropdown-inline mr-2" data-toggle="tooltip" title="" data-original-title="Export" data-theme="dark">
          <a href="#" class="btn btn-icon btn-light-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-file-export"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
            <ul class="navi flex-column navi-hover py-2">
              <li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">Choose an option:</li>
              <?php if (isset($button['export']['print']) && $button['export']['print'] === true) : ?>
                <li class="navi-item">
                  <a href="<?= site_url('support/print/' . $module); ?>" class="navi-link">
                    <span class="navi-icon">
                      <i class="la la-print"></i>
                    </span>
                    <span class="navi-text">Print</span>
                  </a>
                </li>
              <?php endif; ?>
              <?php if (isset($button['export']['copy']) && $button['export']['copy'] === true) : ?>
                <li class="navi-item">
                  <a href="#" class="navi-link">
                    <span class="navi-icon">
                      <i class="la la-copy"></i>
                    </span>
                    <span class="navi-text">Copy</span>
                  </a>
                </li>
              <?php endif; ?>
              <?php if (isset($button['export']['excel']) && $button['export']['excel'] === true) : ?>
                <li class="navi-item">
                  <a href="<?= site_url('support/export/excel/' . $module); ?>" class="navi-link">
                    <span class="navi-icon">
                      <i class="la la-file-excel-o"></i>
                    </span>
                    <span class="navi-text">Excel</span>
                  </a>
                </li>
              <?php endif; ?>
              <?php if (isset($button['export']['pdf']) && $button['export']['pdf'] === true) : ?>
                <li class="navi-item">
                  <a href="<?= site_url('support/export/pdf/' . $module); ?>" class="navi-link">
                    <span class="navi-icon">
                      <i class="la la-file-pdf-o"></i>
                    </span>
                    <span class="navi-text">PDF</span>
                  </a>
                </li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      <?php endif; ?>
      <?php if (isset($button['add']) && (isset($button['add']['create']) && isset($button['add']['import'])) && ($button['add']['create'] === true && $button['add']['import'] === true)) : ?>
        <div class="dropdown dropdown-inline mr-2" data-toggle="tooltip" title="" data-original-title="Add" data-theme="dark">
          <a href="#" class="btn btn-icon btn-light-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ki ki-solid-plus"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
            <ul class="navi flex-column navi-hover py-2">
              <li class="navi-header font-weight-bolder text-uppercase font-size-sm text-success pb-2">Choose an option:</li>
              <?php if (isset($button['add']['create']) && $button['add']['create'] === true) : ?>
                <li class="navi-item">
                  <a href="<?= current_url() . '/create'; ?>" class="navi-link">
                    <span class="navi-icon">
                      <i class="la la-print"></i>
                    </span>
                    <span class="navi-text">New</span>
                  </a>
                </li>
              <?php endif; ?>
              <?php if (isset($button['add']['import']) && $button['add']['import'] === true) : ?>
                <li class="navi-item">
                  <a href="<?= current_url() . '/import'; ?>" class="navi-link">
                    <span class="navi-icon">
                      <i class="la la-print"></i>
                    </span>
                    <span class="navi-text">Import</span>
                  </a>
                </li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      <?php elseif (isset($button['add']) && isset($button['add']['create']) && ($button['add']['create'] === true)) : ?>
        <a href="<?= current_url() . '/create'; ?>" class="btn btn-icon btn-light-success font-weight-bolder mr-2" data-toggle="tooltip" title="" data-original-title="Create New" data-theme="dark">
          <i class="ki ki-solid-plus"></i>
        </a>
      <?php elseif (isset($button['add']) && isset($button['add']['import']) && ($button['add']['import'] === true)) : ?>
        <a href="<?= current_url() . '/import'; ?>" class="btn btn-icon btn-light-success font-weight-bolder mr-2" data-toggle="tooltip" title="" data-original-title="Import" data-theme="dark">
          <i class="ki ki-solid-plus"></i>
        </a>
      <?php elseif (isset($button['add']) && !is_bool($button['add'])) : ?>
        <?= $button['add']; ?>
      <?php endif; ?>
      <button type="button" id="reload-button" class="btn btn-icon btn-secondary mr-2" data-toggle="tooltip" title="" data-original-title="Reload Data" data-theme="dark">
        <i class="ki ki-reload"></i>
      </button>
    </div>
  </div>
  <div class="card-body">

    <div class="datatable datatable-bordered datatable-head-custom im_datatable" id="<?= $table; ?>"></div>

  </div>
</div>

<?= $this->include('IM\CI\Views\vAModalFilter'); ?>
<?= $this->endSection(); ?>