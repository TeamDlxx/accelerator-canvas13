<?php
include '../../../include/website_settings.php';
include 'setting.php';
?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
<title><?= $page_title; ?> | <?= $brand_title; ?></title>
<meta name="title" content="<?= $meta_title; ?>" />
<meta name="keywords" content=" <?= $meta_keyword; ?>" />
<meta name="description" content="<?= $meta_description; ?>" />

<link rel="icon" type="image/x-icon" href="<?= $base_url . $fav_icons; ?>" />


<!--  BEGIN Invoice STYLE FILE  -->

<!--  END Invoice STYLE FILE  -->
<!-- cards css -->

<!--<link href="../../assets/css/components/cards/card.css" rel="stylesheet" type="text/css" /> -->
<link href="../../assets/css/loader.css" rel="stylesheet" type="text/css" />
<script src="../../assets/js/loader.js"></script>
<!-- Begin ticket styles -->
<!-- <script src="../../plugins/sweetalerts/promise-polyfill.js"></script> -->
<!-- <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" /> -->

<link href="../../assets/css/custom_style.css" rel="stylesheet" type="text/css" />
<!-- <link href="../../plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<link href="../../plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
<link href="../../plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" /> -->
<!-- End ticket styles -->

<!-- date range picker -->
<link href="../../gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<script src="../../gentelella/vendors/moment/min/moment.min.js"></script>
<script src="../../gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- favi icon -->
<!-- <link rel="icon" type="image/x-icon" href="../../assets/img/favicon.ico" /> -->
<!--  BEGIN CUSTOM STYLE FILE  -->
<link rel="stylesheet" type="text/css" href="../../plugins/dropify/dropify.min.css">
<link href="../../assets/css/users/account-setting.css" rel="stylesheet" type="text/css" />
<!--  END CUSTOM STYLE FILE  -->
<!-- <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet" /> -->

<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="../../https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
<link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/css/plugins.css" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->
<!-- ckeditor -->
<script src="../../ckeditor/ckeditor.js"></script>
<script src="../../ckeditor/samples/js/sample.js"></script>
<link rel="stylesheet" href="../../ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->

<?php if (isset($datatable) && $datatable === true) { ?>
    <link rel="stylesheet" type="text/css" href="../../plugins/table/datatable/datatables.css">
    <link href="../../plugins/table/datatable/responsive.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../plugins/table/datatable/custom_dt_html5.css">
    <link rel="stylesheet" type="text/css" href="../../plugins/table/datatable/dt-global_style.css">
<?php } ?>

<!-- END PAGE LEVEL CUSTOM STYLES -->
<?php if (isset($ticket_details) && ($ticket_details == true)) { ?>
    <link rel="stylesheet" type="text/css" href="../../plugins/editors/quill/quill.snow.css">
    <link href="../../assets/css/apps/mailbox.css" rel="stylesheet" type="text/css" />

    <script src="../../plugins/sweetalerts/promise-polyfill.js"></script>
    <link href="../../plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="../../plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="../../plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
<?php } ?>
<?php if (isset($dashboard) && $dashboard == true) { ?>
    <link href="../../plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="../../assets/css/dashboard/dash_2.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
<?php } ?>
<?php if (isset($invoice_details) && $invoice_details == true) { ?>
    <link href="../../assets/css/apps/invoice.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../../assets/css/elements/alert.css">

<?php } ?>
<?php if (isset($invoice) && $invoice == true) { ?>
    <link rel="stylesheet" type="text/css" href="../../plugins/editors/quill/quill.snow.css">
    <link href="../../assets/css/apps/todolist.css" rel="stylesheet" type="text/css" />

<?php } ?>

</head>

<body>
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">

            <ul class="navbar-item theme-brand flex-row  text-center">
                <li class="nav-item theme-logo">
                    <a href="<?= $base_url_admin ?>modules/dashboard/dashboard.php">
                        <?php if ($show_logo == 1) { ?>
                <li class="nav-item theme-logo">
                    <a href="<?= $base_url_admin ?>modules/dashboard/dashboard.php">
                        <img src="<?= $base_url . $logo_brand ?>" class="navbar-logo" alt="logo">
                    </a>
                </li>
            <?php } else { ?>
                <li class="nav-item theme-logo">
                    <a href="<?= $base_url_admin ?>modules/dashboard/dashboard.php">
                        <?= $business_title; ?>
                    </a>
                </li>
            <?php } ?>
            </a>
            </li>
            <li class="nav-item theme-text">
                <a href="<?= $base_url_admin; ?>modules/dashboard/dashboard.php" class="nav-link"> <?= $brand_title; ?> </a>
            </li>
            </ul>

            <ul class="navbar-item flex-row ml-md-auto">
                <a style="margin-right: 40px !important;margin-top:5px" target="_blank" href="<?= $base_url ?>"><button id="add-work-platforms" name="submit" class="btn btn-primary">View Page</button></a>
                <li class="nav-item dropdown user-profile-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <img src="https://img.icons8.com/color/48/000000/test-account.png" alt="avatar"> <?php $admin_info = $_SESSION['admin_info'];
                                                                                                            echo  $admin_info->admin_name; ?><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="">
                            <div class="dropdown-item">
                                <a href="../../log_out.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg> Logout</a>
                            </div>
                        </div>
                    </div>
                </li>

            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->