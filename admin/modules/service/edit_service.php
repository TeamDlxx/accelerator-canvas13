<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../includes/admin_auth.php';
$active_menu = "service";
$error = $success = "";
$page_title = "Edit Services ";

$service_name = $service_short_description = $service_description = "";
/***************Get service data by id to update ****************/
$service_id = $_GET['service_id'];
$edit_service_data = get_services_info_by_id($connection_string, $service_id);
$edit_service_info = $edit_service_data['get_info'];
$service_name = stripslashes($edit_service_info->service_name);
$service_short_description = stripslashes($edit_service_info->short_description);
$service_description = stripslashes($edit_service_info->description);
$status = stripslashes($edit_service_info->status);
$old_service_image = $edit_service_info->image;
$old_service_order = $edit_service_info->service_order;
/*********Get service maximum  Order */
$max_order = get_maximum_order($connection_string, "services", "service_order");

/*************Update service *******/
if (isset($_POST['submit'])) {
    $service_name = test_input($_POST['service_name']);
    $service_order = test_input($_POST['service_order']);
    $service_description = test_input($_POST['detailed_description']);
    $service_short_description = test_input($_POST['short_description']);
    $service_status = test_input($_POST['status']);
    $service_image = $_FILES['service_image']['name'];

    if (($service_order <= '0') || ($service_order > $max_order)) {
        $error = "Service order should be in 1 and " . $max_order;
    } else if (empty($service_name)) {
        $error = "Service Title should not be empty";
    }

    if ($error == "") {

        if (empty($service_image)) {
            $service_image_name = $old_service_image;
        } else {
            $service_image_dir = '../../../';
            $service_image_replace = str_replace(" ", "_", $service_image);
            $service_image_name = "uploads/services/" . date('YmdHis_') . $service_image_replace;
            $dynamite_upload_directory = 'uploads/services/';
            if (!is_dir($service_image_dir . $dynamite_upload_directory)) {
                mkdir($service_image_dir . $dynamite_upload_directory, 0755, true);
            }
            move_uploaded_file($_FILES['service_image']['tmp_name'], $service_image_dir . $service_image_name);
        }
        //If new  Order order is Lower
        if ($service_order < $old_service_order) {
            $update_order = services_order_to_upper($old_service_order, $service_order, $connection_string);
        }
        //if new order is greater than older order
        else if ($service_order > $old_service_order) {
            $update_order = services_order_to_lower($old_service_order, $service_order, $connection_string);
        }
        //update after updating the order 
        $update_service_query = "UPDATE `services` SET `service_name`='$service_name',`short_description`='$service_short_description',`description`='$service_description',`image`='$service_image_name',`status`='$service_status',`service_order`='$service_order' WHERE `id`='$service_id'";
        $update_service_query_result = mysqli_query($connection_string, $update_service_query);
        if ($update_service_query_result) {
            header('Location:service.php');
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
                            <li class="breadcrumb-item active" aria-current="page"><span>Edit Service</span></li>
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
                                        <h5 class="">Edit Service</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="service_name">Service Name *</label>
                                                            <input type="text" class="form-control mb-4" id="service_name" placeholder="Service Name" value="<?php echo $service_name; ?>" name="service_name">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="service_image">Service Image Recomended Size (72x72)</label><a href="<?php echo $base_url . $old_service_image ?>" target="_blank"><img class="image_size" src="<?php echo $base_url . $old_service_image ?>" alt=""></a>
                                                            <input type="file" class="form-control mb-4" id="service_image" placeholder="Last Name *" value="" name="service_image">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="service_order">Service Order</label>
                                                            <input type="text" class="form-control mb-4" id="service_order" placeholder="Service Order" value="<?php echo $old_service_order ?>" name="service_order">

                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <select class="form-control" id="status" name="status">
                                                                <option <?php echo ($status == '1') ? "selected" : "" ?> value="1">Active</option>
                                                                <option <?php echo ($status == '0') ? "selected" : "" ?> value="0">InActive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="short_description">Short Description</label>
                                                            <textarea type="text" class="form-control mb-4" id="short_description" placeholder="Short Description" name="short_description"><?php echo  $service_short_description; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="detailed_description">Detailed
                                                                Description</label>
                                                            <textarea type="text" class="form-control mb-4" id="detailed_description" placeholder="Detailed Description" name="detailed_description"><?php echo  $service_description; ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 text-right mb-5">
                                                        <button id="add-work-platforms" type="submit" name="submit" class="btn btn-primary">Edit Service</button>
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