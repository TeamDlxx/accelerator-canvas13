<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../../include/resize-class.php';
$page_title = "Slider Setting ";;
$meta_description = "showcase";
/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$error = $success = $faq_heading = $twitter_link = $facebook_link = $gmail_link = $welcome_content = $what_we_do = $what_we_are = $keep_in_touch = $footer_content =  "";
/*********Get DashBoard Settings*******/
$dashboard_data = get_dashboard_data($connection_string);
$dashboard_data_result = $dashboard_data['get_info'];
/***********when user click on add event button then after all validations it will add the new event******/
if (isset($_POST['submit'])) {
    //========= Validate Input Fields =======//
    $faq_heading = test_input($_POST['faq_heading']);
    $gmail_link = test_input($_POST['gmail_link']);
    $twitter_link = test_input($_POST['twitter_link']);
    $facebook_link = test_input($_POST['facebook_link']);
    $welcome_content = test_input($_POST['welcome_content']);
    $what_we_do = test_input($_POST['what_we_do']);
    $what_we_are = test_input($_POST['what_we_are']);
    $keep_in_touch = test_input($_POST['keep_in_touch']);
    $footer_content = test_input($_POST['footer_content']);



    /*******chechk if title is less than 5 chracters or greater than 200 chracters */
    if (strlen($faq_heading) < 5 or strlen($faq_heading) > 200) {
        $error = "Minimum 5 and maximum 200 chracters allowed for Faq Hading";
    } elseif (empty($gmail_link)) {
        $error = "Gmail Link should not be empty";
    } elseif (empty($twitter_link)) {
        $error = "Twitter link should not be empty";
    } elseif (empty($facebook_link)) {
        $error = "Facebook Link Should  not be empty";
    } elseif (empty($welcome_content)) {
        $error = "Welcome should not be empty";
    } elseif (empty($what_we_do)) {
        $error = "What We Do Field should not be empty";
    } elseif (empty($what_we_are)) {
        $error = "What We Are Field should not be empty";
    } elseif (empty($keep_in_touch)) {
        $error = "Keep In Touch Field should not be empty";
    } elseif (empty($footer_content)) {
        $error = "Footer Content should not be empty";
    }
    if (!empty($facebook_link) && !preg_match('/^(?:(?:http|https):\/\/)?(?:www.)?facebook.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[?\w\-]*\/)?(?:profile.php\?id=(?=\d.*))?([\w\-]*)?$/', $facebook_link)) {
        $error    =    "Your entered facebook url is not correct.";
    }
    //if error is empty then upload image and then insert data in data base
    if ($error == "") {
        //Update Home Pge Content
        $update_dashboard_query = "UPDATE `dashboard` set `faq_heading`='$faq_heading',`twitter_link`='$twitter_link',`facebook_link`='$facebook_link',`gmail_link`='$gmail_link', `welcome_content`='$welcome_content', `what_we_do`='$what_we_do' ,`who_we_are`='$what_we_are', `keep_in_touch`='$keep_in_touch',`footer_content`='$footer_content' where `id`= '1'";
        $update_dashboard_query_result = mysqli_query($connection_string, $update_dashboard_query);
        if ($update_dashboard_query_result) {
            header('Location:home_content.php');
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
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Home Content Setting</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><span>Settings</span></li>
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

    <!--  BEGIN SIDEBAR  -->
    <?php include '../../includes/sidebar.php'; ?>
    <!--  END SIDEBAR  -->
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="account-settings-container layout-top-spacing">
                <?php
                if ($error != "") {
                ?>
                    <div class="alert text-center alert-danger alert-dismissible " role="alert" style="width:50%; margin-left:23%; margin-right:25%;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <?= $error;
                } elseif ($success != "") {
                    ?>
                        <div class="alert text-center alert-success alert-dismissible " role="alert" style="width:50%; margin-left:23%; margin-right:25%;">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <?= $success;
                    } ?>
                        </div>
                        <div class="account-content">
                            <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                        <form id="contact" method="POST" class="section contact" enctype="multipart/form-data">
                                            <div class="info">
                                                <h5 class="">Home Content Settings</h5>
                                                <div class="row">
                                                    <div class="col-md-11 mx-auto">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="faq_heading">Faq Heading *</label>
                                                                    <input type="text" class="form-control mb-4" id="faq_heading" placeholder="Faq Heading" value="<?php echo $dashboard_data_result->faq_heading; ?>" name="faq_heading" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="twitter_link">Twitter Link *</label>
                                                                    <input type="text" class="form-control mb-4" id="twitter_link" placeholder="Twitter Link " value="<?php echo $dashboard_data_result->twitter_link; ?>" name="twitter_link" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="facebook_link">Facebook Link *</label>
                                                                    <input type="text" class="form-control mb-4" id="facebook_link" placeholder="Facebook link" value="<?php echo $dashboard_data_result->facebook_link; ?>" name="facebook_link" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="gmail_link">Gmail Link *</label>
                                                                    <input type="text" class="form-control mb-4" id="gmail_link" placeholder="Gmail Link" value="<?php echo $dashboard_data_result->gmail_link; ?>" name="gmail_link" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="welcome_content">Welcome Content*</label>
                                                                    <textarea type="text" class="form-control mb-4" id="welcome_content" placeholder="Welcome Content" value="" name="welcome_content" required><?php echo $dashboard_data_result->welcome_content; ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="what_we_do">What We Do*</label>
                                                                    <textarea type="text" class="form-control mb-4" id="what_we_do" placeholder="What We Do " value="" name="what_we_do" required><?php echo $dashboard_data_result->what_we_do; ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="what_we_are">What We Are*</label>
                                                                    <textarea type="text" class="form-control mb-4" id="what_we_are" placeholder="What We Are " value="" name="what_we_are" required><?php echo $dashboard_data_result->who_we_are; ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="keep_in_touch">Keep In Touch*</label>
                                                                    <textarea type="text" class="form-control mb-4" id="keep_in_touch" placeholder="Keep In Touch " value="" name="keep_in_touch" required><?php echo $dashboard_data_result->keep_in_touch; ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="footer_content">Footer Content*</label>
                                                                    <textarea type="text" class="form-control mb-4" id="footer_content" placeholder="Footer Content " value="" name="footer_content" required><?php echo $dashboard_data_result->footer_content; ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 text-right mb-5">
                                                                <button name="submit" type="submit" id="add-work-platforms" class="btn btn-primary">Update Settings</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <?php include '../../includes/footer.php'; ?>
                                    <script>
                                        CKEDITOR.replace('welcome_content', {
                                            filebrowserUploadUrl: '../../upload.php',
                                            filebrowserUploadMethod: "form"
                                        });
                                        CKEDITOR.replace('what_we_do', {
                                            filebrowserUploadUrl: '../../upload.php',
                                            filebrowserUploadMethod: "form"
                                        });
                                        CKEDITOR.replace('what_we_are', {
                                            filebrowserUploadUrl: '../../upload.php',
                                            filebrowserUploadMethod: "form"
                                        });
                                        CKEDITOR.replace('keep_in_touch', {
                                            filebrowserUploadUrl: '../../upload.php',
                                            filebrowserUploadMethod: "form"
                                        });
                                        CKEDITOR.replace('footer_content', {
                                            filebrowserUploadUrl: '../../upload.php',
                                            filebrowserUploadMethod: "form"
                                        });
                                    </script>