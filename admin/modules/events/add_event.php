<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../../include/resize-class.php';
include '../../includes/admin_auth.php';
$active_menu = "events";
$page_title = "Add Events ";;
$meta_description = "showcase";
/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$error = $success = $title = $tag_line = $live_embed_code = $is_streaming_live = $start_date_time = $end_date_time = $free_registration = $event_currency = $event_price = $featured_event = $main_image_name = $event_description = $thanks_message = $purchase_email_body = $register_email_body = "";
$status = $is_streaming_live = $free_registration = $show_on_home = $featured_event = 1;

/***********when user click on add event button then after all validations it will add the new event******/
if (isset($_POST['add_event'])) {
    //========= Validate Input Fields =======//
    $title = test_input($_POST['title']);
    $tag_line = test_input($_POST['tag_line']);
    $live_embed_code = test_input($_POST['live_embed_code_zoom_metting_instruction']);
    $is_streaming_live = test_input($_POST['streaming_live']);
    $start_date_time = date('Y-m-d', strtotime($_POST['start_date_time']));
    $end_date_time = date('Y-m-d', strtotime($_POST['end_date_time']));
    $free_registration = test_input($_POST['free_registration']);
    $event_currency = test_input($_POST['event_currency']);
    $event_price = test_input($_POST['event_price']);
    $featured_event = test_input($_POST['featured_event']);
    $event_description = test_input($_POST['event_description']);
    $thanks_message = test_input($_POST['thanks_message']);
    $purchase_email_body = test_input($_POST['purchase_email_body']);
    $register_email_body = test_input($_POST['register_email_body']);
    $show_on_home = test_input($_POST['show_on_home']);
    $main_image_name = $_FILES['event_image']['name'];
    /*******chechk if title is less than 5 chracters or greater than 200 chracters */
    if (strlen($title) < 5 or strlen($title) > 200) {
        $error = "Minimum 5 and maximum 200 chracters allowed for title";
    } elseif (empty($tag_line)) {
        $error = "Tage line should not be empty";
    } elseif (empty($live_embed_code)) {
        $error = "Live Embed Code should not be empty";
    } elseif (empty($start_date_time)) {
        $error = "Start Date Should  not be empty";
    } elseif (empty($end_date_time)) {
        $error = "End Date  should not be empty";
    } elseif (empty($event_currency)) {
        $error = "Event Currency should not be empty";
    } elseif (is_numeric($event_price) && $event_price < 1) {
        $error = "Event price is not valid";
    } elseif (empty($main_image_name)) {
        $error = "Event Image  should not be empty";
    } elseif (empty($event_description)) {
        $error = "Event Description should not be empty";
    } elseif (empty($thanks_message)) {
        $error = "Thanks Message should not be empty";
    } elseif (empty($purchase_email_body)) {
        $error = "Purchase Email Body should not be empty";
    } elseif (empty($register_email_body)) {
        $error = "Register Email Body should not be empty";
    } //if error is empty then upload image and then insert data in data base
    if ($error == "") {
        // main image upload
        $main_image_replace =  str_replace(" ", "_", $_FILES["event_image"]["name"]);
        $main_image_name  =  "uploads/events/" . date('YmdHis_') . "--" . $main_image_replace;
        $main_image_upload_directory = 'uploads/events';
        $image_directory = '../../../';
        if (!is_dir($image_directory . $main_image_upload_directory)) {
            mkdir($image_directory . $main_image_upload_directory, 0755, true);
        }
        move_uploaded_file($_FILES['event_image']['tmp_name'], $image_directory . $main_image_name);
        //resize image
        $resizeObj = new resize($image_directory . $main_image_name);
        $resizeObj->resizeImage(294, 196, 'crop');
        $resizeObj->saveImage($image_directory . $main_image_name, 100);
        //insert event data
        $insert_event_query = "INSERT INTO `events`( `title`, `tagline`, `live_embed_code`, `start_date_time`, `end_date_time`, `is_current_live`, `status`, `free_registration`,`event_currency`,`event_price`, `image`, `featured_event`, `show_home`,`event_description`,`thanks_message`,`email_body`,`register_email_body`) VALUES ('$title','$tag_line','$live_embed_code','$start_date_time','$end_date_time','$is_streaming_live','" . $_POST['status'] . "','$free_registration','$event_currency','$event_price','$main_image_name','$featured_event','$show_on_home','$event_description','$thanks_message','$purchase_email_body','$register_email_body')";
        $insert_event_query_result = mysqli_query($connection_string, $insert_event_query);
        if ($insert_event_query_result) {
            header('Location:events.php');
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
                            <li class="breadcrumb-item active" aria-current="page"><span>Add Events</span></li>
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
                                        <h5 class="">Add Events</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="Title">Tite *</label>
                                                            <input type="text" class="form-control mb-4" id="Title" placeholder="Title" value="<?php echo $title; ?>" name="title" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="tag_line">Tag Line *</label>
                                                            <input type="text" class="form-control mb-4" id="tag_line" placeholder="Tag Line " value="<?php echo $tag_line; ?>" name="tag_line" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="location">Start Date Time *</label>
                                                            <input type="date" name="start_date_time" required class="form-control has-feedback-left" id="start_date_time" placeholder="Event Start Date & Time" value="<?php echo $start_date_time; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="end_date_time">End Date Time</label>
                                                            <input type="date" class="form-control mb-4" id="end_date_time" placeholder="End Date Time" value="<?php echo $end_date_time; ?>" name="end_date_time" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <select class="form-control" id="status" name="status">
                                                                <option selected value="<?php echo $status ?>">Active
                                                                </option>
                                                                <option value="0">InActive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="streaming_live">Is Streaming Live</label>
                                                            <select class="form-control" id="streaming_live" name="streaming_live">
                                                                <option selected value="<?php echo $is_streaming_live ?>">Yes
                                                                </option>
                                                                <option value="0">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="show_on_home">Show On Home</label>
                                                            <select class="form-control" id="show_on_home" name="show_on_home">
                                                                <option selected value="<?php echo $show_on_home ?>">Yes
                                                                </option>
                                                                <option value="0">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="free_registration">Free Registration</label>
                                                            <select class="form-control" id="free_registration" name="free_registration">
                                                                <option selected value="<?php echo $free_registration ?>">Yes
                                                                </option>
                                                                <option value="0">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="event_currency">Event Currency</label>
                                                            <select class="form-control" id="event_currency" name="event_currency">
                                                                <option selected value="USD">Dollars</option>
                                                                <option value="EUR">Euro</option>
                                                                <option value="GBP">Pound</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="event_price">Event Price *</label>
                                                            <input type="number" class="form-control mb-4" id="event_price" placeholder="Event Price" value="<?php echo $event_price; ?>" name="event_price" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="featured_event">Featured Event</label>
                                                            <select class="form-control" id="featured_event" name="featured_event">
                                                                <option selected value="1">Yes</option>
                                                                <option value="0">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="event_image">Image*</label>
                                                            <input type="file" class="form-control mb-4" id="event_image" placeholder="Image" value="<?php echo $main_image_name; ?>" name="event_image" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="live_embed_code_zoom_metting_instruction">Live
                                                                Embed Code/Zoom Metting Instruction*</label>
                                                            <textarea type="text" class="form-control mb-4" id="live_embed_code_zoom_metting_instruction" placeholder="live_embed_code_zoom_metting_instruction" value="" name="live_embed_code_zoom_metting_instruction" required><?php echo $live_embed_code; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="event_description">Event Description*</label>
                                                            <textarea type="text" class="form-control mb-4" id="event_description" placeholder="Event Description" value="" name="event_description" required><?php echo $event_description; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="thanks_message">Thanks Message*</label>
                                                            <textarea type="text" class="form-control mb-4" id="thanks_message" placeholder="Thanks Message" value="" name="thanks_message" required><?php echo $thanks_message; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="purchase_email_body">Purchase Email
                                                                Body*</label>
                                                            <textarea type="text" class="form-control mb-4" id="purchase_email_body" placeholder="Purchase Email Body" value="" name="purchase_email_body" required><?php echo $purchase_email_body; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="register_email_body">Register Email
                                                                Body*</label>
                                                            <textarea type="text" class="form-control mb-4" id="register_email_body" placeholder="Register Email Body*" value="" name="register_email_body" required><?php echo $register_email_body; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 text-right mb-5">
                                                        <button name="add_event" type="submit" id="add-work-platforms" class="btn btn-primary">Add Event</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <?php include '../../includes/footer.php'; ?>
                            <script>
                                CKEDITOR.replace('live_embed_code_zoom_metting_instruction', {
                                    filebrowserUploadUrl: '../../upload.php',
                                    filebrowserUploadMethod: "form"
                                });
                                CKEDITOR.replace('register_email_body', {
                                    filebrowserUploadUrl: '../../upload.php',
                                    filebrowserUploadMethod: "form"
                                });
                                CKEDITOR.replace('purchase_email_body', {
                                    filebrowserUploadUrl: '../../upload.php',
                                    filebrowserUploadMethod: "form"
                                });
                                CKEDITOR.replace('thanks_message', {
                                    filebrowserUploadUrl: '../../upload.php',
                                    filebrowserUploadMethod: "form"
                                });
                                CKEDITOR.replace('event_description', {
                                    filebrowserUploadUrl: '../../upload.php',
                                    filebrowserUploadMethod: "form"
                                });
                            </script>