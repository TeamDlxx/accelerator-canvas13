<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../includes/admin_auth.php';
$active_menu = "testimonial";
$page_title = "Testimonials ";
$datatable = true;

/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$error = $success = "";
//Delete Testimonials===//
if (isset($_GET['action']) && $_GET['action'] == "delete") {
    $testimonial_id = $_GET['testimonial_id'];
    $del_order = $_GET['del_order'];
    $max_order = get_maximum_order($connection_string, "testimonial", "testimonial_order");
    delete_order($connection_string, $del_order, $max_order);
    $delete_testimonial_query = "DELETE FROM `testimonial` WHERE `testimonial_id`='$testimonial_id'";
    $delete_testimonial_query_result = mysqli_query($connection_string, $delete_testimonial_query);
    if ($delete_testimonial_query_result) {
        $success = "Testimonial is deleted";
    } else {
        $error = $error_support;
    }
}
if (isset($_POST['add'])) {
    header('Location:add_testimonial.php');
}
if (isset($_POST['submit'])) {

    if (isset($_POST['delete_id']) && $_POST['delete_id'] != '') {
        $del_id = $_POST['delete_id'];
        // echo '<script>confirm("Are You Sure You Want to Delete the item")</script>';
        $delete_record = implode(",", $del_id);
        $delete_item = "DELETE FROM `testimonial` WHERE testimonial_id in ($delete_record)";
        $delete_item_result = mysqli_query($connection_string, $delete_item);
        if ($delete_item_result) {
            $success = "Testimonial deleted successfully";
        } else {
            $error = $error_support;
        }
    }
}
//===get event data==//
$testimonial_result = get_testimonial_info($connection_string);
$testimonial_result_data = $testimonial_result['get_info'];


?>

<!--  HEADER  -->
<?php include '../../includes/header.php'; ?>
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
                            <!-- <li class="breadcrumb-item"><a href="javascript:void(0);">Testimonials</a></li> -->
                            <li class="breadcrumb-item active" aria-current="page"><span>Testimonials</span></li>
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
            <div class="row layout-top-spacing">
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
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <form action="" method="POST">
                            <div class="col-md-12 text-right mb-5">
                                <a href="add_testimonial.php"><button type="submit" name="add" id="add-work-platforms" class="btn btn-primary">Add
                                        New
                                        Testimonial </button></a>
                                <button type="submit" onclick="delete_confirm()" name="submit" id="add-work-platforms" class="btn btn-danger">Delete</button>

                            </div>
                            <div class="table-responsive mb-4 mt-4">

                                <table id="html5-extension" class="table table-hover non-hover cheked  table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th><input id="checkall" type="checkbox"></th>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Testimonial Order</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php if ($testimonial_result['status'] == 1) {
                                            $count = 1;
                                            foreach ($testimonial_result_data as $testimonial_data_values) { ?>
                                                <tr>
                                                    <td><input class="check_item" name="delete_id[]" value="<?php echo $testimonial_data_values['testimonial_id']; ?>" type="checkbox"></td>
                                                    <td><?php echo $count;
                                                        $count++; ?></td>
                                                    <td><?php echo $testimonial_data_values['testimonial_name']; ?></td>
                                                    <td><?php echo $testimonial_data_values['testimonial_order']; ?></td>
                                                    <td><?php echo ($testimonial_data_values['status'] == '1') ? "Active" : "InActive"; ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-dark btn-sm"><a href="">Open</a></button>
                                                            <button type="button" class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                                </svg>
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                                                <a class="dropdown-item" href="edit_testimonial.php?testimonial_id=<?= $testimonial_data_values['testimonial_id']; ?>">Edit</a>
                                                                <a class="dropdown-item" href="testimonials.php?testimonial_id=<?= $testimonial_data_values['testimonial_id']; ?>&action=delete&del_order=<?= $testimonial_data_values['testimonial_order']; ?>" onclick="return confirm('Are you sure you want to delete the Testimonial?')">Delete</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                </table>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!--  FOOTER  -->
    <?php include '../../includes/footer.php'; ?>
    <script>
        $(document).ready(function() {
            $("#checkall").click(function() {
                if ($(this).is(':checked')) {
                    $(".check_item").prop('checked', true)
                } else {
                    $(".check_item").prop('checked', false)
                }
            })
        })

        function delete_confirm() {
            if ($('.check_item:checked').length > 0) {
                var result = confirm("Are you sure to delete selected Records?");
                if (result) {
                    return true;
                } else {
                    event.preventDefault();
                }
            } else {
                alert('Select at least 1 record to delete.');
                event.preventDefault();
            }
        }
    </script>