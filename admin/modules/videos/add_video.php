<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../../include/resize-class.php';
include '../../includes/admin_auth.php';
$active_menu = "video";
$page_title = "Add Videos ";;
$meta_description = "showcase";
$error = $success = $title = $video_embed_code = $description = $video_image = $short_decription = "";
$free_access = $events = $status = 1;
/********get event list */
$event_list = get_events_info($connection_string);
$event_list_result = $event_list['get_info'];
/********get maximum order *******/
$max_order = get_maximum_order($connection_string, "event_videos", "video_order");
$maximum_order_value = $max_order + 1;
/**********when user click on Add Video Button validate input filds then upload image and then insert data into database */
if (isset($_POST['submit'])) {
    /*******Validate Input Fields */
    $title = test_input($_POST['title']);
    $video_embed_code = test_input($_POST['video_embed_code']);
    $description = test_input($_POST['description']);
    $short_decription = test_input($_POST['short_decription']);
    $video_image = $_FILES['video_image']['name'];
    $free_access = $_POST['free_access'];
    $events = $_POST['events'];
    $status = $_POST['status'];
    /*******check if the required fields are empty */
    if (strlen($title) < 5 || strlen($title) > 200) {
        $error = "Title Should be in 5 to 200 Chracters";
    } elseif (empty($video_embed_code)) {
        $error = "Video Embed Code should not be Empty";
    } elseif (empty($description)) {
        $error = "Description Should Not Be Empty";
    } elseif (empty($video_image)) {
        $error = "Video Image Should Not be empty";
    } elseif (empty($short_decription)) {
        $error = "Short Description Should Not be empty";
    }
    /********if there is no  Error ******/
    if ($error == "") {

        // Upload image after verifying then resize and store image thumbnail//
        $file = $_FILES['video_image']['tmp_name'];
        $file_name = $_FILES['video_image']['name'];
        $file_name_array = explode(".", $file_name);
        $extension = end($file_name_array);
        //we want to save the image with timestamp and randomnumber
        $new_image_name = time() . rand() . '.' . $extension;
        $allowed_extension = array("jpg", "gif", "png", "jpeg");
        $image_dir = '../../../';
        if (in_array($extension, $allowed_extension)) {
            move_uploaded_file($file, $image_dir . 'uploads/video_images/' . $new_image_name);
            $cover_thumbnail1 = $image_dir . 'uploads/video_images/thumbnail/' . $new_image_name;
            $resizeObj = new resize($image_dir . 'uploads/video_images/' . $new_image_name);
            $resizeObj->resizeImage(50, 50, 'crop');
            $resizeObj->saveImage($cover_thumbnail1, 100);
        }
        //Insert data into data base
        $insert_video_query = "INSERT INTO `event_videos`(`event_id`, `video_title`, `video_status`, `video_embed_code`, `video_description`, `video_image`, `video_order`, `free_video`, `video_short_description`,`thumbnail`) VALUES ('$events','$title','$status','$video_embed_code','$description','$new_image_name','$maximum_order_value','$free_access','$short_decription','$cover_thumbnail1')";
        $insert_video_query_result = mysqli_query($connection_string, $insert_video_query);
        if ($insert_video_query_result) {
            header('Location:videos.php');
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
                            <li class="breadcrumb-item active" aria-current="page"><span>Add Video</span></li>
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
                                        <h5 class="">Add Video</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="title">Title *</label>
                                                            <input type="text" class="form-control mb-4" id="title" placeholder="Title " value="<?php echo $title; ?>" name="title" required>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="events">Events</label>
                                                            <select class="form-control" id="events" name="events">
                                                                <?php foreach ($event_list_result as $event_info) { ?>
                                                                    <option value="<?php echo $event_info['event_id']; ?>">
                                                                        <?php echo $event_info['title']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <select class="form-control" id="status" name="status">
                                                                <option value="<?php echo $status; ?>">Active</option>
                                                                <option value="0">Non Active</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="free_access">Free Access</label>
                                                            <select class="form-control" id="free_access" name="free_access">
                                                                <option value="<?php echo $free_access; ?>">Active
                                                                </option>
                                                                <option value="0">Non Active</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="video_image">Video Image *</label>
                                                            <input type="file" class="form-control mb-4" id="video_image" placeholder="Last Name " value="<?php echo $video_image; ?>" name="video_image" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="video_embed_code">Video Embed Code *</label>
                                                            <textarea type="text" class="form-control mb-4" id="video_embed_code" placeholder="Video Embed Code" value="" name="video_embed_code" required><?php echo $video_embed_code; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="short_decription">Short Description *</label>
                                                            <textarea type="text" class="form-control mb-4" id="short_decription" placeholder="Short Desription" value="" name="short_decription" required><?php echo $short_decription; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="description">Detailed Description *</label>
                                                            <textarea type="text" class="form-control mb-4" id="description" placeholder="Detailed Description" value="" name="description" required><?php echo $description; ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 text-right mb-5">
                                                        <a href="add_videos.php"><button id="add-work-platforms" name="submit" class="btn btn-primary">Add
                                                                Video</button></a>
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
                CKEDITOR.replace('description', {
                    filebrowserUploadUrl: '../../upload.php',
                    filebrowserUploadMethod: "form"
                });
            </script>
            <!-- FOOTER END -->