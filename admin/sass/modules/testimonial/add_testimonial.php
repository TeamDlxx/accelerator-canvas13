<?php
include '../../../include/config.php';
include '../../../include/functions.php';
/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$error = $success = $testimonial_description = $testimonial_name = $short_description = $testimonial_image =  "";
$status = 1;
/*********initialize all fields */
$page_title = "Add Testimonials ";;
$meta_description = "showcase";
/*********when user click the add button it validate and then add new testimonial*/
if (isset($_POST['submit'])) {
    //Get Maximum Testimonial Order
    $maximum_testimonial_order = maximum_testimonial_order($connection_string);
    $testimonial_order  = $maximum_testimonial_order + 1;
    /**********call test input function to add slashes********/
    $testimonial_name = test_input($_POST['testimonial_name']);
    $testimonial_status = test_input($_POST['status']);
    $testimonial_description = test_input($_POST['description']);
    $short_description = test_input($_POST['short_description']);
    $testimonial_image = $_FILES['testimonial_image']['name'];
    /***********validate if any required field is empty*******/
    if (empty($testimonial_name)) {
        $error = 'Testimonial Name is required. ';
    } else if (empty($testimonial_image)) {
        $error = 'Image is required. ';
    } else if (empty($testimonial_description)) {
        $error = 'Detailed Testimonial Description is required. ';
    } else if (empty($short_description)) {
        $error = 'Short Description is required. ';
    }
    /*********if there is no error in any field then insert data */
    if (empty($error)) {
        /*********upload image  */
        $testimonial_image_replace =  str_replace(" ", "_", $_FILES["testimonial_image"]["name"]);
        $testimonial_image_name = "uploads/testimonials/" . date('YmdHis_') . "--" . $testimonial_image_replace;
        $testimonial_image_upload_directory    = 'uploads/testimonials';
        $testimonial_image_dir = '../../../';
        if (!is_dir($testimonial_image_dir . $testimonial_image_upload_directory)) {
            mkdir($testimonial_image_dir . $testimonial_image_upload_directory, 0755, true);
        }
        move_uploaded_file($_FILES['testimonial_image']['tmp_name'], $testimonial_image_dir . $testimonial_image_name);
        /***********insert data into table */
        $add_testimonial_query = "INSERT INTO `testimonial`(`testimonial_name`,`short_description`,`detailed_description`, `image`, `status`, `testimonial_order`) VALUES ('$testimonial_name','$short_description','$testimonial_description','$testimonial_image_name','$testimonial_status','$testimonial_order')";
        $add_testimonial_query_result = mysqli_query($connection_string, $add_testimonial_query);
        if ($add_testimonial_query_result) {
            header('Location:testimonials.php');
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
                            <li class="breadcrumb-item active" aria-current="page"><span>Add Testimonial</span></li>
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
                                        <h5 class="">Add Testimonial</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="testimonial_name">Testimonial Name *</label>
                                                            <input type="text" class="form-control mb-4" id="testimonial_name" placeholder="Testimonial Name " value="<?php echo $testimonial_name; ?>" name="testimonial_name" required>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="testimonial_image">Testimonial Image *</label>
                                                            <input type="file" class="form-control mb-4" id="testimonial_image" placeholder="Last Name " value="<?php echo $testimonial_image; ?>" name="testimonial_image" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <select class="form-control" id="status" name="status">
                                                                <option value="<?php echo $status; ?>">Active</option>
                                                                <option value="0">Non Active</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="short_description">Short Description *</label>
                                                            <textarea type="text" class="form-control mb-4" id="short_description" placeholder="Short Description" value="" name="short_description" required><?php echo $short_description; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="description">Detailed Description *</label>
                                                            <textarea type="text" class="form-control mb-4" id="description" placeholder="Detailed Description" value="" name="description" required><?php echo $testimonial_description; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 text-right mb-5">
                                                        <a href="add_user_registration.php"><button id="add-work-platforms" name="submit" class="btn btn-primary">Add Testimonial</button></a>
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
                <!--  END CONTENT AREA  -->
            </div>

            <!-- FOOTER BEGIN -->
            <?php include '../../includes/footer.php'; ?>
            <script>
                CKEDITOR.replace('description', {
                    filebrowserUploadUrl: '../../upload.php',
                    filebrowserUploadMethod: "form"
                });
            </script>
            <!-- FOOTER END -->