<div class="card card-custom gutter-b">
  <div class="card-body pt-15">
    <div class="text-center mb-10">
      <div class="symbol symbol-60 symbol-circle symbol-xl-90">
        <div class="symbol-label" style="background-image:url('<?= (user()->avatar == DEFAULT_AVATAR) ? site_url(user()->avatar) : site_url('uploads/' . user()->username . '/' . user()->avatar); ?>')" id="avatar"></div>
        <i class="symbol-badge symbol-badge-bottom bg-success"></i>
      </div>
      <h4 class="font-weight-bold my-2" id="fullname"><?= user()->fullname; ?></h4>
      <div class="text-muted mb-2" id="email"><?= user()->email; ?></div>
    </div>
    <?= $sidebar; ?>
  </div>
</div>