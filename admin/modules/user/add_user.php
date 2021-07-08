<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../includes/admin_auth.php';
$active_menu = "subcribers";
// =====>meta tags <=====
$page_title = "Add User ";;
$meta_description = "showcase";
/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$error = $success = $first_name = $last_name = $email_address  = $success = $error = $organization = '';
$status = 1;
// ====>event list<=====
$get_event_id = get_event_list($connection_string, 'events');
$get_event_id_result = $get_event_id['get_info'];
if (isset($_POST['submit'])) {
    // ====>call test input function to add slashes<=====
    $first_name = test_input($_POST['first_name']);
    $last_name = test_input($_POST['last_name']);
    $email_address = email_validation($_POST['email_address']);
    $email_address_exist = email_exist($connection_string, $email_address);
    // $phone_number = test_input($_POST['phone_number']);
    $organization = test_input($_POST['organization']);
    $ticket_number = getToken(10);
    $token = getToken(10);
    $register_date = date('Y-m-d H:i:s');
    $pwd_options = ['cost' => 8,];
    $hashed_password = password_hash($ticket_number, PASSWORD_BCRYPT, $pwd_options);
    $subscription_type = 1;
    $ticket_price = 0;
    $current_date = new DateTime(date('Y-m-d'));
    $expiry_date = $current_date->modify("+14 days");
    $expiry_date = $expiry_date->format("Y-m-d");
    $status = $_POST['status'];
    $event = $_POST['event'];
    if (empty($first_name)) {
        $error = 'First Name is required. ';
    } else if (empty($last_name)) {
        $error = 'Last Name  is required. ';
    } else if ($email_address == false) {
        $error = 'Email is not valid. ';
    } else if ($email_address_exist == false) {
        $error = 'Email exists Already.';
    } else if (empty($organization)) {
        $error = 'Organization is required. ';
    }
    if (empty($error)) {
        // =======>insert user <=====
        $add_user = "INSERT INTO `subscribers`(`first_name`, `email`, `sur_name`, `ticket_number`, `event_id`, `register_date`, `organization`, `status`, `subscription_type`, `ticket_price`, `session_id`, `streaming_expiry_date`, `password`) VALUES ('$first_name','$email_address','$last_name','$ticket_number','$event','$register_date','$organization','$status','$subscription_type','$ticket_price','$token','$expiry_date','$hashed_password')";
        $add_user_result = mysqli_query($connection_string, $add_user);
        if ($add_user_result == true) {
            $email_address = mysqli_real_escape_string($connection_string, $email_address);
            $exist_subscriber = get_user_info_by_email($connection_string, $email_address);
            $exist_subscriber_info = $exist_subscriber['get_info'];
            if ($exist_subscriber['status'] == 1) {
                $user_id = $exist_subscriber_info->id;
                $user_purchased_event = user_purchased_event($connection_string, $user_id, $event);
                $user_purchased_event_info = $user_purchased_event['get_info'];
                if ($user_purchased_event['status'] == 1) {
                    $error = "Selected user has already purchased this event";
                } else {
                    $payment_date = mysqli_real_escape_string($connection_string, date('Y-m-d H:i:s'));
                    $amount = '0';
                    $currency = 'GBP';
                    $payment_query = "INSERT INTO `event_payment` (`user_id`, `email`, `event_id`, `currency`, `amount`, `payment_date`) VALUES ('" . $user_id . "', '" . $email_address . "', '" . $event . "', '" . $currency . "', '" . $amount . "', '" . $payment_date . "')";
                    $payment_query_result = mysqli_query($connection_string, $payment_query);
                    if ($payment_query != true) {
                        $error = $error_support;
                    } else {
                        $event_subscribe = "INSERT INTO `subscribed_event` (`user_id`,  `event_id`) VALUES ('" . $user_id . "',  '" . $event . "')";
                        $event_subscribe_result = mysqli_query($connection_string, $event_subscribe);
                        if ($event_subscribe_result) {
                            header('location:user_list.php');
                        } else {
                            $error = $error_support;
                        }
                    }
                }
            }
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
                                        <h5 class="" style="padding-left: 35px;">Add User</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="First Name">First Name *</label>
                                                            <input type="text" class="form-control mb-4" id="First Name " placeholder="First Name " name="first_name" value="<?php echo $first_name; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="address">Last Name *</label>
                                                            <input type="text" class="form-control mb-4" id="Last Name *" placeholder="Last Name " value="<?php echo $last_name; ?>" name="last_name" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="location">Email Address *</label>
                                                            <input type="Email" class="form-control mb-4" id="Email Address" placeholder="Email Address" value="<?php echo $email_address; ?>" name="email_address" required>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="location">Phone Number *</label>
                                                            <input type="number" class="form-control mb-4" id="Phone Number" placeholder="Phone Number" value="<?php echo $phone_number; ?>" name="phone_number" required>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="phone">Organization *</label>
                                                            <input type="text" class="form-control mb-4" id="Organization" placeholder="Organization" value="<?php echo $organization; ?>" name="organization" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="email">Status</label>
                                                            <select class="form-control" id="Status" name="status">

                                                                <option value="1">Active </option>
                                                                <option value="0">Non Active</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">

                                                            <label for="email">Event</label>
                                                            <select class="form-control" id="Event" name="event">
                                                                <?php foreach ($get_event_id_result as $value) { ?>
                                                                    <option value="<?= $value['event_id']  ?>">
                                                                        <?= $value['title']  ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 text-right mb-5">
                                                        <button id="add-work-platforms" class="btn btn-primary" type="submit" name="submit">Save</button>
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