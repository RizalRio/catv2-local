<?= doctype(); ?>
<html lang="<?= session('setLang'); ?>">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= isset($pageTitle) ? $pageTitle . ' - ' . getConfig('appName') : getConfig('appName'); ?></title>
  <meta name="robots" content="noindex, nofollow">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="canonical" href="<?= base_url(); ?>" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
  <?php if ($css) {
    foreach ($css as $css) {
      echo link_tag($css);
    }
  } ?>
  <?= link_tag('assets/plugins/global/plugins.bundle.min.css'); ?>
  <?= link_tag('assets/plugins/custom/prismjs/prismjs.bundle.min.css'); ?>
  <?= link_tag('assets/css/style.bundle.min.css'); ?>
  <?= link_tag('assets/css/themes/layout/header/base/dark.min.css'); ?>
  <?= link_tag('assets/css/themes/layout/header/menu/light.min.css'); ?>
  <?= link_tag('assets/css/themes/layout/brand/dark.min.css'); ?>
  <?= link_tag('assets/css/themes/layout/aside/dark.min.css'); ?>
  <?= link_tag('favicon.ico', 'shortcut icon', 'image/ico'); ?>
</head>

<body id="kt_body" class="header-fixed header-mobile-fixed page-loading">
  <div class="d-flex flex-column flex-root">
    <div class="d-flex flex-row flex-column-fluid page">
      <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
        <div id="kt_header" class="header header-fixed">
          <div class="container-fluid d-flex align-items-stretch justify-content-between">
            <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
              <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
              </div>
            </div>
            <div class="topbar">
              <div class="dropdown">
                <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                  <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2">
                    <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
                    <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"><?= user()->username; ?></span>
                    <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                      <span class="symbol-label font-size-h5 font-weight-bold"><?= substr(user()->username, 0, 1); ?></span>
                    </span>
                  </div>
                </div>
                <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                  <ul class="navi navi-hover py-4">
                    <li class="navi-item">
                      <a href="<?= site_url('dashboard'); ?>" class="navi-link">
                        <span class="navi-text">Dashboard</span>
                      </a>
                    </li>
                    <li class="navi-item">
                      <a href="<?= site_url('logout'); ?>" class="btn btn-sm btn-light-danger navi-link">
                        <span>Sign Out</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="subheader py-2 subheader-solid" id="kt_subheader">
          <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
              <div class="d-flex align-items-baseline flex-wrap mr-5">
                <h5 class="text-dark mr-5">A</h5>
                <h3 class="text-dark mr-5">A</h3>
                <h1 class="text-dark mr-5">A</h1>
              </div>
            </div>
            <div class="d-flex align-items-center">
              <span class="label label-square label-info label-inline font-weight-bold p-5 font-size-h3">Sisa waktu: </span>
              <span class="label label-square label-secondary label-inline font-weight-bold p-5 font-size-h3">69:00</span>
            </div>
          </div>
        </div>
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
          <div class="d-flex flex-column-fluid">
            <div class="container">

            <div class="card">
              <div class="card-body">
                tes
              </div>
            </div>

            </div>
          </div>
        </div>
        <div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
          <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="text-dark order-2 order-md-1">
              <span class="text-muted font-weight-bold mr-2">2020 ©</span>
              <a href="https://itutu-media.id/" target="_blank" class="text-dark-75 text-hover-primary">ITUTUMedia</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="general-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i aria-hidden="true" class="ki ki-close"></i>
          </button>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
          <button type="button" id="modal-ok-button" class="btn btn-danger font-weight-bold" data-action="" data-nya="">OK</button>
        </div>
      </div>
    </div>
  </div>

  <ul class="sticky-toolbar nav flex-column pl-2 pr-2 pt-3 pb-3 mt-4">
    <li class="nav-item" id="kt_demo_panel_toggle" data-toggle="tooltip" title="" data-placement="right" data-original-title="Daftar Soal">
      <a class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" href="#">
        <i class="flaticon2-drop"></i>
      </a>
    </li>
  </ul>

  <div id="kt_demo_panel" class="offcanvas offcanvas-right p-10">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-7" kt-hidden-height="46">
      <h4 class="font-weight-bold m-0">Daftar Soal</h4>
      <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_demo_panel_close">
        <i class="ki ki-close icon-xs text-muted"></i>
      </a>
    </div>
    <div class="offcanvas-content">
      <div class="offcanvas-wrapper mb-5 scroll-pull scroll ps">
        <a href="#" class="btn btn-icon btn-success btn-sm btn-hover-dark m-2">1</a>
        <a href="#" class="btn btn-icon btn-warning btn-sm btn-hover-dark m-2">2</a>
        <a href="#" class="btn btn-icon btn-dark btn-sm btn-hover-dark m-2">3</a>
        <a href="#" class="btn btn-icon btn-outline-dark btn-sm btn-hover-dark m-2">4</a>
      </div>
    </div>
  </div>

  <script>
    var HOST_URL = "<?= current_url(); ?>";
    var BASE_URL = "<?= base_url(); ?>";
  </script>

  <script>
    var KTAppSettings = {
      "breakpoints": {
        "sm": 576,
        "md": 768,
        "lg": 992,
        "xl": 1200,
        "xxl": 1400
      },
      "colors": {
        "theme": {
          "base": {
            "white": "#ffffff",
            "primary": "#3699FF",
            "secondary": "#E5EAEE",
            "success": "#1BC5BD",
            "info": "#8950FC",
            "warning": "#FFA800",
            "danger": "#F64E60",
            "light": "#E4E6EF",
            "dark": "#181C32"
          },
          "light": {
            "white": "#ffffff",
            "primary": "#E1F0FF",
            "secondary": "#EBEDF3",
            "success": "#C9F7F5",
            "info": "#EEE5FF",
            "warning": "#FFF4DE",
            "danger": "#FFE2E5",
            "light": "#F3F6F9",
            "dark": "#D6D6E0"
          },
          "inverse": {
            "white": "#ffffff",
            "primary": "#ffffff",
            "secondary": "#3F4254",
            "success": "#ffffff",
            "info": "#ffffff",
            "warning": "#ffffff",
            "danger": "#ffffff",
            "light": "#464E5F",
            "dark": "#ffffff"
          }
        },
        "gray": {
          "gray-100": "#F3F6F9",
          "gray-200": "#EBEDF3",
          "gray-300": "#E4E6EF",
          "gray-400": "#D1D3E0",
          "gray-500": "#B5B5C3",
          "gray-600": "#7E8299",
          "gray-700": "#5E6278",
          "gray-800": "#3F4254",
          "gray-900": "#181C32"
        }
      },
      "font-family": "Poppins"
    };
  </script>
  <?= script_tag('assets/plugins/global/plugins.bundle.min.js'); ?>
  <?= script_tag('assets/plugins/custom/prismjs/prismjs.bundle.min.js'); ?>
  <?= script_tag('assets/js/scripts.bundle.min.js'); ?>
  <?= script_tag('assets/js/main.min.js'); ?>
  <?php if ($js) {
    foreach ($js as $js) {
      echo script_tag($js);
    }
  } ?>
</body>

</html>