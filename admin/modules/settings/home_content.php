<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../../include/resize-class.php';
include '../../includes/admin_auth.php';

$active_menu = "home_content";
$page_title = "Home Content ";

/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$error = $success = $contact_support = $faq_heading = $client_content = $contact_us_content = $linkedin_link  = $twitter_link = $facebook_link = $gmail_link = $welcome_content = $what_we_do = $what_we_are = $keep_in_touch  = $footer_content =  "";
/*********Get DashBoard Settings*******/
$dashboard_data = get_dashboard_data($connection_string);
$dashboard_data_result = $dashboard_data['get_info'];
/***********when user click on add event button then after all validations it will add the new event******/
if (isset($_POST['submit'])) {
    //========= Validate Input Fields =======//
    $faq_heading = test_input($_POST['faq_heading']);
    // $gmail_link = test_input($_POST['gmail_link']);
    $twitter_link = test_input($_POST['twitter_link']);
    $facebook_link = test_input($_POST['facebook_link']);
    // $pinterest_link = test_input($_POST['pinterest_link']);
    $welcome_content = test_input($_POST['welcome_content']);
    $what_we_do = test_input($_POST['what_we_do']);
    $what_we_are = test_input($_POST['what_we_are']);
    $keep_in_touch = test_input($_POST['keep_in_touch']);
    $footer_content = test_input($_POST['footer_content']);
    $contact_support = test_input($_POST['contact_support']);
    $contact_us_content = test_input($_POST['contact_us_content']);
    $client_content = test_input($_POST['client_content']);
    // $linkedin_link = test_input($_POST['linkedin_link']);

    /*******chechk if title is less than 5 chracters or greater than 200 chracters */
    // if (strlen($faq_heading) < 5 or strlen($faq_heading) > 200) {
    //     $error = "Minimum 5 and maximum 200 chracters allowed for Faq Hading";
    // } 
    if (empty($welcome_content)) {
        $error = "Welcome should not be empty";
    } elseif (empty($what_we_do)) {
        $error = "What We Do Field should not be empty";
    } elseif (empty($what_we_are)) {
        $error = "What We Are Field should not be empty";
    } elseif (empty($footer_content)) {
        $error = "Footer Content should not be empty";
    }

    // if (!empty($facebook_link) && !preg_match('/^(?:(?:http|https):\/\/)?(?:www.)?facebook.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[?\w\-]*\/)?(?:profile.php\?id=(?=\d.*))?([\w\-]*)?$/', $facebook_link)) {
    //     $error    =    "Your entered facebook url is not correct.";
    // }
    //if error is empty then upload image and then insert data in data base
    if ($error == "") {
        if (empty($_FILES["image_1"]["name"])) {
            $image_1_name = $dashboard_data_result->image_1;
        } else {
            //main image upload
            $image_1_replace              =  str_replace(" ", "_", $_FILES["image_1"]["name"]);
            $image_1_name                 =    "uploads/website/" . date('YmdHis_') . "--" . $image_1_replace;
            $main_image_upload_directory    = 'uploads/website/';
            $image_dir = '../../../';
            if (!is_dir($image_dir . $main_image_upload_directory)) {
                mkdir($image_dir . $main_image_upload_directory, 0755, true);
            }
            if (move_uploaded_file($_FILES['image_1']['tmp_name'], $image_dir . $image_1_name)) {
                unlink($image_dir . $dashboard_data_result->image_1);
            }
            //for listing of images of program	
        }

        // if (empty($_FILES["image_2"]["name"])) {
        //     $image_2_name = $dashboard_data_result->image_2;
        // } else {
        //     //main image upload
        //     $image_2_replace              =  str_replace(" ", "_", $_FILES["image_2"]["name"]);
        //     $image_2_name                 =    "uploads/website/" . date('YmdHis_') . "--" . $image_2_replace;
        //     $main_image_upload_directory    = 'uploads/website/';
        //     $image_dir = '../../../';
        //     if (!is_dir($image_dir . $main_image_upload_directory)) {
        //         mkdir($image_dir . $main_image_upload_directory, 0755, true);
        //     }
        //     if (move_uploaded_file($_FILES['image_2']['tmp_name'], $image_dir . $image_2_name)) {
        //         unlink($image_dir . $dashboard_data_result->image_2);
        //     }
        //     //for listing of images of program	
        // }





        //Update Home Pge Content
        $update_dashboard_query = "UPDATE `dashboard` set `welcome_content`='$welcome_content', `what_we_do`='$what_we_do' ,`who_we_are`='$what_we_are',`footer_content`='$footer_content',`image_1`='$image_1_name', `contact_support`='$contact_support',`client_content`='$client_content',`contact_us_content`='$contact_us_content',`faq_heading`='$faq_heading',twitter_link='$twitter_link',`facebook_link` = '$facebook_link',`keep_in_touch`='$keep_in_touch' where `id`= '1'";

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
                            <!-- <li class="breadcrumb-item"><a href="javascript:void(0);"> Setting</a></li> -->
                            <li class="breadcrumb-item active" aria-current="page"><span>Home Content Settings</span>
                            </li>
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
                                                <h5 class="" style="padding-left: 35px;">Home Content Settings</h5>
                                                <div class="row">
                                                    <div class="col-md-11 mx-auto">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="faq_heading">Services Heading *</label>
                                                                    <input type="text" class="form-control mb-4" id="faq_heading" placeholder="Services Heading" value="<?php echo $dashboard_data_result->faq_heading; ?>" name="faq_heading" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="twitter_link">Service Button Text </label>
                                                                    <input type="text" class="form-control mb-4" id="twitter_link" placeholder="Service Button Text " value="<?php echo $dashboard_data_result->twitter_link; ?>" name="twitter_link">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="facebook_link">About Heading </label>
                                                                    <input type="text" class="form-control mb-4" id="facebook_link" placeholder="About Heading" value="<?php echo $dashboard_data_result->facebook_link; ?>" name="facebook_link">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="image_1">Image 1 Recomended Size (570 X
                                                                        686)</label><a href="<?php echo $base_url . $dashboard_data_result->image_1; ?>" target="_blank"><img class="image_size" src="<?php echo $base_url . $dashboard_data_result->image_1; ?>" alt=""></a>
                                                                    <input type="file" class="form-control mb-4" id="image_1" placeholder="Image 1" value="<?php echo $dashboard_data_result->image_2; ?>" name="image_1">

                                                                </div>
                                                            </div>
                                                            <!-- <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="image_2">Image 2 Recomended Size (1597 X
                                                                        649)</label><a href="<?php echo $base_url . $dashboard_data_result->image_2; ?>" target="_blank"><img class="image_size" src="<?php echo $base_url . $dashboard_data_result->image_2; ?>" alt=""></a>
                                                                    <input type="file" class="form-control mb-4" id="image_2" placeholder="Image 2" value="<?php echo $dashboard_data_result->image_2; ?>" name="image_2">

                                                                </div>
                                                            </div> -->

                                                            <!--
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="facebook_link">Facebook Link </label>
                                                                    <input type="text" class="form-control mb-4" id="facebook_link" placeholder="Facebook link" value="<?php echo $dashboard_data_result->facebook_link; ?>" name="facebook_link">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="instagram">Instagram</label>
                                                                    <input type="text" class="form-control mb-4" id="gmail_link" placeholder="Instagram Link" value="<?php echo $dashboard_data_result->gmail_link; ?>" name="gmail_link">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="pinterest_link">Youtube Link </label>
                                                                    <input type="text" class="form-control mb-4" id="pinterest_link" placeholder="Youtube Link" value="<?php echo $dashboard_data_result->pinterest_link; ?>" name="pinterest_link">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="linkedin_link">Linkedin Link </label>
                                                                    <input type="text" class="form-control mb-4" id="linkedin_link" placeholder="Linkedin Link " value="<?php echo $dashboard_data_result->linkedin_link; ?>" name="linkedin_link">
                                                                </div>
                                                            </div> -->
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="welcome_content">Welcome Content*</label>
                                                                    <textarea type="text" class="form-control mb-4" id="welcome_content" placeholder="Welcome Content" value="" name="welcome_content" required><?php echo $dashboard_data_result->welcome_content; ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="what_we_do">Serice Text*</label>
                                                                    <textarea type="text" class="form-control mb-4" id="what_we_do" placeholder="What We Do " value="" name="what_we_do" required><?php echo $dashboard_data_result->what_we_do; ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="client_content">Client Content</label>
                                                                    <textarea type="text" class="form-control mb-4" id="client_content" placeholder="CLient Content " value="" name="client_content"><?php echo $dashboard_data_result->client_content; ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="keep_in_touch">Contact Form Content*</label>
                                                                    <textarea type="text" class="form-control mb-4" id="keep_in_touch" placeholder="Keep In Touch " value="" name="keep_in_touch" required><?php echo $dashboard_data_result->keep_in_touch; ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="contact_us_content">Contact Form Heading </label>
                                                                    <textarea type="text" class="form-control mb-4" id="contact_us_content" placeholder="Contact Us Content " value="" name="contact_us_content"><?php echo $dashboard_data_result->contact_us_content; ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="what_we_are">Contact Form Button Text</label>
                                                                    <textarea type="text" class="form-control mb-4" id="what_we_are" placeholder="What We Are " value="" name="what_we_are" required><?php echo $dashboard_data_result->who_we_are; ?></textarea>
                                                                </div>
                                                            </div>

                                                            <!-- <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="contact_support">Contact Support 3</label>
                                                                    <textarea type="text" class="form-control mb-4" id="keep_in_touch" placeholder="Contact Support " value="" name="contact_support"><?php echo $dashboard_data_result->contact_support; ?></textarea>
                                                                </div>
                                                            </div> -->
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
                                        CKEDITOR.replace('contact_support', {
                                            filebrowserUploadUrl: '../../upload.php',
                                            filebrowserUploadMethod: "form"
                                        });
                                        CKEDITOR.replace('footer_content', {
                                            filebrowserUploadUrl: '../../upload.php',
                                            filebrowserUploadMethod: "form"
                                        });
                                        CKEDITOR.replace('client_content', {
                                            filebrowserUploadUrl: '../../upload.php',
                                            filebrowserUploadMethod: "form"
                                        });
                                        CKEDITOR.replace('contact_us_content', {
                                            filebrowserUploadUrl: '../../upload.php',
                                            filebrowserUploadMethod: "form"
                                        });
                                    </script>