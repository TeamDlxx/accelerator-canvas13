<?php
include '../../../include/config.php';
include '../../../include/functions.php';
$page_title = "User List ";
$datatable = true;;
$meta_description = "showcase";
/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$error = $success = '';
// =====>delete user<=====
if (isset($_GET['action']) and $_GET['action'] == 'delete') {
    $user_id = $_GET['user_id'];
    $delete_user_query = "DELETE FROM `subscribers` WHERE id =$user_id";
    $delete_user_query_result =  mysqli_query($connection_string, $delete_user_query);
    if ($delete_user_query_result) {
        $success = "User is deleted";
    } else {
        $error = $error_support;
    }
}
// =====>user list<=====
$user_listing = get_user_list($connection_string);
$user_listing_info = $user_listing['get_info'];

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
                            <!-- <li class="breadcrumb-item"><a href="javascript:void(0);">User</a></li> -->
                            <li class="breadcrumb-item active" aria-current="page"><span>User Registration</span></li>
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
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="col-md-12 text-right mb-5">
                            <a href="add_user.php"><button id="add-work-platforms" class="btn btn-primary">Add New
                                    User</button></a>
                        </div>
                        <div class="table-responsive mb-4 mt-4">
                            <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Mobile No</th>
                                        <th>Registration Date</th>
                                        <th>Registration time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($user_listing['get_info'] > 0) {
                                        $count = 0;
                                        foreach ($user_listing_info as $user_value) {
                                            $count++ ?>

                                            <tr>
                                                <td><?php echo $count; ?></td>
                                                <td><?php echo $user_value['first_name']; ?></td>
                                                <td><?php echo $user_value['sur_name']; ?></td>
                                                <td><?php echo $user_value['email']; ?></td>
                                                <td><?php echo $user_value['phone_number']; ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($user_value['register_date'])) ?></td>
                                                <td><?php echo date('H:i:s', strtotime($user_value['register_date'])) ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-dark btn-sm">Open</button>
                                                        <button type="button" class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                                                <polyline points="6 9 12 15 18 9"></polyline>
                                                            </svg>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                                            <a class="dropdown-item" href="user_list.php?user_id=<?= $user_value['id']; ?>&action=delete">Delete</a>
                                                            <a class="dropdown-item" href="edit_user.php?user_id=<?= $user_value['id']; ?>">Edit</a>
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                    <?php
                                        }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!--  FOOTER  -->
        <?php include '../../includes/footer.php'; ?>