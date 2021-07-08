<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../../include/resize-class.php';
$page_title = "Edit Video ";;
$meta_description = "showcase";
/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$error = $success = $cover_thumbnail1 = $short_description = $description = $old_video_image = $live_embed_code = $event_id = $old_video_order = "";
/***************Get testimonial data by id to update ****************/
$event_video_id = $_GET['event_video_id'];
$edit_event_video_data = get_event_video_by_id($connection_string, $event_video_id);
$edit_event_video_info = $edit_event_video_data['get_info'];
$title = stripslashes($edit_event_video_info->video_title);
$short_description = stripslashes($edit_event_video_info->video_short_description);
$description = stripslashes($edit_event_video_info->video_short_description);
$free_access = stripslashes($edit_event_video_info->free_video);
$status = stripslashes($edit_event_video_info->video_status);
$old_video_image = $edit_event_video_info->video_image;
$old_video_order = $edit_event_video_info->video_order;
$live_embed_code = $edit_event_video_info->video_embed_code;
$event_id = $edit_event_video_info->event_id;
$old_cover_thumbnail1 = $edit_event_video_info->thumbnail;
echo $old_cover_thumbnail1;
/*********Get Event Video maximum  Order */
$max_order = get_maximum_order($connection_string, "event_videos", "video_order");
/********Get Events */
$event_list = get_events_info($connection_string);
$event_list_result = $event_list['get_info'];

/*************Update Event Video *******/
if (isset($_POST['submit'])) {
    $title = test_input($_POST['title']);
    $video_order = test_input($_POST['video_order']);
    $description = test_input($_POST['detailed_description']);
    $short_description = test_input($_POST['short_description']);
    $status = test_input($_POST['status']);
    $live_embed_code = test_input($_POST['video_embed_code']);
    $event_id = test_input($_POST['events']);
    $image = $_FILES['image'];
    if (($video_order <= '0') || ($video_order > $max_order)) {
        $error = "Video order should be in 1 and " . $max_order;
    } else if (empty($title)) {
        $error = "Video should not be empty";
    } else if (empty($description)) {
        $error = "Video  Description should not be empty";
    } else if (empty($live_embed_code)) {
        $error = "Video Embed Code should not be empty";
    } else if (empty($short_description)) {
        $error = "Short Description should not be empty";
    } else if (empty($image)) {
        $error = "Image is required";
    }
    if ($error == "") {
        $file = $_FILES['image']['tmp_name'];
        $file_name = $_FILES['image']['name'];
        $file_name_array = explode(".", $file_name);
        $extension = end($file_name_array);
        //we want to save the image with timestamp and randomnumber
        $new_image_name = time() . rand() . '.' . $extension;
        $allowed_extension = array("jpg", "gif", "png", "jpeg");
        $image_dir = '../../../';
        if (in_array($extension, $allowed_extension)) {
            move_uploaded_file($file, $image_dir . 'uploads/upload/' . $new_image_name);
            $cover_thumbnail1 = $image_dir . 'uploads/upload/thumbnail/' . $new_image_name;
            $resizeObj = new resize($image_dir . 'uploads/upload/' . $new_image_name);
            $resizeObj->resizeImage(50, 50, 'crop');
            $resizeObj->saveImage($cover_thumbnail1, 100);
        }
        //If new  Order order is Lower
        if ($video_order < $old_video_order) {
            $update_order = video_order_to_upper($old_video_order, $video_order, $connection_string);
        }
        //if new order is greater than older order
        else if ($video_order > $old_video_order) {
            $update_order = video_order_to_lower($old_video_order, $video_order, $connection_string);
        }
        //update after updating the order 
        $update_testimonial_query = "UPDATE `event_videos` SET`event_id`='$event_id',`video_title`='$title',`video_status`='$status',`video_embed_code`='$live_embed_code',`video_description`='$description',`video_image`='$file',`video_order`=$video_order,`free_video`='$free_access',`video_short_description`='$short_description',`thumbnail`='$cover_thumbnail1' WHERE `id`='$event_video_id'";
        $update_testimonial_query_result = mysqli_query($connection_string, $update_testimonial_query);
        if ($update_testimonial_query_result) {
            $success = "Event Video is updated successfully";
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
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Videos</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><span>Edit Video</span></li>
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
                                        <h5 class="">Edit Video</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="title">Title *</label>
                                                            <input type="text" class="form-control mb-4" id="title" required placeholder="Testimonial Name" value="<?php echo $title; ?>" name="title">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="image">Video Image *</label>
                                                            <input type="file" class="form-control mb-4" id="image" placeholder="" value="<?= $cover_thumbnail1 ?>" name="image">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="video_order">Video Order *</label>
                                                            <input type="text" class="form-control mb-4" required id="video_order" placeholder="Video Order" value="<?php echo $old_video_order ?>" name="video_order">

                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <select class="form-control" id="status" name="status">
                                                                <option <?php echo ($status == '1') ? "selected" : "" ?> value="1">Active</option>
                                                                <option <?php echo ($status == '0') ? "selected" : "" ?> value="0">Non Active</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="short_description">Short Description</label>
                                                            <textarea type="text" class="form-control mb-4" id="short_description" placeholder="Short Description" value="" required name="short_description"><?php echo  $short_description; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="events">Events</label>
                                                            <select class="form-control" id="events" name="events">
                                                                <?php foreach ($event_list_result as $event_info) { ?>
                                                                    <option value="<?php echo $event_info['event_id']; ?>" <?php echo ($event_info['event_id'] == $event_id) ? "selected" : "" ?>><?php echo $event_info['title']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="video_embed_code">Video Embed Code</label>
                                                            <textarea type="text" class="form-control mb-4" id="video_embed_code" placeholder="Video Embed Code" value="" required name="video_embed_code"><?php echo  $live_embed_code; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="detailed_description">Detailed Description</label>
                                                            <textarea type="text" class="form-control mb-4" id="detailed_description" placeholder="Detailed Description" value="" name="detailed_description" required><?php echo  $description; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 text-right mb-5">
                                                        <button id="add-work-platforms" type="submit" name="submit" class="btn btn-primary">Edit Video</button>
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