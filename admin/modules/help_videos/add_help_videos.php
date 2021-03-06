<?php
include '../../../include/config.php';
include '../../../include/functions.php';
include '../../includes/admin_auth.php';
$active_menu = "help_videos";
/*********************if admin is not logged in it will be re directed to index page */
if (empty($_SESSION['admin_info']) || ($_SESSION['admin_login'] === false)) {
    header('Location:../../index.php');
}
$error = $success = $video_description = $video_title = $video_embed_code =   "";
$status = 1;
// $help_videos_image ="";
/*********initialize all fields */
$page_title = "Add Help Videos ";

/*********when user click the add button it validate and then add new help_videos*/
if (isset($_POST['submit'])) {
    //Get Maximum Help_videos Order
    $maximum_help_videos_order = maximum_help_videos_order($connection_string);
    $help_videos_order  = $maximum_help_videos_order + 1;
    /**********call test input function to add slashes********/
    $video_title = test_input($_POST['video_title']);
    $status = test_input($_POST['status']);
    $video_description = test_input($_POST['video_description']);
    $video_embed_code = test_input($_POST['video_embed_code']);
    /***********validate if any required field is empty*******/
    if (empty($video_title)) {
        $error = 'Help video Title is required. ';
    } else if (empty($video_description)) {
        $error = 'video Description is required. ';
    } else if (empty($video_embed_code)) {
        $error = 'Video Embed Code is required. ';
    }
    /*********if there is no error in any field then insert data */
    if (empty($error)) {
        /***********insert data into table */
        $add_help_videos_query = "INSERT INTO `help_videos`(`video_title`,`video_embed_code`,`video_description`,`status`, `video_order`) VALUES ('$video_title','$video_embed_code','$video_description','$status','$help_videos_order')";
        $add_help_videos_query_result = mysqli_query($connection_string, $add_help_videos_query);
        if ($add_help_videos_query_result) {
            // $success = "Help VIdeo Added Successfully";
            header('Location:help_videos.php');
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
                            <li class="breadcrumb-item active" aria-current="page"><span>Add Help Video</span></li>
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
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">??</span></button>
                        <?= $error; ?>
                    </div>
                <?php } else if ($success != "") {
                ?>
                    <div class="alert text-center alert-success alert-dismissible " role="alert" style="width:50%; margin-left:23%; margin-right:25%;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">??</span></button>
                        <?= $success; ?>
                    </div>
                <?php } ?>
                <div class="account-content">
                    <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                <form id="contact" method="POST" class="section contact" enctype="multipart/form-data">
                                    <div class="info">
                                        <h5 class="" style="padding-left: 35px;">Add Help Video</h5>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="video_title">Video Title *</label>
                                                            <input type="text" class="form-control mb-4" id="video_title" placeholder="Video Title" value="<?php echo $video_title; ?>" name="video_title" required>

                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="help_videos_image">Help_videos Image *</label>
                                                            <input type="file" class="form-control mb-4" id="help_videos_image" placeholder="Last Name " value="<?php echo $help_videos_image; ?>" name="help_videos_image" required>
                                                        </div>
                                                    </div> -->
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
                                                            <label for="video_embed_code">Video Embed Code*</label>
                                                            <textarea type="text" rows="6" cols="8" class="form-control mb-4" id="video_embed_code" placeholder="Video Embed Code" value="" name="video_embed_code"><?php echo $video_embed_code; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="description">Description*</label>
                                                            <textarea type="text" class="form-control mb-4" id="description" placeholder="Detailed Description" value="" name="video_description"><?php echo $video_description; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 text-right mb-5">
                                                        <a href="add_user_registration.php"><button id="add-work-platforms" name="submit" class="btn btn-primary">Add Video</button></a>
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