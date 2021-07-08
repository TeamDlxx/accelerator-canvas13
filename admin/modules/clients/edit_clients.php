<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../includes/admin_auth.php';
$active_menu = "clients";
$page_title = "Edit Clients ";

/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$error = $success = "";
/***************Get testimonial data by id to update ****************/
$client_id = $_GET['client_id'];
$edit_client_data = get_client_info_by_id($connection_string, $client_id);
$edit_client_info = $edit_client_data['get_info'];

$client_name = stripslashes($edit_client_info->client_name);
$status = stripslashes($edit_client_info->status);
$old_client_image = $edit_client_info->image;

// $short_description = stripslashes($edit_testimonial_info->short_description);
// $testimonial_description = stripslashes($edit_testimonial_info->detailed_description);
// $old_testimonial_order = $edit_testimonial_info->testimonial_order;

/*********Get Testimonial maximum  Order */
// $max_order = maximum_testimonial_order($connection_string);

/*************Update Testimonial *******/
if (isset($_POST['submit'])) {

    $client_name = test_input($_POST['client_name']);
    // $testimonial_order = test_input($_POST['testimonial_order']);
    // $testimonial_description = test_input($_POST['detailed_description']);
    // $short_description = test_input($_POST['short_description']);
    $status = test_input($_POST['status']);

    // if (($testimonial_order <= '0') || ($testimonial_order > $max_order)) {
    //     $error = "Testimonial order should be in 1 and " . $max_order;
    // } else 

    if (empty($client_name)) {
        $error = "Client name should not be empty";
    }
    if ($error == "") {

        if (empty($_FILES['image']['name'])) {
            $image_name = $old_client_image;
        } else {
            $image_dir = '../../../';
            $image_replace = str_replace(" ", "_", $_FILES['image']['name']);
            $image_name = "uploads/clients/" . date('YmdHis_') . $image_replace;
            $dynamite_upload_directory = 'uploads/clients/';
            if (!is_dir($image_dir . $dynamite_upload_directory)) {
                mkdir($image_dir . $dynamite_upload_directory, 0755, true);
            }

            move_uploaded_file($_FILES['image']['tmp_name'], $image_dir . $image_name);
        }
        //If new  Order order is Lower
        // if ($testimonial_order < $old_testimonial_order) {
        //     $update_order = testimonial_order_to_upper($old_testimonial_order, $testimonial_order, $connection_string);
        // }
        // //if new order is greater than older order
        // else if ($testimonial_order > $old_testimonial_order) {
        //     $update_order = testimonial_order_to_lower($old_testimonial_order, $testimonial_order, $connection_string);
        // }

        //update
        $update_client_query = "UPDATE `clients` SET `client_name`='$client_name',`image`='$image_name',`status`='$status' WHERE `client_id`= '$client_id'";
        $update_client_query_result = mysqli_query($connection_string, $update_client_query);
        if ($update_client_query_result) {
            header('Location:clients.php');
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
                            <li class="breadcrumb-item active" aria-current="page"><span>Edit Client</span></li>
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
                                        <h5 class="">Edit Client</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="testimonial_name">Client Name *</label>
                                                            <input type="text" class="form-control mb-4" id="client_name" required placeholder="Client Name" value="<?php echo $client_name; ?>" name="client_name">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="testimonial_image">Image Recomended Size (400x300) </label>
                                                            <input type="file" class="form-control mb-4" id="image" placeholder="" value="" name="image">
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="testimonial_order">Testimonial Order *</label>
                                                            <input type="text" class="form-control mb-4" required id="testimonial_order" placeholder="Testimonial Order" value="<?php echo $old_testimonial_order ?>" name="testimonial_order">

                                                        </div>
                                                    </div> -->

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <select class="form-control" id="status" name="status">
                                                                <option <?php echo ($status == '1') ? "selected" : "" ?> value="1">Active</option>
                                                                <option <?php echo ($status == '0') ? "selected" : "" ?> value="0">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-12">
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
                                                    </div> -->

                                                    <div class="col-md-12 text-right mb-5">
                                                        <button id="add-work-platforms" type="submit" name="submit" class="btn btn-primary">Edit Client</button>
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
            <!-- <script>
                CKEDITOR.replace('detailed_description', {
                    filebrowserUploadUrl: '../../upload.php',
                    filebrowserUploadMethod: "form"
                });
            </script> -->
            <!-- FOOTER END -->