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

    <style>
        /* Gaya untuk anchor yang dinonaktifkan */
        .disabled-link {
            pointer-events: none;
            color: gray;
            text-decoration: none;
            background-color: lightgray;
        }

        #terms-container {
            overflow-y: auto;
            min-height: 250px;
            max-height: 500px;
            border: 1px solid #ccc;
            padding: 10px;
            -webkit-overflow-scrolling: touch;
        }
    </style>
</head>

<body id="kt_body" class="header-fixed header-mobile-fixed page-loading overlay" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
    <div class="d-flex flex-column flex-root overlay-wrapper">
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
                                            <a href="<?= ($content == 'pre') ? site_url('test/pause/' . encryptUrl($id) . '?goto=dashboard&state=Active') : site_url('dashboard'); ?>" class="navi-link">
                                                <span class="navi-text">Dashboard</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="<?= ($content == 'pre') ? site_url('test/pause/' . encryptUrl($id) . '?goto=logout&state=Active') : site_url('logout'); ?>" class="btn btn-sm btn-light-danger navi-link">
                                                <span>Sign Out</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="d-flex flex-column-fluid">
                        <div class="container">

                            <?php if ($content == 'pre') : ?>
                                <div class="d-flex justify-content-center align-content-center flex-wrap">
                                    <div class="row justify-content-md-center">
                                        <div class="col col-lg-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3>Term and condition</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="border p-3 mb-3" id="terms-container" style="height: 200px; overflow-y: scroll;">
                                                        <?= getConfig('termsConditions'); ?>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="agree-checkbox" disabled>
                                                        <label class="form-check-label" for="agree-checkbox">
                                                            I agree to the Terms and Conditions
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="card-footer d-flex justify-content-between">
                                                    <a href="<?= site_url('test/pause/' . encryptUrl($id) . '?goto=dashboard/&state=Active'); ?>" class="btn btn-light-danger font-weight-bold">Batal</a>
                                                    <a href="<?= site_url('test/instruction/' . encryptUrl($id)); ?>" class="btn font-weight-bold disabled-link" id="continue-btn">Lanjut</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php elseif ($content == 'post') : ?>
                                <div class="d-flex justify-content-center align-content-center flex-wrap">
                                    <div class="row justify-content-md-center">
                                        <div class="col col-lg-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3>Tes Selesai</h3>
                                                </div>
                                                <div class="card-body">
                                                    Terima kasih telah mengikuti tes.
                                                </div>
                                                <div class="card-footer d-flex justify-content-end">
                                                    <a href="<?= site_url('dashboard'); ?>" class="btn btn-light-primary font-weight-bold">DASHBOARD</a>
                                                    <a href="<?= site_url('logout'); ?>" class="btn btn-danger font-weight-bold">LOGOUT</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

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

    <div class="overlay-layer rounded bg-primary-o-20 d-none">
        <div class="spinner spinner-primary"></div>
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

    <script>
        const termContainer = document.getElementById('terms-container');
        const agreeCheckbox = document.getElementById('agree-checkbox');
        const continueButton = document.getElementById('continue-btn');

        if (termContainer) {
            // Scroll event listener
            termContainer.addEventListener('scroll', () => {
                const isScrolledToBottom =
                    termContainer.scrollTop + termContainer.clientHeight >= termContainer.scrollHeight - 5; // Tolerance for margin error
                if (isScrolledToBottom) {
                    agreeCheckbox.disabled = false;
                }
            });

            // Fallback using IntersectionObserver for compatibility
            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            agreeCheckbox.disabled = false;
                        }
                    });
                }, {
                    root: termContainer,
                    threshold: 1.0
                } // 100% element visibility
            );

            const lastChild = termContainer.lastElementChild;
            if (lastChild) {
                observer.observe(lastChild);
            }
        }

        // Agree checkbox event listener
        agreeCheckbox.addEventListener('change', () => {
            if (agreeCheckbox.checked) {
                continueButton.classList.remove('disabled-link');
                continueButton.classList.add('btn-light-primary');
            } else {
                continueButton.classList.add('disabled-link');
                continueButton.classList.remove('btn-light-primary');
            }
        });
    </script>
</body>

</html>