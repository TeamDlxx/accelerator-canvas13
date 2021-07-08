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
$success = $error = $home_heading = $banner_image = $button1_title = $button1_link = $button2_title = $button2_link = $home_description =  "";

/***********when user click on add event button then after all validations it will add the new event******/
if (isset($_POST['submit'])) {
    //========= Validate Input Fields =======//
    $home_heading = test_input($_POST['home_heading']);
    $button1_title = test_input($_POST['button1_title']);
    $button1_link = test_input($_POST['button1_link']);
    $button2_title = test_input($_POST['button2_title']);
    $button2_link = test_input($_POST['button2_link']);
    $home_description = test_input($_POST['home_description']);
    $banner_image = $_FILES['banner_image']['name'];
    /*******chechk if title is less than 5 chracters or greater than 200 chracters */
    if (strlen($home_heading) < 5 or strlen($home_heading) > 200) {
        $error = "Minimum 5 and maximum 200 chracters allowed for Home Hading";
    } elseif (empty($button1_title)) {
        $error = "Button 1 Title should not be empty";
    } elseif (empty($button1_link)) {
        $error = "Button 1 link should not be empty";
    } elseif (empty($button2_title)) {
        $error = "Button 2 Title Should  not be empty";
    } elseif (empty($button2_link)) {
        $error = "Button 2 link  should not be empty";
    } elseif (empty($home_description)) {
        $error = "Home Descriptio should not be empty";
    } elseif (empty($banner_image)) {
        $error = "Banner Image should not be empty";
    }  //if error is empty then upload image and then insert data in data base
    if ($error == "") {
        // main image upload
        $main_image_replace =  str_replace(" ", "_", $_FILES["banner_image"]["name"]);
        $main_image_name  =  "uploads/banner_image/" . date('YmdHis_') . "--" . $main_image_replace;
        $main_image_upload_directory = 'uploads/banner_image';
        $image_directory = '../../../';
        if (!is_dir($image_directory . $main_image_upload_directory)) {
            mkdir($image_directory . $main_image_upload_directory, 0755, true);
        }
        move_uploaded_file($_FILES['banner_image']['tmp_name'], $image_directory . $main_image_name);
        //resize image
        $resizeObj = new resize($image_directory . $main_image_name);
        $resizeObj->resizeImage(294, 196, 'crop');
        $resizeObj->saveImage($image_directory . $main_image_name, 100);
        //insert Dashboard data
        $insert_dashboard_query = "INSERT INTO `dashboard` (`home_heading`, `banner_image`, `home_description`, `button1_text`, `button1_link`, `button2_text`, `button2_link`) VALUES ('" . $home_heading . "','" . $main_image_name . "', '" . $home_description . "', '" . $button1_title . "', '" . $button1_link . "', '" . $button2_title . "', '" . $button2_link . "')";
        $insert_dashboard_query_result = mysqli_query($connection_string, $insert_dashboard_query);
        if ($insert_dashboard_query_result) {
            $success = "Settings Updated Successfully";
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
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Slider Setting</a></li>
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
                                                <h5 class="">Slider Settings</h5>
                                                <div class="row">
                                                    <div class="col-md-11 mx-auto">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="home_heading">Home Heading *</label>
                                                                    <input type="text" class="form-control mb-4" id="home_heading" placeholder="Home Heading" value="<?php echo $home_heading; ?>" name="home_heading" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="banner_image">Banner Image*</label>
                                                                    <input type="file" class="form-control mb-4" id="banner_image" placeholder="Image" value="<?php echo $banner_image; ?>" name="banner_image" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="button1_title">Button 1 Title *</label>
                                                                    <input type="text" class="form-control mb-4" id="button1_title" placeholder="Button 1 Title " value="<?php echo $button1_title; ?>" name="button1_title" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="button2_link">Button 1 Link *</label>
                                                                    <input type="text" class="form-control mb-4" id="button1_link" placeholder="Button 2 link" value="<?php echo $button1_link; ?>" name="button1_link" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="button2_title">Button 2 Title *</label>
                                                                    <input type="text" class="form-control mb-4" id="button1_title" placeholder="Button 2 Title " value="<?php echo $button2_title; ?>" name="button2_title" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="button2_link">Button 2 Link *</label>
                                                                    <input type="text" class="form-control mb-4" id="button2_link" placeholder="Button 2 Link" value="<?php echo $button2_link; ?>" name="button2_link" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="home_description">Home Description*</label>
                                                                    <textarea type="text" class="form-control mb-4" id="home_description" placeholder="Home Descriptio" value="" name="home_description" required><?php echo $home_description; ?></textarea>
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