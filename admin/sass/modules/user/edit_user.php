<?php
include '../../../include/config.php';
include '../../../include/functions.php';
// =====>meta tags <=====
$page_title = "Edit User ";;
$meta_description = "showcase";
/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$user_id = $_GET['user_id'];
$error = $success = $first_name = $last_name = $phone_number = $organization = $status = $event_id = "";
//Get User Info By id
$user_info = get_user_info_by_id($connection_string, $user_id);
$user_info_list = $user_info['get_info'];
//Get User Values
$first_name = $user_info_list->first_name;
$last_name = $user_info_list->sur_name;
$user_email = $user_info_list->email;
$phone_number = $user_info_list->phone_number;
$organization = $user_info_list->organization;
$status = $user_info_list->status;
$event_id = $user_info_list->event_id;
// ====>event list<=====
$get_event_id = get_event_list($connection_string, 'events');
$get_event_id_result = $get_event_id['get_info'];
if (isset($_POST['submit'])) {
    // ====>call test input function to add slashes<=====
    $first_name = test_input($_POST['first_name']);
    $last_name = test_input($_POST['last_name']);
    $user_email = email_validation($_POST['email_address']);
    $phone_number = test_input($_POST['phone_number']);
    $organization = test_input($_POST['organization']);
    //Email validation
    $user_email = email_validation($user_email);
    $status = $_POST['status'];
    $event_id = $_POST['event'];
    if (empty($first_name)) {
        $error = 'First Name is required. ';
    } elseif ($user_email == false) {
        $error = "Email is not valid";
    } else if (empty($last_name)) {
        $error = 'Last Name  is required. ';
    } else if (empty($organization)) {
        $error = 'Organization is required. ';
    }
    if (empty($error)) {
        // =======>Update user <=====
        $update_user = "UPDATE `subscribers` SET `first_name` = '$first_name', `sur_name`='$last_name', `email`='$user_email', `organization`='$organization',`event_id`='$event_id',`status`='$status',`phone_number`='$phone_number' WHERE `id`='$user_id' ";
        $update_user_result = mysqli_query($connection_string, $update_user);
        if ($update_user_result == true) {
            $success = "User is Updated Successfully";
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
                            <li class="breadcrumb-item active" aria-current="page"><span>Add User</span></li>
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
                                        <h5 class="">Edit User</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="first_name">First Name *</label>
                                                            <input type="text" class="form-control mb-4" id="first_name" placeholder="First Name " name="first_name" value="<?php echo $first_name; ?>" required>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="last_name">Last Name *</label>
                                                            <input type="text" class="form-control mb-4" id="last_name" placeholder="Last Name " value="<?php echo $last_name; ?>" name="last_name" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="location">Email Address *</label>
                                                            <input type="Email" class="form-control mb-4" id="Email Address" required placeholder="Email Address" value="<?php echo $user_email; ?>" name="email_address" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="location">Phone Number *</label>
                                                            <input type="text" class="form-control mb-4" id="Phone Number" required placeholder="Phone Number" value="<?php echo $phone_number; ?>" name="phone_number" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="phone">Organization *</label>
                                                            <input type="text" class="form-control mb-4" id="Organization" required placeholder="Organization" value="<?php echo $organization; ?>" name="organization" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="email">Status</label>
                                                            <select class="form-control" id="Status" name="status">

                                                                <option <?php echo ($status == 1) ? "selected" : "" ?> value="1">Active </option>
                                                                <option <?php echo ($status == 0) ? "selected" : "" ?> value="0">Non Active</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">

                                                            <label for="email">Event</label>
                                                            <select class="form-control" id="Event" name="event">
                                                                <?php foreach ($get_event_id_result as $value) { ?>
                                                                    <option <?php echo ($event_id == $value['event_id']) ? "selected" : "" ?> value="<?= $value['event_id']  ?>">
                                                                        <?= $value['title']  ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 text-right mb-5">
                                                        <button id="add-work-platforms" class="btn btn-primary" type="submit" name="submit">Edit User</button>
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