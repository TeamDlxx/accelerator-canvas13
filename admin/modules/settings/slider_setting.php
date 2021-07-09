<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../../include/resize-class.php';
include '../../includes/admin_auth.php';
$active_menu = "slider";
$page_title = "Slider Setting ";

/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$success = $error = $home_heading = $banner_image = $banner_image_2 = $banner_image3 = $banner_image4 = $image_2 = $button_text = $button1_link = $button2_text = $button2_link = $home_description = "";
/********get dashboard data */
$dashboard_data = get_dashboard_data($connection_string);
$dashboard_info = $dashboard_data['get_info'];
if ($dashboard_data['status'] == 1) {
    // $home_heading = $dashboard_info->home_heading;
    $button_text = $dashboard_info->button1_text;
    // $button1_link = $dashboard_info->button1_link;
    $button2_text = $dashboard_info->button2_text;
    // $button2_link = $dashboard_info->button2_link;

    $home_description = $dashboard_info->home_description;
    $old_banner_image = $dashboard_info->banner_image;
    $old_banner_image_2 = $dashboard_info->banner_image_2;
    $old_banner_image3 = $dashboard_info->banner_image3;
    $old_banner_image4 = $dashboard_info->banner_image4;
    $old_image_2 = $dashboard_info->image_2;
}
/***********when user click on add event button then after all validations it will add the new event******/
if (isset($_POST['submit'])) {
    //========= Validate Input Fields =======//
    // $home_heading = test_input($_POST['home_heading']);
    $button_text = test_input($_POST['button_text']);
    // $button1_link = test_input($_POST['button1_link']);
    $button2_text = test_input($_POST['button2_text']);
    // $button2_link = test_input($_POST['button2_link']);
    $home_description = test_input($_POST['home_description']);
    $banner_image = $_FILES['banner_image']['name'];
    $banner_image_2 = $_FILES['banner_image_2']['name'];
    $banner_image3 = $_FILES['banner_image3']['name'];
    $banner_image4 = $_FILES['banner_image4']['name'];
    $image_2 = $_FILES['image_2']['name'];
    /*******chechk if title is less than 5 chracters or greater than 200 chracters */
    // if (strlen($home_heading) < 5 or strlen($home_heading) > 200) {
    //     $error = "Minimum 5 and maximum 200 chracters allowed for Home Hading";
    // } 
    if (empty($home_description)) {
        $error = "Home Descriptio should not be empty";
    } //if error is empty then upload image and then insert data in data base
    if ($error == "") {
        if (empty($banner_image)) {
            $main_image_name = $old_banner_image;
        } else {
            // main image upload
            $main_image_replace = str_replace(" ", "_", $_FILES["banner_image"]["name"]);
            $main_image_name = "uploads/banner_image/" . date('YmdHis_') . "--" . $main_image_replace;
            $main_image_upload_directory = 'uploads/banner_image';
            $image_directory = '../../../';
            if (!is_dir($image_directory . $main_image_upload_directory)) {
                mkdir($image_directory . $main_image_upload_directory, 0755, true);
            }
            if (move_uploaded_file($_FILES['banner_image']['tmp_name'], $image_directory . $main_image_name)) {
                unlink($image_directory . $old_banner_image);
            }
            //resize image
            // $resizeObj = new resize($image_directory . $main_image_name);
            // $resizeObj->resizeImage(294, 196, 'crop');
            // $resizeObj->saveImage($image_directory . $main_image_name, 100);
        }

        if (empty($banner_image_2)) {
            $main_image_name2 = $old_banner_image_2;
        } else {
            // main image upload
            $main_image_replace = str_replace(" ", "_", $_FILES["banner_image_2"]["name"]);
            $main_image_name2 = "uploads/banner_image/" . date('YmdHis_') . "--" . $main_image_replace;
            $main_image_upload_directory = 'uploads/banner_image';
            $image_directory = '../../../';
            if (!is_dir($image_directory . $main_image_upload_directory)) {
                mkdir($image_directory . $main_image_upload_directory, 0755, true);
            }
            if (move_uploaded_file($_FILES['banner_image_2']['tmp_name'], $image_directory . $main_image_name2)) {
                unlink($image_directory . $old_banner_image_2);
            }
            //resize image
            // $resizeObj = new resize($image_directory . $main_image_name);
            // $resizeObj->resizeImage(294, 196, 'crop');
            // $resizeObj->saveImage($image_directory . $main_image_name, 100);
        }

        if (empty($banner_image3)) {
            $main_image_name3 = $old_banner_image3;
        } else {
            // main image upload
            $main_image_replace = str_replace(" ", "_", $_FILES["banner_image3"]["name"]);
            $main_image_name3 = "uploads/banner_image/" . date('YmdHis_') . "--" . $main_image_replace;
            $main_image_upload_directory = 'uploads/banner_image';
            $image_directory = '../../../';
            if (!is_dir($image_directory . $main_image_upload_directory)) {
                mkdir($image_directory . $main_image_upload_directory, 0755, true);
            }
            if (move_uploaded_file($_FILES['banner_image3']['tmp_name'], $image_directory . $main_image_name3)) {
                unlink($image_directory . $old_banner_image3);
            }
            //resize image
            // $resizeObj = new resize($image_directory . $main_image_name);
            // $resizeObj->resizeImage(294, 196, 'crop');
            // $resizeObj->saveImage($image_directory . $main_image_name, 100);
        }
        if (empty($banner_image4)) {
            $main_image_name4 = $old_banner_image4;
        } else {
            // main image upload
            $main_image_replace = str_replace(" ", "_", $_FILES["banner_image4"]["name"]);
            $main_image_name4 = "uploads/banner_image/" . date('YmdHis_') . "--" . $main_image_replace;
            $main_image_upload_directory = 'uploads/banner_image';
            $image_directory = '../../../';
            if (!is_dir($image_directory . $main_image_upload_directory)) {
                mkdir($image_directory . $main_image_upload_directory, 0755, true);
            }
            if (move_uploaded_file($_FILES['banner_image4']['tmp_name'], $image_directory . $main_image_name4)) {
                unlink($image_directory . $old_banner_image4);
            }
            //resize image
            // $resizeObj = new resize($image_directory . $main_image_name);
            // $resizeObj->resizeImage(294, 196, 'crop');
            // $resizeObj->saveImage($image_directory . $main_image_name, 100);
        }


        if (empty($image_2)) {
            $main_image_name_2 = $old_image_2;
        } else {
            // main image upload
            $main_image_replace = str_replace(" ", "_", $_FILES["image_2"]["name"]);
            $main_image_name_2 = "uploads/banner_image/" . date('YmdHis_') . "--" . $main_image_replace;
            $main_image_upload_directory = 'uploads/banner_image';
            $image_directory = '../../../';
            if (!is_dir($image_directory . $main_image_upload_directory)) {
                mkdir($image_directory . $main_image_upload_directory, 0755, true);
            }
            if (move_uploaded_file($_FILES['image_2']['tmp_name'], $image_directory . $main_image_name_2)) {
                unlink($image_directory . $old_image_2);
            }
            //resize image
            // $resizeObj = new resize($image_directory . $main_image_name);
            // $resizeObj->resizeImage(294, 196, 'crop');
            // $resizeObj->saveImage($image_directory . $main_image_name, 100);
        }


        //insert Dashboard data
        if ($dashboard_data['status'] == 1) {
            $update_slider_query = "UPDATE `dashboard` SET  `banner_image`='" . $main_image_name . "' , `banner_image_2`='" . $main_image_name2 . "', `image_2`='" . $main_image_name_2 . "',  `banner_image3`='" . $main_image_name3 . "' ,  `banner_image4`='" . $main_image_name4 . "' , `home_description`='" . $home_description . "',`button1_text` = '" . $button_text . "',`button2_text` = '" . $button2_text . "' WHERE `id`='1'";
            $update_slider_query_result = mysqli_query($connection_string, $update_slider_query);
            if ($update_slider_query) {
                header('Location:slider_setting.php');
            } else {
                $error = $error_support;
            }
        } else {
            # code...
            $insert_dashboard_query = "INSERT INTO `dashboard` ( `banner_image`, `banner_image_2`,`banner_image3`,`banner_image4`,`image_2`,`home_description`,`button1_text`,`button_text`) VALUES ('" . $main_image_name . "', '" . $main_image_name2 . "', '" . $main_image_name3 . "', '" . $main_image_name4 . "','" . $main_image_name_2 . "','" . $home_description . "','" . $button_text . "','" . $button2_text . "')";
            $insert_dashboard_query_result = mysqli_query($connection_string, $insert_dashboard_query);
            if ($insert_dashboard_query_result) {
                header('Location:slider_setting.php');
            } else {
                $error = $error_support;
            }
        }
    }
}


?>
<!-- HEADER -->
<?php include '../../includes/header.php'; ?>
<!-- END HEADER -->

<!-- BEGIN NAVBAR -->
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
                            <!-- <li class="breadcrumb-item"><a href="javascript:void(0);">Slider Setting</a></li> -->
                            <li class="breadcrumb-item active" aria-current="page"><span>Slider Settings</span></li>
                        </ol>
                    </nav>

                </div>
            </li>
        </ul>
        <?php include '../../includes/side_header.php'; ?>
    </header>
</div>
<!-- END NAVBAR -->

<!-- BEGIN MAIN CONTAINER -->
<div class="main-container" id="container">

    <div class="overlay"></div>
    <div class="search-overlay"></div>

    <!-- BEGIN SIDEBAR -->
    <?php include '../../includes/sidebar.php'; ?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT AREA -->
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
                                                <h5 class="" style="padding-left: 35px;">Slider Settings</h5>
                                                <div class="row">
                                                    <div class="col-md-11 mx-auto">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="home_heading">Slider Form Bottom text *</label>
                                                                    <input type="text" class="form-control mb-4" id="home_heading" placeholder="Slider Button Text" value="<?php echo $button_text; ?>" name="button_text">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="button2_text">CheckBox Text *</label>
                                                                    <input type="text" class="form-control mb-4" id="button_text" required placeholder="Button 2 Title " value="<?php echo $button2_text; ?>" name="button2_text">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="banner_image">Banner Image Recomended Size
                                                                        (1594 x 901)</label><a href="<?php echo $base_url . $dashboard_info->banner_image; ?>" target="_blank"><img class="image_size" src="<?php echo $base_url . $dashboard_info->banner_image; ?>" alt=""></a>
                                                                    <input type="file" class="form-control mb-4" id="banner_image" placeholder="Image" value="<?php echo $banner_image; ?>" name="banner_image">


                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="banner_image_2">Image1 Recomended Size (807
                                                                        x 635)</label><a href="<?php echo $base_url . $dashboard_info->banner_image_2; ?>" target="_blank"><img class="image_size" src="<?php echo $base_url . $dashboard_info->banner_image_2; ?>" alt=""></a>
                                                                    <input type="file" class="form-control mb-4" id="banner_image_2" placeholder="Image" value="<?php echo $banner_image_2; ?>" name="banner_image_2">

                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="banner_image3">Image2 Recomended Size (404 x
                                                                        302)</label><a href="<?php echo $base_url . $dashboard_info->banner_image3; ?>" target="_blank"><img class="image_size" src="<?php echo $base_url . $dashboard_info->banner_image3; ?>" alt=""></a>
                                                                    <input type="file" class="form-control mb-4" id="banner_image3" placeholder="Image" value="<?php echo $banner_image3; ?>" name="banner_image3">

                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="banner_image4">Image3 Recomended Size (404 x
                                                                        302)</label><a href="<?php echo $base_url . $dashboard_info->banner_image4; ?>" target="_blank"><img class="image_size" src="<?php echo $base_url . $dashboard_info->banner_image4; ?>" alt=""></a>
                                                                    <input type="file" class="form-control mb-4" id="banner_image" placeholder="Image" value="<?php echo $banner_image4; ?>" name="banner_image4">

                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="banner_image4">Image4 Recomended Size (806 x
                                                                        302)</label><a href="<?php echo $base_url . $dashboard_info->image_2; ?>" target="_blank"><img class="image_size" src="<?php echo $base_url . $dashboard_info->image_2; ?>" alt=""></a>
                                                                    <input type="file" class="form-control mb-4" id="image_2" placeholder="Image" value="<?php echo $image_2; ?>" name="image_2">

                                                                </div>
                                                            </div>
                                                            <!-- <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="button_text">Button 1 Title *</label>
                                                                    <input type="text" class="form-control mb-4" id="button_text" placeholder="Button 1 Title " value="<?php echo $button_text; ?>" name="button_text">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="button2_link">Button 1 Link *</label>
                                                                    <input type="text" class="form-control mb-4" id="button1_link" placeholder="Button 2 link" value="<?php echo $button1_link; ?>" name="button1_link">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="button2_link">Button 2 Link *</label>
                                                                    <input type="text" class="form-control mb-4" id="button2_link" placeholder="Button 2 Link" value="<?php echo $button2_link; ?>" name="button2_link">
                                                                </div>
                                                            </div> -->
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="home_description">Home Description*</label>
                                                                    <textarea type="text" class="form-control mb-4" id="home_description" placeholder="Home Descriptio" value="" name="home_description"><?php echo $home_description; ?></textarea>
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
                                        CKEDITOR.replace('home_description', {
                                            filebrowserUploadUrl: '../../upload.php',
                                            filebrowserUploadMethod: "form"
                                        });
                                    </script>