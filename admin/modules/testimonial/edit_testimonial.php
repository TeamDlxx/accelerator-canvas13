<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../includes/admin_auth.php';
$active_menu = "testimonial";
$page_title = "Edit Testimonial ";

/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$error = $success = "";
/***************Get testimonial data by id to update ****************/
$testimonial_id = $_GET['testimonial_id'];
$edit_testimonial_data = get_testimonial_info_by_id($connection_string, $testimonial_id);
$edit_testimonial_info = $edit_testimonial_data['get_info'];
$testimonial_name = stripslashes($edit_testimonial_info->testimonial_name);
$short_description = stripslashes($edit_testimonial_info->short_description);
$testimonial_description = stripslashes($edit_testimonial_info->detailed_description);
$status = stripslashes($edit_testimonial_info->status);
// $old_testimonial_image = $edit_testimonial_info->image;
$old_testimonial_order = $edit_testimonial_info->testimonial_order;
/*********Get Testimonial maximum  Order */
$max_order = maximum_testimonial_order($connection_string);

/*************Update Testimonial *******/
if (isset($_POST['submit'])) {
    $testimonial_name = test_input($_POST['testimonial_name']);
    $testimonial_order = test_input($_POST['testimonial_order']);
    $testimonial_description = test_input($_POST['detailed_description']);
    $short_description = test_input($_POST['short_description']);
    $testimonial_status = test_input($_POST['status']);

    if (($testimonial_order <= '0') || ($testimonial_order > $max_order)) {
        $error = "Testimonial order should be in 1 and " . $max_order;
    } else if (empty($testimonial_name)) {
        $error = "Testimonial name should not be empty";
    } else if (empty($testimonial_description)) {
        $error = "Testimonial Description should not be empty";
    } else if (empty($short_description)) {
        $error = "Short Description should not be empty";
    }
    if ($error == "") {

        // if (empty($_FILES['testimonial_image']['name'])) {
        //     $testimonial_image_name = $old_testimonial_image;
        // } else {
        //     $testimonial_image_dir = '../../../';
        //     $testimonial_image_replace = str_replace(" ", "_", $_FILES['testimonial_image']['name']);
        //     $testimonial_image_name = "uploads/testimonials/" . date('YmdHis_') . $testimonial_image_replace;
        //     $dynamite_upload_directory = 'uploads/testimonials/';
        //     if (!is_dir($testimonial_image_dir . $dynamite_upload_directory)) {
        //         mkdir($testimonial_image_dir . $dynamite_upload_directory, 0755, true);
        //     }

        //     move_uploaded_file($_FILES['testimonial_image']['tmp_name'], $testimonial_image_dir . $testimonial_image_name);
        // }
        //If new  Order order is Lower
        if ($testimonial_order < $old_testimonial_order) {
            $update_order = testimonial_order_to_upper($old_testimonial_order, $testimonial_order, $connection_string);
        }
        //if new order is greater than older order
        else if ($testimonial_order > $old_testimonial_order) {
            $update_order = testimonial_order_to_lower($old_testimonial_order, $testimonial_order, $connection_string);
        }
        //update after updating the order 
        $update_testimonial_query = "UPDATE `testimonial` SET `testimonial_name`='$testimonial_name',`short_description`='$short_description',`detailed_description`='$testimonial_description',`status`='$testimonial_status',`testimonial_order`='$testimonial_order' WHERE `testimonial_id`='$testimonial_id'";
        $update_testimonial_query_result = mysqli_query($connection_string, $update_testimonial_query);
        if ($update_testimonial_query_result) {
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
                            <li class="breadcrumb-item active" aria-current="page"><span>Edit Testimonial</span></li>
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
            <div class="account-settings-container layout-top-spacing">
                <div class="account-content">
                    <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                <form id="contact" method="POST" class="section contact" enctype="multipart/form-data">
                                    <div class="info">
                                        <h5 class="">Edit Testimonial</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="testimonial_name">Testimonial Name *</label>
                                                            <input type="text" class="form-control mb-4" id="testimonial_name" required placeholder="Testimonial Name" value="<?php echo $testimonial_name; ?>" name="testimonial_name">

                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="testimonial_image">Testimonial Image </label>
                                                            <input type="file" class="form-control mb-4" id="testimonial_image" placeholder="Last Name *" value="" name="testimonial_image">
                                                        </div>
                                                    </div> -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="testimonial_order">Testimonial Order *</label>
                                                            <input type="text" class="form-control mb-4" required id="testimonial_order" placeholder="Testimonial Order" value="<?php echo $old_testimonial_order ?>" name="testimonial_order">

                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <select class="form-control" id="status" name="status">
                                                                <option <?php echo ($status == '1') ? "selected" : "" ?> value="1">Active</option>
                                                                <option <?php echo ($status == '0') ? "selected" : "" ?> value="0">Non Active</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="short_description">Short Description*</label>
                                                            <textarea type="text" class="form-control mb-4" id="short_description" placeholder="Short Description" value="" required name="short_description"><?php echo  $short_description; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="detailed_description">Detailed
                                                                Description*</label>
                                                            <textarea type="text" class="form-control mb-4" id="detailed_description" placeholder="Detailed Description" value="" name="detailed_description" required><?php echo  $testimonial_description; ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 text-right mb-5">
                                                        <button id="add-work-platforms" type="submit" name="submit" class="btn btn-primary">Edit Testimonial</button>
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
                CKEDITOR.replace('detailed_description', {
                    filebrowserUploadUrl: '../../upload.php',
                    filebrowserUploadMethod: "form"
                });
            </script>
            <!-- FOOTER END -->