<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../includes/admin_auth.php';
$active_menu = "facebook";
// =====>meta tags <=====
$page_title = "Facebook Pixel";


if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$error = $success = $google_analytics_header = $google_analytics_body = '';

$website_color_scheme = get_website_color_scheme($connection_string);
$website_color_scheme_result = $website_color_scheme['get_info'];
$get_setting_data = get_setting_info($connection_string);
$setting_info = $get_setting_data['get_info'];
$facebook_pixel_code_header = $setting_info->facebook_pixal_code;
$facebook_pixel_code_body = $setting_info->facebook_pixal_code_body;
$setting_id = $setting_info->id;

if (isset($_POST['submit'])) {
    $facebook_pixel_code_header = test_input($_POST['facebook_pixel_code_header']);
    $facebook_pixel_code_body = test_input($_POST['facebook_pixel_code_body']);

    if (empty($error)) {
        $update_setting = "UPDATE `setting` set 
        
       `facebook_pixal_code`='$facebook_pixel_code_header',
       
        `facebook_pixal_code_body`='$facebook_pixel_code_body'  where `id`='$setting_id'  ";

        $update_setting_result = mysqli_query($connection_string, $update_setting);
        if ($update_setting_result) {

            header('Location:facebook_pixel.php');
        } else {
            $error = $error_support;
        }
    }
}

?>
<!--  HEADER  -->
<?php include '../../includes/header.php'; ?>

<!-- END HEADER  -->

<!--  BEGIN NAVBAR  -->
<div class="sub-header-container">
    <header class="header navbar navbar-expand-sm">
        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg></a>

        <ul class="navbar-nav flex-row">
            <li>
                <div class="page-header">

                    <nav class="breadcrumb-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <!-- <li class="breadcrumb-item"><a href="javascript:void(0);">Add</a></li> -->
                            <li class="breadcrumb-item active" aria-current="page"><span>Facebook Pixel</span></li>
                        </ol>
                    </nav>
                </div>
            </li>
        </ul>
        <?php include '../../includes/side_header.php'; ?>
    </header>
</div>
<!--  END NAVBAR  -->

<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">

    <div class="overlay"></div>
    <div class="search-overlay"></div>


    <?php include '../../includes/sidebar.php'; ?>


    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="account-settings-container layout-top-spacing">

                <?php
                if ($error != "") {
                ?>
                    <div class="alert text-center alert-danger alert-dismissible " role="alert" style="width:50%; margin-left:23%; margin-right:25%;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <?= $error; ?>
                    </div>
                <?php } else if ($success != "") {
                ?>
                    <div class="alert text-center alert-success alert-dismissible " role="alert" style="width:50%; margin-left:23%; margin-right:25%;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <?= $success; ?>
                    </div>
                <?php } ?>
                <div class="account-content">
                    <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                        <div class="row">

                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                <form id="contact" method="POST" class="section contact" enctype="multipart/form-data">
                                    <div class="info">
                                        <h5 class="" style="padding-left: 35px;">Facebook Pixel</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="facebook_pixel_code_header">Facebook Pixel Code
                                                                Header </label>
                                                            <textarea type="text" style="height: 400px !important;" class="form-control mb-4" id="facebook_pixel_code_header" placeholder="Facebook Pixel Code Header" value="" name="facebook_pixel_code_header"><?php echo $facebook_pixel_code_header; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="facebook_pixel_code_body">Facebook Pixel Code
                                                                Body </label>
                                                            <textarea type="text" class="form-control mb-4" style="height: 400px !important;" id="facebook_pixel_code_body" placeholder="Facebook Pixel Code Body" value="" name="facebook_pixel_code_body"><?php echo $facebook_pixel_code_body; ?></textarea>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-12 text-right mb-5">
                                                        <button id="add-work-platforms" class="btn btn-primary" type="submit" name="submit">Confirm Changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER BEGIN -->
        <?php include '../../includes/footer.php'; ?>
        <!-- FOOTER END -->