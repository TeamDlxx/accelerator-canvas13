<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../includes/admin_auth.php';
$active_menu = "setting";
// =====>meta tags <=====
$page_title = "Change Password ";;
$meta_description = "showcase";
/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$error = $success = $old_password = $new_password = $confirm_password = $encrypted_password = '';
/********admin info******/
$admin_info = $_SESSION['admin_info'];
$old_admin_password = $admin_info->admin_password;
$admin_id = $admin_info->admin_id;
/*******when user click save button it will validate fields and then change the password */
if (isset($_POST['submit'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    /*****check if any field is empty */
    if (empty($old_password)) {
        $error = "Old password is required";
    } else if (empty($confirm_password)) {
        $error = "Confirm Password is required";
    } else if (password_verify($old_password, $old_admin_password) == false) {
        $error    =   "Old Password is not correct";
    } else  if ($confirm_password != $new_password) {
        $error    =   "Confirm Password and New Password doesn't match";
    }
    if ($error == "") {
        $password_options = ['cost' => 8];
        $encrypted_password = password_hash($new_password, PASSWORD_BCRYPT, $password_options);
        $update_password_query = "UPDATE `admin_users` set `admin_password`='$encrypted_password' where `admin_id`='$admin_id'";
        $update_password_query_result = mysqli_query($connection_string, $update_password_query);
        if ($update_password_query_result) {
            header('Location:../../index.php');
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
                            <li class="breadcrumb-item active" aria-current="page"><span>Change Password</span></li>
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
                                        <h5 class="">Change Password</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="old_password">Old Password *</label>
                                                            <input type="password" class="form-control mb-4" id="old_password" placeholder="Old Password " name="old_password" value="<?php echo $old_password; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="new_password">New Password*</label>
                                                            <input type="password" class="form-control mb-4" id="new_password" placeholder="New Password" value="<?php echo $new_password; ?>" name="new_password" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="confirm_password">Confirm Password*</label>
                                                            <input type="password" class="form-control mb-4" id="confirm_password" placeholder="Confirm Password" value="<?php echo $confirm_password; ?>" name="confirm_password" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 text-right mb-5">
                                                        <button id="add-work-platforms" class="btn btn-primary" type="submit" name="submit">Confirm Changes</button>
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
            </div>
        </div>

        <!-- FOOTER BEGIN -->
        <?php include '../../includes/footer.php'; ?>
        <!-- FOOTER END -->