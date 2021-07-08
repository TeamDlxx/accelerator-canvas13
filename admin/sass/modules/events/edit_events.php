<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../../include/resize-class.php';
$page_title = "Edit Events ";;
$meta_description = "showcase";
/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$error = "";
$success = "";

//get event id where user want to update
$event_id = $_GET['event_id'];
//Get Event details by Id
$edit_event_data = get_events_info_id($connection_string, $event_id);
$edit_event_info = $edit_event_data['get_info'];
$title = stripslashes($edit_event_info->title);
$tag_line = stripslashes($edit_event_info->tagline);
$start_date_time = stripslashes($edit_event_info->start_date_time);
$start_date_time = date('Y-m-d', strtotime($start_date_time));
$end_date_time = stripslashes($edit_event_info->end_date_time);
$end_date_time = date('Y-m-d', strtotime($end_date_time));
$thanks_message = stripslashes($edit_event_info->thanks_message);
$old_event_image = $edit_event_info->image;
$event_price = stripslashes($edit_event_info->event_price);
$live_embed_code = stripslashes($edit_event_info->live_embed_code);
$is_streaming_live = stripslashes($edit_event_info->is_current_live);
$status = stripslashes($edit_event_info->status);
$event_currency = stripslashes($edit_event_info->event_currency);
$show_on_home = stripslashes($edit_event_info->show_home);
$featured_event = stripslashes($edit_event_info->featured_event);
$free_registration = stripslashes($edit_event_info->free_registration);
$register_email_body = stripslashes($edit_event_info->register_email_body);
$purchase_email_body = stripslashes($edit_event_info->email_body);
$event_description = stripslashes($edit_event_info->event_description);
/***********when user press updat event button first check for field validations and then update data into data base */
if (isset($_POST['edit_event'])) {
    /*********Add slashes ****/
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

    /***********Validations of input fields ********/
    if (strlen($title) < 5 or strlen($title) > 200) {
        $error = "Minimum 5 and maximum 200 chracters allowed for title";
    } elseif (empty($tag_line)) {
        $error = "Tage line should not be empty";
    } elseif (empty($live_embed_code)) {
        $error = "Live Embed Code should not be empty";
    } elseif (empty($start_date_time)) {
        $error = "Start Date Should  not be empty";
    } elseif (empty($end_date_time)) {
        $error = "End Date Should  not be empty";
    } elseif (empty($event_currency)) {
        $error = "Event Currency should not be empty";
    } elseif (empty($event_price)) {
        $error = "Event price should not be empty";
    } elseif (empty($event_description)) {
        $error = "Event Description should not be empty";
    } elseif (empty($thanks_message)) {
        $error = "Thanks Message should not be empty";
    } elseif (empty($purchase_email_body)) {
        $error = "Purchase Email Body should not be empty";
    } elseif (empty($register_email_body)) {
        $error = "Register Email Body should not be empty";
    }
    if ($error == "") { //if there is no error move image then update data in datbase
        if (empty($_FILES['event_image']['name'])) { //if image is empty than send old image
            $main_image_name = $old_event_image;
        } else {
            /*********Add new image******/
            $event_image_replace = str_replace(" ", "_", $_FILES['event_image']['name']);
            $main_image_name = "uploads/events/" . date('YmdHis_') . $event_image_replace;
            $dynamite_upload_directory = 'uploads/events/';
            $image_directory = '../../../';
            if (!is_dir($image_directory . $dynamite_upload_directory)) {
                mkdir($image_directory . $dynamite_upload_directory, 0755, true);
            }
            move_uploaded_file($_FILES['event_image']['tmp_name'], $image_directory . $main_image_name);
            $resizeObj = new resize($image_directory . $main_image_name);
            $resizeObj->resizeImage(570, 321, 'crop');
            $resizeObj->saveImage($image_directory . $main_image_name, 100);
        }
        /************update event data */
        $update_event_query = "update `events` set `title`='$title', `tagline`='$tag_line', `start_date_time`='$start_date_time', `end_date_time`='$end_date_time', `live_embed_code`='$live_embed_code', `is_current_live`='$is_streaming_live',`status`='" . $_POST['status'] . "',`image`='$main_image_name',`free_registration`='$free_registration',`event_price`='$event_price' , `event_currency`='$event_currency',`show_home`='$show_on_home', `event_description`='$event_description',`featured_event`='$featured_event',`thanks_message`='$thanks_message', `email_body`='$purchase_email_body',`register_email_body`='$register_email_body'  where `event_id`='$event_id'";
        $update_query_result = mysqli_query($connection_string, $update_event_query);
        if ($update_query_result) {
            $success = "Updated Successfully";
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
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Edit</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><span>Events</span></li>
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
                                <form id="contact" class="section contact" enctype="multipart/form-data" method="POST">
                                    <div class="info">
                                        <h5 class="">Edit Event</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="Title">Tite *</label>
                                                            <input type="text" class="form-control mb-4" id="Title" placeholder="Title" value="<?php echo $title ?>" name="title" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="tag_line">Tag Line *</label>
                                                            <input type="text" class="form-control mb-4" id="tag_line" placeholder="Tag Line *" value="<?php echo $tag_line ?>" name="tag_line" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="location">Start Date Time *</label>
                                                            <input type="date" name="start_date_time" required="required" class="form-control " id="start_date_time" placeholder="Event Start Date & Time" value="<?php echo $start_date_time; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="end_date_time">End Date Time</label>
                                                            <input type="date" class="form-control mb-4" placeholder="End Date Time" value="<?= $end_date_time; ?>" name="end_date_time" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <select class="form-control" id="status" name="status">
                                                                <option value="1" <?php echo ($status == '1') ? "selected" : "" ?>>Active</option>
                                                                <option value="0" <?php echo ($status == '0') ? "selected" : "" ?>>Non Active</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="streaming_live">Is Streaming Live</label>
                                                            <select class="form-control" id="streaming_live" name="streaming_live">
                                                                <option <?php echo ($is_streaming_live == '1') ? "selected" : "" ?> value="1">Yes</option>
                                                                <option <?php echo ($is_streaming_live == '0') ? "selected" : "" ?> value="0">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="show_on_home">Show On Home</label>
                                                            <select class="form-control" id="show_on_home" name="show_on_home">
                                                                <option <?php echo ($show_on_home == '1') ? "selected" : "" ?> value="1">Yes</option>
                                                                <option <?php echo ($show_on_home == '0') ? "selected" : "" ?> value="0">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="free_registration">Free Registration</label>
                                                            <select class="form-control" id="free_registration" name="free_registration">
                                                                <option <?php echo ($free_registration == '1') ? "selected" : "" ?> value="1">Yes</option>
                                                                <option <?php echo ($free_registration == '0') ? "selected" : "" ?> value="0">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="event_currency">Event Currency</label>
                                                            <select class="form-control" id="event_currency" name="event_currency">
                                                                <option <?php echo ($event_currency == 'USD') ? "selected" : "" ?> value="USD">Dollars</option>
                                                                <option <?php echo ($event_currency == 'EUR') ? "selected" : "" ?> value="EUR">Euro</option>
                                                                <option <?php echo ($event_currency == 'GBP') ? "selected" : "" ?> value="GBP">Pound</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="event_price">Event Price *</label>
                                                            <input type="text" class="form-control mb-4" id="event_price" required placeholder="Event Price" value="<?php echo $edit_event_info->event_price; ?>" name="event_price">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="featured_event">Featured Event</label>
                                                            <select class="form-control" id="featured_event" name="featured_event">
                                                                <option <?php echo ($featured_event == '1') ? "selected" : "" ?> value="1">Yes</option>
                                                                <option <?php echo ($featured_event == '0') ? "selected" : "" ?> value="0">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="event_image">Image*</label>
                                                            <input type="file" class="form-control mb-4" required id="event_image" placeholder="Image" value="" name="event_image">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="live_embed_code_zoom_metting_instruction">Live Embed Code/Zoom Metting Instruction*</label>
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
                                                            <label for="purchase_email_body">Purchase Email Body*</label>
                                                            <textarea type="text" class="form-control mb-4" id="purchase_email_body" placeholder="Purchase Email Body" value="" name="purchase_email_body" required><?php echo $purchase_email_body; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="register_email_body">Register Email Body*</label>
                                                            <textarea type="text" class="form-control mb-4" id="register_email_body" placeholder="Register Email Body" value="" name="register_email_body" required><?php echo $register_email_body; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 text-right mb-5">
                                                        <button name="edit_event" type="submit" id="add-work-platforms" class="btn btn-primary">Edit Event</button>
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
                                    filebrowserUploadUrl: 'upload.php',
                                    filebrowserUploadMethod: "form"
                                });
                                CKEDITOR.replace('register_email_body', {
                                    filebrowserUploadUrl: 'upload.php',
                                    filebrowserUploadMethod: "form"
                                });
                                CKEDITOR.replace('purchase_email_body', {
                                    filebrowserUploadUrl: 'upload.php',
                                    filebrowserUploadMethod: "form"
                                });
                                CKEDITOR.replace('thanks_message', {
                                    filebrowserUploadUrl: 'upload.php',
                                    filebrowserUploadMethod: "form"
                                });
                                CKEDITOR.replace('event_description', {
                                    filebrowserUploadUrl: 'upload.php',
                                    filebrowserUploadMethod: "form"
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <!--  END CONTENT AREA  -->
            </div>