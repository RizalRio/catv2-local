<?= $this->extend('IM\CI\Views\vA') ?>

<?= $this->section('content') ?>
<div class="card card-custom card-stretch gutter-b">
  <div class="card-header">
    <div class="card-title">
      <h3 class="card-label">Dual Listbox with Custom Labels</h3>
    </div>
  </div>
  <div class="card-body">
    <?= $this->include('IM\CI\Views\vAFormBuilder'); ?>
    <select id="kt_dual_listbox_2" class="dual-listbox" multiple>
    </select>
  </div>
</div>
<?= $this->endSection(); ?>