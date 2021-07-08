<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../includes/admin_auth.php';
$active_menu = "clients";
/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$error = $success = $client_name = $image_name =  "";
$status = 1;
/*********initialize all fields */
$page_title = "Add Client ";

/*********when user click the add button it validate and then add new testimonial*/
if (isset($_POST['submit'])) {

    //Get Maximum Testimonial Order
    // $maximum_testimonial_order = maximum_testimonial_order($connection_string);
    // $testimonial_order  = $maximum_testimonial_order + 1;

    /**********call test input function to add slashes********/
    $client_name = test_input($_POST['client_name']);
    $status = test_input($_POST['status']);
    $image = $_FILES['image']['name'];

    /***********validate if any required field is empty*******/
    if (empty($client_name)) {
        $error = 'Client Name is required. ';
    } else if (empty($image)) {
        $error = 'Image is required. ';
    }
    /*********if there is no error in any field then insert data */
    if (empty($error)) {
        /*********upload image  */
        $image_replace =  str_replace(" ", "_", $_FILES["image"]["name"]);
        $image_name = "uploads/clients/" . date('YmdHis_') . "--" . $image_replace;
        $image_upload_directory    = 'uploads/clients';
        $image_dir = '../../../';
        if (!is_dir($image_dir . $image_upload_directory)) {
            mkdir($image_dir . $image_upload_directory, 0755, true);
        }
        move_uploaded_file($_FILES['image']['tmp_name'], $image_dir . $image_name);
        /***********insert data into table */
        $add_client_query = "INSERT INTO `clients`(`client_name`, `image`, `status`) VALUES ('$client_name','$image_name','$status')";
        $add_client_query_result = mysqli_query($connection_string, $add_client_query);
        if ($add_client_query_result) {
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
                            <li class="breadcrumb-item active" aria-current="page"><span>Add Client</span></li>
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
                                        <h5 class="">Add Client</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="testimonial_name">Client Name *</label>
                                                            <input type="text" class="form-control mb-4" id="client_name" placeholder="Client Name " value="<?php echo $client_name; ?>" name="client_name" required>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="testimonial_image">Image Recomended Size (400x300)</label>
                                                            <input type="file" class="form-control mb-4" id="image" placeholder="" value="<?php echo $image_name; ?>" name="image" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <select class="form-control" id="status" name="status">
                                                                <option value="<?php echo $status; ?>">Active</option>
                                                                <option value="0">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 text-right mb-5">
                                                        <a href="add_user_registration.php"><button id="add-work-platforms" name="submit" class="btn btn-primary">Add Client</button></a>
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
            <!-- FOOTER END -->